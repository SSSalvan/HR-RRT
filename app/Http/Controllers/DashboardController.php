<?php

namespace App\Http\Controllers;

use App\Models\Employment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Fetch employments
        $employments = Employment::whereDate('date_start_of_work', '>=', now()->subWeek())->get();
        $totalEmployments = Employment::count();

        // Fetch public holidays safely with fallback
        $publicHolidays = [];
        try {
            $currentYear = now()->year;
            $url = "https://api-harilibur.vercel.app/api?year={$currentYear}";

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
            curl_setopt($ch, CURLOPT_TIMEOUT, 3);
            $response = curl_exec($ch);
            curl_close($ch);

            $decoded = json_decode($response, true);
            if (is_array($decoded)) {
                $currentDate = now();
                $filteredHolidays = [];

                foreach ($decoded as $item) {
                    if (!empty($item['holiday_date'])) {
                        $date = Carbon::createFromFormat('Y-m-d', $item['holiday_date']);
                        if ($date && $date->gte($currentDate)) {
                            $item['day_of_week'] = $date->format('D');
                            $filteredHolidays[] = $item;
                        }
                    }
                }

                usort($filteredHolidays, function ($a, $b) {
                    return strcmp($a['holiday_date'], $b['holiday_date']);
                });

                $publicHolidays = $filteredHolidays;
            }
        } catch (\Throwable $e) {
            $publicHolidays = [];
        }

        return view('dashboard', compact('employments', 'totalEmployments', 'publicHolidays'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }


    public function show($id)
    {
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
    }

    public function edit()
    {
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {
    }

}
