@extends('layouts.app') <!-- Extend the main template -->

@section('content')
    <style>
        .btn-group .btn input[type="radio"] {
            display: none; /* Hide the radio input */
        }

        .btn-group .btn.active {
            background-color: #007bff; /* Change the active button background color to primary */
            color: #fff; /* Change the text color for the active button */
        }
    </style>
    <div id="remoteModelData" class="modal fade" role="dialog"></div>
    <div class="content-page">
        <div class="container-fluid">
            <div class="row">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <!-- Display error message if it exists -->
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                <div class="col-lg-12">
                    <div class="d-flex flex-wrap align-items-center justify-content-between mb-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb p-0 mb-0">
                                    <li class="breadcrumb-item"><a href="{{url('benefit')}}">Benefit</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Detail Benefit</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 mb-3 d-flex justify-content-between">
                    <h4 class="font-weight-bold d-flex align-items-center">Detail Benefit</h4>
                    <a href="{{url('employee')}}"
                       class="btn btn-primary btn-sm d-flex align-items-center justify-content-between ml-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                  d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                                  clip-rule="evenodd"/>
                        </svg>
                        <span class="ml-2">Kembali</span>
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <div>
                                    <ul class="list-style-1 mb-0">
                                        <li class="list-item d-flex justify-content-start align-items-center">
                                            <div class="avatar">
                                                <img class="avatar avatar-img avatar-60 rounded-circle"
                                                     src="{{asset('images/user/1.jpg')}}" alt="01.jpg"/>
                                            </div>
                                            <div class="list-style-detail ml-4 mr-2">
                                                <h5 class="font-weight-bold">{{$employment->name}}</h5>
                                                <p class="mb-0 mt-1 text-muted">{{$employment->employmentRole->name}}
                                                    - {{$employment->employmentDivision->name}}</p>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-12 text-center">
                                        <form method="GET"
                                              action="{{ route('benefit.export', $employment->nik) }}">
                                            @csrf
                                            <input type="hidden" name="periode" value="{{$benefit->periode}}">
                                            <div class="btn-group">
                                                <button type="submit" name="format" value="pdf"
                                                        class="btn btn-danger btn-sm">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                         fill="currentColor" class="bi bi-file-pdf" viewBox="0 0 16 16">
                                                        <path d="M4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H4zm0 1h8a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1z"/>
                                                        <path d="M4.603 12.087a.81.81 0 0 1-.438-.42c-.195-.388-.13-.776.08-1.102.198-.307.526-.568.897-.787a7.68 7.68 0 0 1 1.482-.645 19.701 19.701 0 0 0 1.062-2.227 7.269 7.269 0 0 1-.43-1.295c-.086-.4-.119-.796-.046-1.136.075-.354.274-.672.65-.823.192-.077.4-.12.602-.077a.7.7 0 0 1 .477.365c.088.164.12.356.127.538.007.187-.012.395-.047.614-.084.51-.27 1.134-.52 1.794a10.954 10.954 0 0 0 .98 1.686 5.753 5.753 0 0 1 1.334.05c.364.065.734.195.96.465.12.144.193.32.2.518.007.192-.047.382-.138.563a1.04 1.04 0 0 1-.354.416.856.856 0 0 1-.51.138c-.331-.014-.654-.196-.933-.417a5.716 5.716 0 0 1-.911-.95 11.642 11.642 0 0 0-1.997.406 11.311 11.311 0 0 1-1.021 1.51c-.29.35-.608.655-.926.787a.793.793 0 0 1-.58.029zm1.379-1.901c-.166.076-.32.156-.459.238-.328.194-.541.383-.647.547-.094.145-.096.25-.04.361.01.022.02.036.026.044a.27.27 0 0 0 .035-.012c.137-.056.355-.235.635-.572a8.18 8.18 0 0 0 .45-.606zm1.64-1.33a12.647 12.647 0 0 1 1.01-.193 11.666 11.666 0 0 1-.51-.858 20.741 20.741 0 0 1-.5 1.05zm2.446.45c.15.162.296.3.435.41.24.19.407.253.498.256a.107.107 0 0 0 .07-.015.307.307 0 0 0 .094-.125.436.436 0 0 0 .059-.2.095.095 0 0 0-.026-.063c-.052-.062-.2-.152-.518-.209a3.881 3.881 0 0 0-.612-.053zM8.078 5.8a6.7 6.7 0 0 0 .2-.828c.031-.188.043-.343.038-.465a.613.613 0 0 0-.032-.198.517.517 0 0 0-.145.04c-.087.035-.158.106-.196.283-.04.192-.03.469.046.822.024.111.054.227.09.346z"/>
                                                    </svg>
                                                    <span class="">Export as PDF</span>
                                                </button>
                                                <button type="submit" name="format" value="excel"
                                                        class="btn btn-success btn-sm">
                                                    <svg xmlns="http://www.w3.org/2000/svg" height="1em"
                                                         viewBox="0 0 384 512">
                                                        <!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                        <style>svg {
                                                                fill: #ffffff
                                                            }</style>
                                                        <path d="M224 136V0H24C10.7 0 0 10.7 0 24v464c0 13.3 10.7 24 24 24h336c13.3 0 24-10.7 24-24V160H248c-13.2 0-24-10.8-24-24zm60.1 106.5L224 336l60.1 93.5c5.1 8-.6 18.5-10.1 18.5h-34.9c-4.4 0-8.5-2.4-10.6-6.3C208.9 405.5 192 373 192 373c-6.4 14.8-10 20-36.6 68.8-2.1 3.9-6.1 6.3-10.5 6.3H110c-9.5 0-15.2-10.5-10.1-18.5l60.3-93.5-60.3-93.5c-5.2-8 .6-18.5 10.1-18.5h34.8c4.4 0 8.5 2.4 10.6 6.3 26.1 48.8 20 33.6 36.6 68.5 0 0 6.1-11.7 36.6-68.5 2.1-3.9 6.2-6.3 10.6-6.3H274c9.5-.1 15.2 10.4 10.1 18.4zM384 121.9v6.1H256V0h6.1c6.4 0 12.5 2.5 17 7l97.9 98c4.5 4.5 7 10.6 7 16.9z"/>
                                                    </svg>
                                                    <span class="">Export as Excel</span>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>


                            </li>
                            <li class="list-group-item">
                                <table class="table table-borderless mb-0">
                                    <tr>
                                        <td class="p-0">
                                            <p class="mb-0 text-muted">Email</p>
                                        </td>
                                        <td>
                                            <p class="mb-0 ">{{$employment->email}}</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="p-0">
                                            <p class="mb-0 text-muted">NIK</p>
                                        </td>
                                        <td>
                                            <p class="mb-0 ">{{$employment->nik}}</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="p-0">
                                            <p class="mb-0 text-muted">Phone</p>
                                        </td>
                                        <td>
                                            <p class="mb-0 ">{{$employment->phone}}</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="p-0">
                                            <p class="mb-0 text-muted">Address</p>
                                        </td>
                                        <td>
                                            <p class="mb-0 ">{{$employment->address}}</p>
                                        </td>
                                    </tr>
                                </table>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body p-0">
                            <div class="tab-content">
                                <div id="invoice" class="tab-pane fade show active">

                                    <div class="col-md-12">
                                        <form action="{{route('benefit.update',['benefit' => $employment->nik])}}"
                                              method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="row g-3 date-icon-set-modal">
                                                <div class="col-md-6 mb-3 pt-2">
                                                    <div class="d-flex align-items-center">
                                                        <label style="width: 50%;" for="basic_salary"
                                                               class="form-label font-weight-bold text-muted text-uppercase">Nomor
                                                            Rekening<span style="color: red">*</span> :</label>
                                                        <input style="width: 50%;" type="text"
                                                               class="form-control"
                                                               id="no_account" name="no_account"
                                                               placeholder="Masukan Nomor Rekening"
                                                               value="{{$benefit->no_account ?: $employment->no_account}}"
                                                               required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3 pt-2">
                                                    <div class="d-flex align-items-center">
                                                        <label style="width: 50%;" for="basic_salary"
                                                               class="form-label font-weight-bold text-muted text-uppercase">Periode:</label>
                                                        <input style="width: 50%;" type="month"
                                                               class="form-control"
                                                               id="periode" name="periode"
                                                               placeholder="Periode"
                                                               value="{{$benefit->periode}}"
                                                               onchange="updateUrl(this)"
                                                               required>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 mb-3" style="border-top: 2px solid grey;">
                                                    <div class="d-flex justify-content-between align-items-center pt-2">
                                                        <h5>Pendapatan</h5>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="d-flex align-items-center">
                                                        <label style="width: 50%;" for="basic_salary"
                                                               class="form-label font-weight-bold text-muted text-uppercase">Gaji
                                                            Pokok<span style="color: red">*</span> :</label>
                                                        <input style="width: 50%;" type="text"
                                                               class="form-control rupiah"
                                                               id="basic_salary" name="basic_salary"
                                                               placeholder="Masukan Gaji Pokok"
                                                               value="{{$benefit->basic_salary}}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="d-flex align-items-center">
                                                        <label style="width: 60%;" for="day_of_works"
                                                               class="form-label font-weight-bold text-muted text-uppercase">Hari
                                                            Kerja<span style="color: red">*</span> :</label>
                                                        <input style="width: 40%;" type="text"
                                                               class="form-control rupiah"
                                                               id="day_of_works" name="day_of_works"
                                                               placeholder="Masukan Hari Kerja"
                                                               required
                                                               value="{{$benefit->day_of_works}}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="d-flex align-items-center">
                                                        <label style="width: 50%;" for="performance_allowances"
                                                               class="form-label font-weight-bold text-muted text-uppercase">Tunjangan
                                                            Kinerja :</label>
                                                        <input style="width: 50%;" type="text"
                                                               class="form-control rupiah"
                                                               id="performance_allowances" name="performance_allowances"
                                                               placeholder="Masukan Tunjangan Tetap"
                                                               value="{{$benefit->performance_allowances}}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="d-flex align-items-center">
                                                        <label style="width: 50%;" for="transport_allowances"
                                                               class="form-label font-weight-bold text-muted text-uppercase">Lembur
                                                            :</label>
                                                        <input style="width: 50%;" type="text"
                                                               class="form-control rupiah"
                                                               id="overtime_allowances" name="overtime_allowances"
                                                               placeholder="Masukan Uang Lembur"
                                                               value="{{$benefit->overtime_allowances}}">
                                                    </div>

                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="d-flex align-items-center">
                                                        <label style="width: 60%;" for="transport_allowances_month"
                                                               class="form-label font-weight-bold text-muted text-uppercase">Pendapatan
                                                            Lainnya :</label>
                                                        <input style="width: 40%;" type="text"
                                                               class="form-control rupiah"
                                                               id="other_allowances"
                                                               name="other_allowances"
                                                               placeholder="Masukan Pendapatan Lainnya"
                                                               value="{{$benefit->other_allowances}}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="d-flex align-items-center">
                                                        <label style="width: 50%;" for="transport_allowances"
                                                               class="form-label font-weight-bold text-muted text-uppercase">Transport
                                                            (Hari) :</label>
                                                        <input style="width: 50%;" type="text"
                                                               class="form-control rupiah"
                                                               id="transport_allowances" name="transport_allowances"
                                                               placeholder="Masukan Uang Transport"
                                                               value="{{$benefit->transport_allowances}}">
                                                    </div>

                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="d-flex align-items-center">
                                                        <label style="width: 60%;" for="transport_allowances_month"
                                                               class="form-label font-weight-bold text-muted text-uppercase">Transport
                                                            (Bulan):</label>
                                                        <input style="width: 40%;" type="text"
                                                               class="form-control rupiah"
                                                               id="transport_allowances_month"
                                                               name="transport_allowances_month" placeholder="0"
                                                               value="0"
                                                               readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="d-flex align-items-center">
                                                        <label style="width: 50%;" for="meal_allowances"
                                                               class="form-label font-weight-bold text-muted text-uppercase">Makan
                                                            (Hari) :</label>
                                                        <input style="width: 50%;" type="text"
                                                               class="form-control rupiah"
                                                               id="meal_allowances" name="meal_allowances"
                                                               placeholder="Masukan Uang Makan"
                                                               value="{{$benefit->meal_allowances}}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="d-flex align-items-center">
                                                        <label style="width: 60%;" for="meal_allowances_month"
                                                               class="form-label font-weight-bold text-muted text-uppercase">Makan
                                                            (Bulan):</label>
                                                        <input style="width: 40%;" type="text"
                                                               class="form-control rupiah"
                                                               id="meal_allowances_month" name="meal_allowances_month"
                                                               placeholder="0"
                                                               value="0" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="d-flex align-items-center">
                                                        <label style="width: 50%;" for="pdpt_kesehatan"
                                                               class="form-label font-weight-bold text-muted text-uppercase">BPJS
                                                            Kesehatan (4%):</label>
                                                        <input style="width: 50%;" type="text"
                                                               class="form-control rupiah"
                                                               id="pdpt_kesehatan" name="pdpt_kesehatan"
                                                               value="0" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="d-flex align-items-center">
                                                        <label style="width: 60%;" for="pdpt_jht"
                                                               class="form-label font-weight-bold text-muted text-uppercase">JHT
                                                            (3,70%):</label>
                                                        <input style="width: 40%;" type="text"
                                                               class="form-control rupiah"
                                                               id="pdpt_jht" name="pdpt_jht" value="0" readonly>
                                                    </div>

                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="d-flex align-items-center">
                                                        <label style="width: 50%;" for="pdpt_jkk"
                                                               class="form-label font-weight-bold text-muted text-uppercase">JKK
                                                            (0.54%) :</label>
                                                        <input style="width: 50%;" type="text"
                                                               class="form-control rupiah"
                                                               id="pdpt_jkk" name="pdpt_jkk"
                                                               value="0" readonly>
                                                    </div>

                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="d-flex align-items-center">
                                                        <label style="width: 60%;" for="pdpt_jkm"
                                                               class="form-label font-weight-bold text-muted text-uppercase">JKM
                                                            (0,3%):</label>
                                                        <input style="width: 40%;" type="text"
                                                               class="form-control rupiah"
                                                               id="pdpt_jkm" name="pdpt_jkm" placeholder="0"
                                                               value="0"
                                                               readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="d-flex align-items-center">
                                                        <label style="width: 50%;" for="pdpt_pensiun"
                                                               class="form-label font-weight-bold text-muted text-uppercase">PENSIUN
                                                            (2%) :</label>
                                                        <input style="width: 50%;" type="text"
                                                               class="form-control rupiah"
                                                               id="pdpt_pensiun" name="pdpt_pensiun"
                                                               placeholder=""
                                                               value="0"
                                                               readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="d-flex align-items-center">
                                                        <label style="width: 60%;font-size: 20px" for="total_pendapatan"
                                                               class="form-label font-weight-bold text-muted text-uppercase">TOTAL
                                                            PENDAPATAN:</label>
                                                        <input style="width: 40%;" type="text"
                                                               class="form-control rupiah"
                                                               id="total_pendapatan" name="total_pendapatan"
                                                               placeholder="0"
                                                               value="0" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 mb-3" style="border-top: 2px solid grey;">
                                                    <div class="d-flex justify-content-between align-items-center pt-2">
                                                        <h5>Presensi Kehadiran</h5>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="d-flex align-items-center">
                                                        <label style="width: 50%;" for="leaves"
                                                               class="form-label font-weight-bold text-muted text-uppercase">Hak
                                                            Cuti<span
                                                                    style="color: red">*</span> :</label>
                                                        <input style="width: 50%;" type="number"
                                                               class="form-control rupiah"
                                                               id="leave_rights" name="leave_rights"
                                                               placeholder=""
                                                               value="{{$benefit->leave_rights}}" min="0" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="d-flex align-items-center">
                                                        <label style="width: 50%;" for="leaves"
                                                               class="form-label font-weight-bold text-muted text-uppercase">Cuti<span
                                                                    style="color: red">*</span> :</label>
                                                        <input style="width: 50%;" type="number"
                                                               class="form-control rupiah"
                                                               id="leaves" name="leaves"
                                                               placeholder=""
                                                               value="{{$benefit->leaves}}" min="0" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="d-flex align-items-center">
                                                        <label style="width: 60%;" for="hari_masuk"
                                                               class="form-label font-weight-bold text-muted text-uppercase">Total
                                                            Hari Masuk :</label>
                                                        <input style="width: 40%;" type="number"
                                                               class="form-control rupiah"
                                                               id="hari_masuk" name="hari_masuk"
                                                               placeholder=""
                                                               value="" min="0" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="d-flex align-items-center">
                                                        <label style="width: 50%;" for="sick_leaves"
                                                               class="form-label font-weight-bold text-muted text-uppercase">Sakit<span
                                                                    style="color: red">*</span> :</label>
                                                        <input style="width: 50%;" type="number"
                                                               class="form-control rupiah"
                                                               id="sick_leaves" name="sick_leaves"
                                                               placeholder=""
                                                               value="{{$benefit->sick_leaves}}" min="0" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="d-flex align-items-center">
                                                        <label style="width: 50%;" for="absence_leaves"
                                                               class="form-label font-weight-bold text-muted text-uppercase">Ijin
                                                            / Absen<span
                                                                    style="color: red">*</span> :</label>
                                                        <input style="width: 50%;" type="number"
                                                               class="form-control rupiah"
                                                               id="absence_leaves" name="absence_leaves"
                                                               placeholder=""
                                                               value="{{$benefit->absence_leaves}}" min="0" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                </div>

                                                <div class="col-md-12 mb-3" style="border-top: 2px solid grey;">
                                                    <div class="d-flex justify-content-between align-items-center pt-2">
                                                        <h5>Potongan</h5>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="d-flex align-items-center">
                                                        <label style="width: 50%;" for="pot_absensi"
                                                               class="form-label font-weight-bold text-muted text-uppercase">Absensi
                                                            :</label>
                                                        <input style="width: 50%;" type="text"
                                                               class="form-control rupiah"
                                                               id="pot_absensi" name="pot_absensi"
                                                               value="0" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="d-flex align-items-center">
                                                        <label style="width: 60%;" for="pot_transport"
                                                               class="form-label font-weight-bold text-muted text-uppercase">Transport
                                                            :</label>
                                                        <input style="width: 40%;" type="text"
                                                               class="form-control rupiah"
                                                               id="pot_transport" name="pot_transport"
                                                               placeholder=""
                                                               value="0" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="d-flex align-items-center">
                                                        <label style="width: 50%;" for="pot_makan"
                                                               class="form-label font-weight-bold text-muted text-uppercase">MAKAN
                                                            :</label>
                                                        <input style="width: 50%;" type="text"
                                                               class="form-control rupiah"
                                                               id="pot_makan" name="pot_makan"
                                                               placeholder=""
                                                               value="0" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="d-flex align-items-center">
                                                        <label style="width: 60%;" for="burden"
                                                               class="form-label font-weight-bold text-muted text-uppercase">Pinjaman
                                                            / Tanggungan
                                                            :</label>
                                                        <input style="width: 40%;" type="text"
                                                               class="form-control rupiah"
                                                               id="burden" name="burden"
                                                               placeholder=""
                                                               value="{{$benefit->burden}}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="d-flex align-items-center">
                                                        <label style="width: 50%;" for="pot_bpjs_kes"
                                                               class="form-label font-weight-bold text-muted text-uppercase">BPJS
                                                            KESEHATAN (1%)
                                                            :</label>
                                                        <input style="width: 50%;" type="text"
                                                               class="form-control rupiah"
                                                               id="pot_bpjs_kes" name="pot_bpjs_kes"
                                                               placeholder=""
                                                               value="0" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="d-flex align-items-center">
                                                        <label style="width: 60%;" for="pot_bpjs_tk"
                                                               class="form-label font-weight-bold text-muted text-uppercase">BPJS
                                                            TK (3%)
                                                            :</label>
                                                        <input style="width: 40%;" type="text"
                                                               class="form-control rupiah"
                                                               id="pot_bpjs_tk" name="pot_bpjs_tk"
                                                               placeholder=""
                                                               value="0" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="d-flex align-items-center">
                                                        <label style="width: 50%;" for="sub_bpjs_kes"
                                                               class="form-label font-weight-bold text-muted text-uppercase">SUBSIDI
                                                            BPJS KESEHATAN
                                                            :</label>
                                                        <input style="width: 50%;" type="text"
                                                               class="form-control rupiah"
                                                               id="sub_bpjs_kes" name="sub_bpjs_kes"
                                                               placeholder=""
                                                               value="0" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="d-flex align-items-center">
                                                        <label style="width: 60%;" for="sub_bpjs_tk"
                                                               class="form-label font-weight-bold text-muted text-uppercase">SUBSIDI
                                                            BPJS TK
                                                            :</label>
                                                        <input style="width: 40%;" type="text"
                                                               class="form-control rupiah"
                                                               id="sub_bpjs_tk" name="sub_bpjs_tk"
                                                               placeholder=""
                                                               value="0" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 mb-3">
                                                    <div class="card bg-light border p-3">
                                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                                            <h6 class="font-weight-bold text-primary mb-0">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-shield-check mr-1" viewBox="0 0 16 16">
                                                                    <path d="M5.338 1.59a61.44 61.44 0 0 0-2.837.856.481.481 0 0 0-.328.39c-.554 4.157.726 7.19 2.253 9.188a10.725 10.725 0 0 0 2.287 2.233c.346.244.652.42.893.533.12.057.218.095.293.118a.55.55 0 0 0 .101.025.615.615 0 0 0 .1-.025c.076-.023.174-.061.294-.118.24-.113.547-.29.893-.533a10.726 10.726 0 0 0 2.287-2.233c1.527-1.997 2.807-5.031 2.253-9.188a.48.48 0 0 0-.328-.39c-.651-.213-1.75-.56-2.837-.855C9.552 1.29 8.531 1.067 8 1.067c-.53 0-1.552.223-2.662.524zM5.072.56C6.157.265 7.31 0 8 0s1.843.265 2.928.56c1.11.3 2.229.655 2.887.87a1.54 1.54 0 0 1 1.044 1.262c.596 4.477-.787 7.795-2.464 9.99a11.775 11.775 0 0 1-2.517 2.453 7.159 7.159 0 0 1-1.048.625c-.28.132-.581.24-.829.24s-.548-.108-.829-.24a7.158 7.158 0 0 1-1.048-.625 11.777 11.777 0 0 1-2.517-2.453C1.935 10.487.552 7.168 1.148 2.692A1.54 1.54 0 0 1 2.192 1.43C2.85 1.215 3.97.86 5.072.56z"/>
                                                                    <path d="M10.854 5.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                                                                </svg>
                                                                Perhitungan Pajak PPh 21 TER (PP 58/2023)
                                                            </h6>
                                                            <div>
                                                                <span class="badge badge-info mr-1">PTKP: <strong id="ptkp_badge">{{ $employment->ptkp_status ?? 'TK/0' }}</strong></span>
                                                                <span class="badge badge-success">Kategori: <strong id="ter_category_badge">TER {{ \App\Services\Pph21Service::getCategory($employment->ptkp_status ?? 'TK/0') }}</strong></span>
                                                            </div>
                                                        </div>
                                                        <div class="row align-items-center">
                                                            <div class="col-md-4">
                                                                <small class="text-muted d-block">Penghasilan Bruto PPh 21:</small>
                                                                <h6 id="display_bruto" class="font-weight-bold text-dark mb-0">Rp 0</h6>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <small class="text-muted d-block">Tarif Efektif (TER):</small>
                                                                <span class="badge badge-warning text-dark font-weight-bold" id="display_ter_rate" style="font-size: 14px;">0%</span>
                                                            </div>
                                                            <div class="col-md-5">
                                                                <div class="d-flex align-items-center justify-content-between">
                                                                    <label for="potongan_pph_21" class="form-label font-weight-bold text-danger mb-0 text-uppercase">Potongan PPh 21:</label>
                                                                    <div class="form-check form-check-inline m-0">
                                                                        <input class="form-check-input" type="checkbox" id="auto_pph21" checked onchange="toggleAutoPph(this)">
                                                                        <label class="form-check-label text-muted small" for="auto_pph21">Auto</label>
                                                                    </div>
                                                                </div>
                                                                <input type="text" class="form-control rupiah mt-1" id="potongan_pph_21" name="potongan_pph_21"
                                                                       value="{{$benefit->potongan_pph_21}}" readonly style="font-weight: bold; color: #dc3545;">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="d-flex align-items-center">
                                                        <label style="width: 60%;font-size: 20px" for="total_potongan"
                                                               class="form-label font-weight-bold text-muted text-uppercase">TOTAL
                                                            POTONGAN:</label>
                                                        <input style="width: 40%;" type="text"
                                                               class="form-control rupiah"
                                                               id="total_potongan" name="total_potongan"
                                                               placeholder="0"
                                                               value="0" readonly>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="col-md-12 mb-3" style="border-top: 2px solid grey;">
                                                    <div class="d-flex align-items-center mt-2">
                                                        <label style="width: 50%; font-size: 20px" for="thp"
                                                               class="form-label font-weight-bold text-muted text-uppercase text-right pr-2">Gaji
                                                            Bersih : </label>
                                                        <input style="width: 25%;" type="text"
                                                               class="form-control rupiah"
                                                               id="thp" name="thp" placeholder="0" value="0"
                                                               readonly>
                                                        <div class="ml-auto">
                                                            <button type="submit" class="btn btn-primary">Update
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
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
        function updateUrl(input) {
            var selectedMonth = input.value;
            var urls = '{{ route('benefit.edit', ['benefit' => $employment->nik, 'month' => '']) }}';
            window.location.href = urls + selectedMonth;
        }

        document.addEventListener("DOMContentLoaded", function () {
            hitung();
            formatRupiahInputs();
        });

        function formatRupiahInputs() {
            var rupiahInputs = document.getElementsByClassName('rupiah');

            for (var i = 0; i < rupiahInputs.length; i++) {
                var input = rupiahInputs[i];
                var value = input.value;
                if (value.trim() !== "") {
                    // Remove non-numeric characters except commas
                    value = value.replace(/[^\d,]/g, '');

                    // Check if the value is "0" and return it as is
                    if (value === "0") {
                        input.value = "0";
                        continue;
                    }

                    // Remove leading zeros
                    value = value.replace(/^0+/, '');

                    // Remove any existing commas
                    value = value.replace(/,/g, '');

                    // Convert to a number and format with commas
                    var formattedValue = parseFloat(value).toLocaleString('en-US');

                    input.value = formattedValue;
                }
            }
        }

        // Add keyup event listeners for real-time formatting
        var rupiahInputs = document.getElementsByClassName('rupiah');
        for (var i = 0; i < rupiahInputs.length; i++) {
            rupiahInputs[i].addEventListener("keyup", function () {
                hitung();
            });
        }

        function getPph21Category(ptkp) {
            ptkp = (ptkp || 'TK/0').toUpperCase().trim();
            if (['TK/0', 'TK/1', 'K/0'].includes(ptkp)) return 'A';
            if (['TK/2', 'TK/3', 'K/1', 'K/2'].includes(ptkp)) return 'B';
            if (ptkp === 'K/3') return 'C';
            return 'A';
        }

        function getPph21TerRate(category, bruto) {
            if (category === 'A') {
                if (bruto <= 5400000) return 0.0;
                if (bruto <= 5650000) return 0.0025;
                if (bruto <= 5950000) return 0.005;
                if (bruto <= 6300000) return 0.0075;
                if (bruto <= 6750000) return 0.01;
                if (bruto <= 7500000) return 0.0125;
                if (bruto <= 8550000) return 0.015;
                if (bruto <= 9650000) return 0.0175;
                if (bruto <= 10050000) return 0.02;
                if (bruto <= 10350000) return 0.0225;
                if (bruto <= 10700000) return 0.025;
                if (bruto <= 11050000) return 0.03;
                if (bruto <= 11600000) return 0.035;
                if (bruto <= 12500000) return 0.04;
                if (bruto <= 13750000) return 0.05;
                if (bruto <= 15100000) return 0.06;
                if (bruto <= 16950000) return 0.07;
                if (bruto <= 19750000) return 0.08;
                if (bruto <= 24150000) return 0.09;
                if (bruto <= 26450000) return 0.10;
                if (bruto <= 28000000) return 0.11;
                if (bruto <= 30050000) return 0.12;
                if (bruto <= 32400000) return 0.13;
                if (bruto <= 35400000) return 0.14;
                if (bruto <= 39100000) return 0.15;
                if (bruto <= 43850000) return 0.16;
                if (bruto <= 47800000) return 0.17;
                if (bruto <= 51400000) return 0.18;
                if (bruto <= 56300000) return 0.19;
                if (bruto <= 62200000) return 0.20;
                if (bruto <= 68600000) return 0.21;
                if (bruto <= 77500000) return 0.22;
                if (bruto <= 89000000) return 0.23;
                if (bruto <= 103000000) return 0.24;
                if (bruto <= 125000000) return 0.25;
                if (bruto <= 157000000) return 0.26;
                if (bruto <= 206000000) return 0.27;
                if (bruto <= 337000000) return 0.28;
                if (bruto <= 454000000) return 0.29;
                if (bruto <= 550000000) return 0.30;
                if (bruto <= 695000000) return 0.31;
                if (bruto <= 910000000) return 0.32;
                if (bruto <= 1400000000) return 0.33;
                return 0.34;
            } else if (category === 'B') {
                if (bruto <= 6200000) return 0.0;
                if (bruto <= 6500000) return 0.0025;
                if (bruto <= 6850000) return 0.005;
                if (bruto <= 7300000) return 0.0075;
                if (bruto <= 9200000) return 0.01;
                if (bruto <= 10750000) return 0.015;
                if (bruto <= 11250000) return 0.02;
                if (bruto <= 11600000) return 0.025;
                if (bruto <= 12600000) return 0.03;
                if (bruto <= 13600000) return 0.04;
                if (bruto <= 14950000) return 0.05;
                if (bruto <= 16400000) return 0.06;
                if (bruto <= 18450000) return 0.07;
                if (bruto <= 21850000) return 0.08;
                if (bruto <= 26000000) return 0.09;
                if (bruto <= 27700000) return 0.10;
                if (bruto <= 29350000) return 0.11;
                if (bruto <= 31450000) return 0.12;
                if (bruto <= 33950000) return 0.13;
                if (bruto <= 37100000) return 0.14;
                if (bruto <= 41100000) return 0.15;
                if (bruto <= 45800000) return 0.16;
                if (bruto <= 49500000) return 0.17;
                if (bruto <= 53800000) return 0.18;
                if (bruto <= 58500000) return 0.19;
                if (bruto <= 64000000) return 0.20;
                if (bruto <= 71000000) return 0.21;
                if (bruto <= 80000000) return 0.22;
                if (bruto <= 93000000) return 0.23;
                if (bruto <= 109000000) return 0.24;
                if (bruto <= 129000000) return 0.25;
                if (bruto <= 163000000) return 0.26;
                if (bruto <= 211000000) return 0.27;
                if (bruto <= 374000000) return 0.28;
                if (bruto <= 459000000) return 0.29;
                if (bruto <= 555000000) return 0.30;
                if (bruto <= 704000000) return 0.31;
                if (bruto <= 957000000) return 0.32;
                if (bruto <= 1405000000) return 0.33;
                return 0.34;
            } else {
                if (bruto <= 6600000) return 0.0;
                if (bruto <= 6950000) return 0.0025;
                if (bruto <= 7350000) return 0.005;
                if (bruto <= 7800000) return 0.0075;
                if (bruto <= 8850000) return 0.01;
                if (bruto <= 9800000) return 0.0125;
                if (bruto <= 10950000) return 0.015;
                if (bruto <= 11200000) return 0.0175;
                if (bruto <= 12050000) return 0.02;
                if (bruto <= 12950000) return 0.03;
                if (bruto <= 14150000) return 0.04;
                if (bruto <= 15550000) return 0.05;
                if (bruto <= 17050000) return 0.06;
                if (bruto <= 19500000) return 0.07;
                if (bruto <= 22700000) return 0.08;
                if (bruto <= 26600000) return 0.09;
                if (bruto <= 28100000) return 0.10;
                if (bruto <= 30100000) return 0.11;
                if (bruto <= 32600000) return 0.12;
                if (bruto <= 35400000) return 0.13;
                if (bruto <= 38900000) return 0.14;
                if (bruto <= 43000000) return 0.15;
                if (bruto <= 47400000) return 0.16;
                if (bruto <= 51200000) return 0.17;
                if (bruto <= 55800000) return 0.18;
                if (bruto <= 60400000) return 0.19;
                if (bruto <= 66700000) return 0.20;
                if (bruto <= 74500000) return 0.21;
                if (bruto <= 83200000) return 0.22;
                if (bruto <= 95600000) return 0.23;
                if (bruto <= 110000000) return 0.24;
                if (bruto <= 134000000) return 0.25;
                if (bruto <= 169000000) return 0.26;
                if (bruto <= 221000000) return 0.27;
                if (bruto <= 390000000) return 0.28;
                if (bruto <= 463000000) return 0.29;
                if (bruto <= 561000000) return 0.30;
                if (bruto <= 709000000) return 0.31;
                if (bruto <= 965000000) return 0.32;
                if (bruto <= 1419000000) return 0.33;
                return 0.34;
            }
        }

        function toggleAutoPph(checkbox) {
            var pphInput = document.getElementById('potongan_pph_21');
            if (checkbox.checked) {
                pphInput.readOnly = true;
                hitung();
            } else {
                pphInput.readOnly = false;
            }
        }

        function hitung() {
            var hariKerja = document.getElementById('day_of_works').value;

            var gajiPokok = document.getElementById('basic_salary').value.replace(/,/g, '');
            var makan = document.getElementById('meal_allowances').value.replace(/,/g, '');
            var transport = document.getElementById('transport_allowances').value.replace(/,/g, '');
            var kinerja = document.getElementById('performance_allowances').value.replace(/,/g, '');
            var lembur = document.getElementById('overtime_allowances').value.replace(/,/g, '');
            var pendapatan_lainnya = document.getElementById('other_allowances').value.replace(/,/g, '');

            var transportPerBulan = parseInt(transport) * parseInt(hariKerja);
            var makanPerBulan = parseInt(makan) * parseInt(hariKerja);

            var BPJSKesehatanPendapatan = parseInt(gajiPokok) * 0.04;
            var BPJSJHTPendapatan = parseInt(gajiPokok) * 0.037;
            var BPJSJKKPendapatan = parseInt(gajiPokok) * 0.0054;
            var BPJSJKMPendapatan = parseInt(gajiPokok) * 0.003;
            var BPJSPensiunPendapatan = parseInt(gajiPokok) * 0.02;
            var totalPendapatan = parseInt(gajiPokok) + parseInt(kinerja) + parseInt(transportPerBulan) + parseInt(makanPerBulan) +
                parseInt(BPJSKesehatanPendapatan) + parseInt(BPJSJHTPendapatan) + parseInt(BPJSJKKPendapatan) + parseInt(BPJSJKMPendapatan) + parseInt(BPJSPensiunPendapatan) + +parseInt(lembur) + parseInt(pendapatan_lainnya);

            document.getElementById('transport_allowances_month').value = transportPerBulan;
            document.getElementById('meal_allowances_month').value = makanPerBulan;
            document.getElementById('pdpt_kesehatan').value = BPJSKesehatanPendapatan;
            document.getElementById('pdpt_jht').value = BPJSJHTPendapatan;
            document.getElementById('pdpt_jkk').value = BPJSJKKPendapatan;
            document.getElementById('pdpt_jkm').value = BPJSJKMPendapatan;
            document.getElementById('pdpt_pensiun').value = BPJSPensiunPendapatan;
            document.getElementById('total_pendapatan').value = totalPendapatan;

            var leaves = document.getElementById('leaves').value;
            var sick_leaves = document.getElementById('sick_leaves').value;
            var absence_leaves = document.getElementById('absence_leaves').value;
            var totalHariMasuk = parseInt(hariKerja) - parseInt(leaves) - parseInt(sick_leaves) - parseInt(absence_leaves);
            document.getElementById('hari_masuk').value = totalHariMasuk;

            var pot_absensi = Math.floor((parseInt(absence_leaves) / parseInt(hariKerja)) * (parseInt(gajiPokok) + parseInt(kinerja)));
            document.getElementById('pot_absensi').value = pot_absensi;

            var pot_transport = Math.floor((parseInt(leaves) + parseInt(sick_leaves) + parseInt(absence_leaves)) / parseInt(hariKerja) * parseInt(transportPerBulan));
            document.getElementById('pot_transport').value = pot_transport;

            var pot_makan = Math.floor((parseInt(leaves) + parseInt(sick_leaves) + parseInt(absence_leaves)) / parseInt(hariKerja) * parseInt(makanPerBulan));
            document.getElementById('pot_makan').value = pot_makan;

            var pot_bpjs_kes = Math.floor(0.01 * parseInt(gajiPokok));
            document.getElementById('pot_bpjs_kes').value = pot_bpjs_kes;

            var pot_bpjs_tk = Math.floor(0.03 * parseInt(gajiPokok));
            document.getElementById('pot_bpjs_tk').value = pot_bpjs_tk;

            document.getElementById('sub_bpjs_kes').value = parseInt(BPJSKesehatanPendapatan);
            document.getElementById('sub_bpjs_tk').value = parseInt(BPJSJHTPendapatan) + parseInt(BPJSJKKPendapatan) + parseInt(BPJSJKMPendapatan) + parseInt(BPJSPensiunPendapatan);
            var burden = document.getElementById('burden').value.replace(/,/g, '');

            // Hitung Bruto untuk PPh 21 TER (Gaji Pokok + Tunjangan + Premi BPJS ditanggung pemberi kerja)
            var brutoPph = parseInt(gajiPokok) + parseInt(kinerja) + parseInt(lembur) + parseInt(pendapatan_lainnya) +
                parseInt(transportPerBulan) + parseInt(makanPerBulan) +
                parseInt(BPJSKesehatanPendapatan) + parseInt(BPJSJKKPendapatan) + parseInt(BPJSJKMPendapatan);

            var ptkpStatus = '{{ $employment->ptkp_status ?? "TK/0" }}';
            var terCategory = getPph21Category(ptkpStatus);
            var terRate = getPph21TerRate(terCategory, brutoPph);

            var elDisplayBruto = document.getElementById('display_bruto');
            if (elDisplayBruto) {
                elDisplayBruto.innerText = 'Rp ' + (isNaN(brutoPph) ? 0 : brutoPph).toLocaleString('id-ID');
            }
            var elDisplayRate = document.getElementById('display_ter_rate');
            if (elDisplayRate) {
                elDisplayRate.innerText = (terRate * 100).toFixed(2) + '%';
            }

            var autoPph = document.getElementById('auto_pph21');
            if (autoPph && autoPph.checked) {
                var calcPph = Math.round(brutoPph * terRate);
                document.getElementById('potongan_pph_21').value = isNaN(calcPph) ? 0 : calcPph;
            }

            var potongan_pph_21 = document.getElementById('potongan_pph_21').value.replace(/,/g, '');
            if (isNaN(parseInt(potongan_pph_21))) potongan_pph_21 = 0;

            var totalPotongan = parseInt(pot_absensi) + parseInt(pot_transport) + parseInt(pot_makan) + parseInt(burden) + parseInt(pot_bpjs_kes) + parseInt(pot_bpjs_tk) +
                parseInt(BPJSKesehatanPendapatan) + parseInt(BPJSJHTPendapatan) + parseInt(BPJSJKKPendapatan) + parseInt(BPJSJKMPendapatan) + parseInt(BPJSPensiunPendapatan)
                + parseInt(potongan_pph_21);
            document.getElementById('total_potongan').value = parseInt(totalPotongan);

            var thp = totalPendapatan - totalPotongan;
            document.getElementById('thp').value = thp;
            formatRupiahInputs();
        }

    </script>
@endsection
