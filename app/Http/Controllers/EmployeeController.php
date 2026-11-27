<?php

namespace App\Http\Controllers;

use App\Models\Absence;
use App\Models\Employment;
use App\Models\EmploymentDivision;
use App\Models\EmploymentRole;
use App\Models\EmploymentStatus;
use App\Models\HistoryLeave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Yajra\DataTables\Facades\DataTables;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Employment::with(['employmentRole', 'employmentStatus', 'employmentDivision']);

            return DataTables::eloquent($data)
                ->addIndexColumn()
                ->addColumn('name', function ($row) {
                    $imageUrl = $row->image_path
                        ? asset('images/employment/' . $row->image_path)
                        : ($row->gender == 'Pria'
                            ? asset('images/user/1.jpg')
                            : asset('images/user/2.jpg'));

                    return '<div class="d-flex align-items-center">
                                <div class="h-avatar is-medium mr-3">
                                    <img class="avatar rounded-circle" src="' . $imageUrl . '" style="width: 40px; height: 40px; object-fit: cover;">
                                </div>
                                <div>
                                    <div class="font-weight-bold">' . e($row->name) . '</div>
                                    <p class="m-0 text-secondary small">' . e($row->employmentRole->name) . '</p>
                                </div>
                            </div>';
                })
                ->addColumn('email', function ($row) {
                    return e($row->email);
                })
                ->addColumn('phone', function ($row) {
                    return e($row->phone);
                })
                ->addColumn('status', function ($row) {
                    return e($row->employmentStatus->name);
                })
                ->addColumn('action', function ($row) {
                    $viewUrl = route('employee.show', $row->nik);
                    $editUrl = route('employee.edit', $row->nik);
                    $deleteUrl = route('employee.destroy', $row->nik);

                    return '<div class="d-flex align-items-center">
                                <a href="' . $viewUrl . '" class="mr-2" data-toggle="tooltip" title="View">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="text-secondary" width="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                                <a href="' . $editUrl . '" class="mr-2" data-toggle="tooltip" title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="text-secondary" width="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                    </svg>
                                </a>
                                <a href="javascript:void(0)" class="delete-btn" data-url="' . $deleteUrl . '" data-toggle="tooltip" title="Delete">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="text-danger" width="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </a>
                            </div>';
                })
                ->filterColumn('name', function($query, $keyword) {
                    $query->where('name', 'like', "%{$keyword}%");
                })
                ->filterColumn('email', function($query, $keyword) {
                    $query->where('email', 'like', "%{$keyword}%");
                })
                ->filterColumn('phone', function($query, $keyword) {
                    $query->where('phone', 'like', "%{$keyword}%");
                })
                ->filterColumn('status', function($query, $keyword) {
                    $query->whereHas('employmentStatus', function($q) use ($keyword) {
                        $q->where('name', 'like', "%{$keyword}%");
                    });
                })
                ->rawColumns(['name', 'action'])
                ->make(true);
        }

        return view('employee.index');
    }

    public function show($employmentNik)
    {
        $employment = Employment::where('nik', $employmentNik)->first();
        $historyLeaves = HistoryLeave::where('employment_id', $employment->id)->get();
        $absences = Absence::latest()->paginate(5);
        return view('employee.show', compact(['employment', 'historyLeaves', 'absences']));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'required|in:Pria,Wanita',
            'nik' => 'required|numeric|digits:16|unique:employments,nik',
            'email' => 'nullable|email|unique:employments,email',
            'phone' => 'nullable|numeric',
            'employment_status' => 'required|exists:employment_statuses,id',
            'employment_division' => 'required|exists:employment_divisions,id',
            'employment_role' => 'required|exists:employment_roles,id',
            'leave_quota' => 'required|numeric|min:0|max:365',
            'no_account' => 'nullable|numeric',
            'ptkp_status' => 'nullable|string|in:TK/0,TK/1,TK/2,TK/3,K/0,K/1,K/2,K/3',
            'image' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'date_of_birth' => 'nullable|date|before:today',
            'date_start_of_work' => 'nullable|date',
            'zip_code' => 'nullable|numeric|digits_between:5,6',
        ], [
            'nik.required' => 'NIK wajib diisi.',
            'nik.numeric' => 'NIK harus berupa angka.',
            'nik.digits' => 'NIK harus 16 digit.',
            'nik.unique' => 'NIK sudah terdaftar.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'employment_status.required' => 'Status karyawan wajib dipilih.',
            'employment_division.required' => 'Divisi wajib dipilih.',
            'employment_role.required' => 'Jabatan wajib dipilih.',
            'leave_quota.required' => 'Jumlah cuti wajib diisi.',
            'leave_quota.min' => 'Jumlah cuti minimal 0.',
            'leave_quota.max' => 'Jumlah cuti maksimal 365 hari.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Format gambar harus jpeg, jpg, atau png.',
            'image.max' => 'Ukuran gambar maksimal 2MB.',
            'date_of_birth.before' => 'Tanggal lahir harus sebelum hari ini.',
        ]);

        $imageName = saveImage('employment', $request->file('image'));
        $formatedPhoneNumber = $request->input('phone') ? convertPhoneNumber($request->input('phone')) : '';
        $data = [
            'name' => $request->input('name'),
            'gender' => $request->input('gender'),
            'place_of_birth' => $request->input('place_of_birth'),
            'date_of_birth' => $request->input('date_of_birth'),
            'type_of_blood' => $request->input('type_of_blood'),
            'nik' => $request->input('nik'),
            'email' => $request->input('email'),
            'phone' => $formatedPhoneNumber,
            'religion' => $request->input('religion'),
            'country' => $request->input('country'),
            'region' => $request->input('region'),
            'zip_code' => $request->input('zip_code'),
            'address' => $request->input('address'),
            'date_start_of_work' => $request->input('date_start_of_work'),
            'employment_status_id' => $request->input('employment_status'),
            'employment_division_id' => $request->input('employment_division'),
            'employment_role_id' => $request->input('employment_role'),
            'image_path' => $imageName,
            'leave_quota' => $request->input('leave_quota'),
            'no_account' => $request->input('no_account'),
            'ptkp_status' => $request->input('ptkp_status', 'TK/0'),
        ];

        Employment::create($data);

        return redirect()->route('employee.index')->with('success', 'Data Karyawan berhasil ditambah');
    }

    public function create()
    {
        $employmentStatuses = EmploymentStatus::all();
        $employmentRoles = EmploymentRole::all();
        $employmentDivisions = EmploymentDivision::all();

        return view('employee.create', compact(['employmentStatuses', 'employmentRoles', 'employmentDivisions']));
    }

    public function edit()
    {
        $employmentStatuses = EmploymentStatus::all();
        $employmentRoles = EmploymentRole::all();
        $employmentDivisions = EmploymentDivision::all();

        $employeeNik = Route::current()->parameter('employee');
        $employment = Employment::where('nik', $employeeNik)->first();
        $employment->phone = remove62PhoneNumber($employment->phone);
        return view('employee.edit', compact(['employment', 'employmentStatuses', 'employmentRoles', 'employmentDivisions']));
    }

    public function update(Request $request, $employmentNik)
    {
        $employment = Employment::where('nik', $employmentNik)->first();

        if (!$employment) {
            return redirect()->route('employee.index')
                ->with('error', 'Data karyawan tidak ditemukan');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'required|in:Pria,Wanita',
            'nik' => 'required|numeric|digits:16|unique:employments,nik,' . $employment->id,
            'email' => 'nullable|email|unique:employments,email,' . $employment->id,
            'phone' => 'nullable|numeric',
            'employment_status' => 'required|exists:employment_statuses,id',
            'employment_division' => 'required|exists:employment_divisions,id',
            'employment_role' => 'required|exists:employment_roles,id',
            'leave_quota' => 'required|numeric|min:0|max:365',
            'no_account' => 'nullable|numeric',
            'ptkp_status' => 'nullable|string|in:TK/0,TK/1,TK/2,TK/3,K/0,K/1,K/2,K/3',
            'image' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'date_of_birth' => 'nullable|date|before:today',
            'date_start_of_work' => 'nullable|date',
            'zip_code' => 'nullable|numeric|digits_between:5,6',
        ], [
            'nik.required' => 'NIK wajib diisi.',
            'nik.numeric' => 'NIK harus berupa angka.',
            'nik.digits' => 'NIK harus 16 digit.',
            'nik.unique' => 'NIK sudah terdaftar.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'employment_status.required' => 'Status karyawan wajib dipilih.',
            'employment_division.required' => 'Divisi wajib dipilih.',
            'employment_role.required' => 'Jabatan wajib dipilih.',
            'leave_quota.required' => 'Jumlah cuti wajib diisi.',
            'leave_quota.min' => 'Jumlah cuti minimal 0.',
            'leave_quota.max' => 'Jumlah cuti maksimal 365 hari.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Format gambar harus jpeg, jpg, atau png.',
            'image.max' => 'Ukuran gambar maksimal 2MB.',
            'date_of_birth.before' => 'Tanggal lahir harus sebelum hari ini.',
        ]);

        if ($request->hasFile('image')) {
            $imageName = saveImage('employment', $request->file('image'));
            $employment->image_path = $imageName;
        }

        $formatedPhoneNumber = $request->input('phone') ? convertPhoneNumber($request->input('phone')) : '';

        $employment->update([
            'name' => $request->input('name'),
            'gender' => $request->input('gender'),
            'place_of_birth' => $request->input('place_of_birth'),
            'date_of_birth' => $request->input('date_of_birth'),
            'type_of_blood' => $request->input('type_of_blood'),
            'nik' => $request->input('nik'),
            'email' => $request->input('email'),
            'phone' => $formatedPhoneNumber,
            'religion' => $request->input('religion'),
            'country' => $request->input('country'),
            'region' => $request->input('region'),
            'zip_code' => $request->input('zip_code'),
            'address' => $request->input('address'),
            'date_start_of_work' => $request->input('date_start_of_work'),
            'employment_status_id' => $request->input('employment_status'),
            'employment_division_id' => $request->input('employment_division'),
            'employment_role_id' => $request->input('employment_role'),
            'leave_quota' => $request->input('leave_quota'),
            'no_account' => $request->input('no_account'),
            'ptkp_status' => $request->input('ptkp_status', 'TK/0'),
        ]);

        return redirect()->route('employee.index')
            ->with('success', 'Data karyawan berhasil di update');
    }

    public function destroy($employmentNik)
    {
        $employment = Employment::where('nik', $employmentNik)->first();

        if ($employment) {
            $employment->delete();
            return redirect()->route('employee.index')->with('success', 'Data karyawan Berhasil di hapus');
        } else {
            return redirect()->route('employee.index')->with('error', 'Data karyawan tidak ditemukan');
        }
    }
}
