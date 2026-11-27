<?php

namespace App\Http\Controllers;

use App\Imports\AbsenceImports;
use App\Models\Absence;
use App\Models\Employment;
use Exception;
use Illuminate\Http\Request;

class AbsenceController extends Controller
{
    public function index(Request $request)
    {
        $date_in = $request->input('date_in');

        $query = Absence::with(['employment.employmentRole', 'employment.employmentDivision'])->latest();

        if ($date_in) {
            $query->where('date_in', $date_in);
        }

        $absences = $query->paginate(15);

        return view('absence.index', compact('absences', 'date_in'))
            ->with('i', (request()->input('page', 1) - 1) * 15);
    }

    public function scan()
    {
        $employments = Employment::with('employmentRole', 'employmentDivision')->orderBy('name')->get();

        foreach ($employments as $emp) {
            $emp->photo_url = null;
            if ($emp->image_path) {
                if (file_exists(public_path('images/employment/' . $emp->image_path))) {
                    $emp->photo_url = asset('images/employment/' . $emp->image_path);
                } elseif (file_exists(public_path('images/absence/' . $emp->image_path))) {
                    $emp->photo_url = asset('images/absence/' . $emp->image_path);
                }
            }
        }

        $enrolledEmployees = $employments->filter(function ($emp) {
            return !empty($emp->face_descriptor);
        })->values();

        $pendingPhotoEmployees = $employments->filter(function ($emp) {
            return !empty($emp->photo_url) && empty($emp->face_descriptor);
        })->values();

        $todayAbsences = Absence::with('employment')
            ->where('date_in', date('Y-m-d'))
            ->latest()
            ->take(10)
            ->get();

        return view('absence.scan', compact('employments', 'enrolledEmployees', 'pendingPhotoEmployees', 'todayAbsences'));
    }

    public function enrollFace(Request $request)
    {
        $request->validate([
            'nik' => 'required',
            'descriptor' => 'required',
        ]);

        $employment = Employment::where('nik', $request->input('nik'))
            ->orWhere('id', $request->input('nik'))
            ->first();

        if (!$employment) {
            return response()->json([
                'success' => false,
                'message' => 'Data karyawan tidak ditemukan.'
            ], 404);
        }

        $imageName = $employment->image_path;
        if ($request->filled('image')) {
            $imageName = $this->saveBase64Image($request->input('image'), 'enroll_' . $employment->nik);
        }

        $descriptor = $request->input('descriptor');
        if (is_array($descriptor)) {
            $descriptor = json_encode($descriptor);
        }

        $employment->update([
            'face_descriptor' => $descriptor,
            'image_path' => $imageName ?? $employment->image_path
        ]);

        return response()->json([
            'success' => true,
            'message' => "Wajah {$employment->name} ({$employment->nik}) berhasil didaftarkan ke sistem biometrik!",
            'data' => [
                'nik' => $employment->nik,
                'name' => $employment->name,
                'face_descriptor' => $descriptor,
                'image' => $imageName ? asset('images/absence/' . $imageName) : null
            ]
        ]);
    }

    public function resetFace(Request $request)
    {
        $nik = $request->input('nik') ?? $request->nik;

        if (!$nik) {
            return response()->json([
                'success' => false,
                'message' => 'NIK karyawan tidak ditemukan.'
            ], 422);
        }

        $employment = Employment::where('nik', $nik)
            ->orWhere('id', $nik)
            ->first();

        if (!$employment) {
            return response()->json([
                'success' => false,
                'message' => 'Data karyawan tidak ditemukan.'
            ], 404);
        }

        $employment->update(['face_descriptor' => null]);

        return response()->json([
            'success' => true,
            'message' => "Data biometrik wajah {$employment->name} ({$employment->nik}) berhasil direset.",
            'data' => [
                'nik' => $employment->nik
            ]
        ]);
    }

    public function webCheckIn(Request $request)
    {
        $request->validate([
            'nik' => 'required',
            'type' => 'required|in:in,out',
        ]);

        $employment = Employment::where('nik', $request->input('nik'))
            ->orWhere('id', $request->input('nik'))
            ->first();

        if (!$employment) {
            return response()->json([
                'success' => false,
                'message' => 'Data karyawan dengan NIK / ID tersebut tidak ditemukan.'
            ], 404);
        }

        $today = date('Y-m-d');
        $timeNow = date('H:i:s');
        $type = $request->input('type');

        // Handle snapshot image if present
        $imageName = null;
        if ($request->filled('image')) {
            $imageName = $this->saveBase64Image($request->input('image'), $employment->nik);
        }

        $absence = Absence::where('employment_id', $employment->id)
            ->where('date_in', $today)
            ->first();

        if ($type === 'in') {
            if ($absence && $absence->time_in) {
                return response()->json([
                    'success' => false,
                    'message' => "{$employment->name} sudah melakukan presensi masuk hari ini pada pukul {$absence->time_in}."
                ], 422);
            }

            $status = ($timeNow > '08:30:00') ? 'Terlambat' : 'Hadir';

            if ($absence) {
                $absence->update([
                    'time_in' => $timeNow,
                    'method' => 'camera',
                    'status' => $status,
                    'image_path' => $imageName ?? $absence->image_path
                ]);
            } else {
                $absence = Absence::create([
                    'employment_id' => $employment->id,
                    'date_in' => $today,
                    'time_in' => $timeNow,
                    'time_out' => null,
                    'method' => 'camera',
                    'status' => $status,
                    'image_path' => $imageName
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => "Presensi MASUK berhasil! Selamat bekerja, {$employment->name}.",
                'data' => [
                    'name' => $employment->name,
                    'nik' => $employment->nik,
                    'time' => $timeNow,
                    'status' => $status,
                    'type' => 'Masuk',
                    'image' => $imageName ? asset('images/absence/' . $imageName) : null
                ]
            ]);
        } else {
            // Type == 'out' (Pulang)
            if ($absence) {
                $absence->update([
                    'time_out' => $timeNow,
                    'image_path' => $imageName ?? $absence->image_path
                ]);
            } else {
                $absence = Absence::create([
                    'employment_id' => $employment->id,
                    'date_in' => $today,
                    'time_in' => null,
                    'time_out' => $timeNow,
                    'method' => 'camera',
                    'status' => 'Hadir',
                    'image_path' => $imageName
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => "Presensi PULANG berhasil! Terima kasih atas kerja keras Anda hari ini, {$employment->name}.",
                'data' => [
                    'name' => $employment->name,
                    'nik' => $employment->nik,
                    'time' => $timeNow,
                    'type' => 'Pulang',
                    'image' => $imageName ? asset('images/absence/' . $imageName) : null
                ]
            ]);
        }
    }

    public function apiCheckIn(Request $request)
    {
        $request->validate([
            'nik' => 'required',
            'type' => 'required|in:in,out',
        ]);

        $employment = Employment::where('nik', $request->input('nik'))->first();
        if (!$employment) {
            return response()->json([
                'success' => false,
                'message' => 'Employee with NIK ' . $request->input('nik') . ' not found.'
            ], 404);
        }

        $today = date('Y-m-d');
        $timeNow = $request->input('time') ?: date('H:i:s');
        $type = $request->input('type');

        $imageName = null;
        if ($request->filled('image')) {
            $imageName = $this->saveBase64Image($request->input('image'), $employment->nik);
        }

        $absence = Absence::where('employment_id', $employment->id)->where('date_in', $today)->first();

        if ($type === 'in') {
            $status = ($timeNow > '08:30:00') ? 'Terlambat' : 'Hadir';
            if ($absence) {
                $absence->update([
                    'time_in' => $timeNow,
                    'method' => 'api_vision',
                    'status' => $status,
                    'image_path' => $imageName ?? $absence->image_path
                ]);
            } else {
                $absence = Absence::create([
                    'employment_id' => $employment->id,
                    'date_in' => $today,
                    'time_in' => $timeNow,
                    'time_out' => null,
                    'method' => 'api_vision',
                    'status' => $status,
                    'image_path' => $imageName
                ]);
            }
        } else {
            if ($absence) {
                $absence->update([
                    'time_out' => $timeNow,
                    'image_path' => $imageName ?? $absence->image_path
                ]);
            } else {
                $absence = Absence::create([
                    'employment_id' => $employment->id,
                    'date_in' => $today,
                    'time_in' => null,
                    'time_out' => $timeNow,
                    'method' => 'api_vision',
                    'status' => 'Hadir',
                    'image_path' => $imageName
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Attendance successfully recorded for ' . $employment->name,
            'data' => [
                'nik' => $employment->nik,
                'name' => $employment->name,
                'type' => $type,
                'date' => $today,
                'time' => $timeNow,
            ]
        ]);
    }

    private function saveBase64Image($base64String, $nik)
    {
        try {
            $image = preg_replace('/^data:image\/\w+;base64,/', '', $base64String);
            $image = str_replace(' ', '+', $image);
            $imageData = base64_decode($image);

            $dir = public_path('images/absence');
            if (!\Illuminate\Support\Facades\File::exists($dir)) {
                \Illuminate\Support\Facades\File::makeDirectory($dir, 0777, true, true);
            }

            $filename = time() . '_' . $nik . '.jpg';
            file_put_contents($dir . '/' . $filename, $imageData);
            return $filename;
        } catch (\Exception $e) {
            return null;
        }
    }

    public function show($employmentNik)
    {
    }

    public function create()
    {
        return redirect()->route('absence.scan');
    }

    public function edit()
    {
    }

    public function update(Request $request, $employmentNik)
    {
    }

    public function destroy($id)
    {
        $absence = Absence::find($id);
        if ($absence) {
            $absence->delete();
            return redirect()->back()->with('success', 'Data absensi berhasil dihapus.');
        }
        return redirect()->back()->with('error', 'Data absensi tidak ditemukan.');
    }

    public function store(Request $request)
    {
        try {
            $csvFile = $request->file('file');
            if ($csvFile) {
                $csvResource = fopen($csvFile, 'r'); // Open the CSV resource for reading

                if ($csvResource) {
                    for ($i = 0; $i < 2; $i++) {
                        fgetcsv($csvResource); // Read and discard the row
                    }
                    $nik = null;
                    $base_tanggal = null;
                    $tanggal = null;
                    $waktu_masuk = null;
                    $waktu_keluar = null;
                    while (($row = fgetcsv($csvResource)) !== false) {
                        $col = explode(";", $row[0]);
                        if (explode(" ", $row[0])[0] == 'From:') {
                            $base_tanggal = explode(" ", $row[0])[1];
                            $base_tanggal = substr($base_tanggal, 0, -2); // Remove the last 3 characters
                        }
                        if ($col[0] == 'Person ID') {
                            $nik = $col[1];
                        }
                        if ($col[0] == 'Date') {
                            $tanggal = $col;
                        }
                        if ($col[0] == 'Check-in1') {
                            $waktu_masuk = $col;
                        }
                        if ($col[0] == 'Check-out1') {
                            $waktu_keluar = $col;
                        }
                        if ($col[0] == 'Summary') {
                            $employment = Employment::where('nik', $nik)->first();
                            if ($employment) {
                                for ($i = 8; $i < sizeof($tanggal); $i++) {
                                    if ($tanggal[$i] != '-' && ($waktu_masuk[$i] != '-' || $waktu_keluar[$i] != '-')) {
                                        $modified_date = $base_tanggal . str_pad($tanggal[$i], 2, '0', STR_PAD_LEFT);
                                        $isAbsenceExist = Absence::where('employment_id', $employment->id)->where('date_in', $modified_date)->first();
                                        if (!$isAbsenceExist) {
                                            $waktu_masuk[$i] = $waktu_masuk[$i] == '-' ? null : $waktu_masuk[$i];
                                            $waktu_keluar[$i] = $waktu_keluar[$i] == '-' ? null : $waktu_keluar[$i];
                                            Absence::create(['employment_id' => $employment->id, 'date_in' => $modified_date, 'time_in' => $waktu_masuk[$i], 'time_out' => $waktu_keluar[$i]]);
                                        }
                                    }
                                }
                            }
                        }
                    }

                    fclose($csvResource); // Close the CSV resource
                    return redirect()->route('absence.index')->with('success', 'Data Absensi berhasil diupload');
                }
            }
        } catch (Exception $exception) {
            return redirect()->route('absence.index')->with('error', 'Data Absensi Gagal diupload ' . $exception->getMessage());
        }
    }


}
