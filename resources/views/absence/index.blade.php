@extends('layouts.app') <!-- Extend the main template -->

@section('content')
    <div class="content-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="d-flex flex-wrap align-items-center justify-content-between my-schedule mb-4">
                        <div class="d-flex align-items-center justify-content-between">
                            <h4 class="font-weight-bold">Daftar Absensi</h4>
                        </div>
                        <div class="d-flex align-items-center">
                            <a href="{{ route('absence.scan') }}" class="btn btn-success font-weight-bold mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-camera mr-1" viewBox="0 0 16 16">
                                    <path d="M15 12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1h1.172a3 3 0 0 0 2.12-.879l.83-.828A1 1 0 0 1 7.829 3h.342a1 1 0 0 1 .707.293l.828.828A3 3 0 0 0 11.828 5H13a1 1 0 0 1 1 1v6zM2 4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1.172a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 9.172 2H6.828a2 2 0 0 0-1.414.586l-.828.828A2 2 0 0 1 3.172 4H2z"/>
                                    <path d="M8 11a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5zm0 1a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7zM3 6.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0z"/>
                                </svg>
                                Presensi Kamera
                            </a>
                            <form action="{{route('absence.store')}}" method="POST" enctype="multipart/form-data" class="d-flex align-items-center">
                                @csrf
                                <label for="images" class="drop-container mr-2 mb-0" id="dropcontainer" style="padding: 6px 12px;">
                                    <span class="drop-title" style="font-size: 13px;">Upload CSV Mesin Absen</span>
                                    <input type="file" name="file" id="file" accept=".csv" required>
                                </label>
                                <button type="submit" class="btn btn-outline-primary btn-sm font-weight-bold">
                                    Upload
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card card-block card-stretch">
                                <div class="card-body p-0">
                                    <div class="d-flex justify-content-between align-items-center p-3">
                                        <h5 class="font-weight-bold">Absence List</h5>
                                        <form method="GET" action="{{ route('absence.index') }}">
                                            <label for="date_filter"
                                                   class="form-label font-weight-bold text-muted text-uppercase">Filter
                                                by Date:</label>
                                            <input type="date" class="form-control" id="date_filter" name="date_in"
                                                   placeholder="Masukan Filter Tanggal"
                                                   autocomplete="off" data-date-format="d-m-Y"
                                                   value="{{ request()->input('date_in') }}">
                                        </form>
                                        <button class="btn btn-secondary btn-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                 fill="currentColor" class="bi bi-printer" viewBox="0 0 16 16">
                                                <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
                                                <path
                                                        d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z"/>
                                            </svg>
                                            Print
                                        </button>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table data-table mb-0">
                                            <thead class="table-color-heading">
                                            <tr class="">
                                                <th scope="col">Karyawan</th>
                                                <th scope="col">Foto Presensi</th>
                                                <th scope="col">Divisi</th>
                                                <th scope="col">Tanggal</th>
                                                <th scope="col">Jam Masuk</th>
                                                <th scope="col">Jam Keluar</th>
                                                <th scope="col">Metode / Status</th>
                                                <th scope="col">Aksi</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($absences as $absence)
                                                <tr class="white-space-no-wrap">
                                                    <td>
                                                        <div class="active-project-1 d-flex align-items-center mt-0 ">
                                                            <div class="h-avatar is-medium">
                                                                @if($absence->employment->image_path != '')
                                                                    <img class="avatar rounded-circle"
                                                                         src={{asset('images/employment/'.$absence->employment->image_path)}}>
                                                                @else
                                                                    @if($absence->employment->gender == 'Pria')
                                                                        <img class="avatar rounded-circle"
                                                                             src={{asset('images/user/1.jpg')}}>
                                                                    @else
                                                                        <img class="avatar rounded-circle"
                                                                             src={{asset('images/user/2.jpg')}}>
                                                                    @endif
                                                                @endif
                                                            </div>
                                                            <div class="data-content ml-2">
                                                                <span class="font-weight-bold d-block">{{$absence->employment->name}}</span>
                                                                <small class="text-secondary">{{$absence->employment->nik}}</small>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        @if($absence->image_path)
                                                            <img src="{{ asset('images/absence/' . $absence->image_path) }}" alt="Snapshot" class="rounded shadow-sm" width="48" height="48" style="object-fit: cover;">
                                                        @else
                                                            <span class="text-muted small">-</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        {{$absence->employment->employmentDivision->name ?? '-'}}
                                                    </td>
                                                    <td>
                                                        {{dateIndo($absence->date_in)}}
                                                    </td>
                                                    <td>
                                                        <span class="badge badge-success">{{$absence->time_in ?? '-'}}</span>
                                                    </td>
                                                    <td>
                                                        <span class="badge badge-warning text-white">{{$absence->time_out ?? '-'}}</span>
                                                    </td>
                                                    <td>
                                                        @if($absence->method === 'camera')
                                                            <span class="badge badge-primary">Kamera Live</span>
                                                        @elseif($absence->method === 'api_vision')
                                                            <span class="badge badge-info">AI Vision</span>
                                                        @else
                                                            <span class="badge badge-secondary">CSV Mesin</span>
                                                        @endif

                                                        @if($absence->status === 'Terlambat')
                                                            <span class="badge badge-danger ml-1">Terlambat</span>
                                                        @elseif($absence->status === 'Hadir')
                                                            <span class="badge badge-success ml-1">Tepat Waktu</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <form action="{{ route('absence.destroy', $absence->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data absensi ini?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                                                    <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                                                </svg>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="p-3 d-flex justify-content-between align-items-center">
                                        <small class="text-muted">Menampilkan {{ $absences->firstItem() ?? 0 }} s.d. {{ $absences->lastItem() ?? 0 }} dari total {{ $absences->total() }} data</small>
                                        {{ $absences->appends(request()->query())->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var dateFilter = document.getElementById('date_filter');
            dateFilter.addEventListener('change', function () {
                this.form.submit();
            });
        });
    </script>
@endsection
