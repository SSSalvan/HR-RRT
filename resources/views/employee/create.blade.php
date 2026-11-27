@extends('layouts.app') <!-- Extend the main template -->

@section('content')
    <div id="remoteModelData" class="modal fade" role="dialog"></div>
    <div class="content-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="d-flex flex-wrap align-items-center justify-content-between mb-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb p-0 mb-0">
                                    <li class="breadcrumb-item"><a href="{{route('employee.index')}}">Karyawan</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Tambah Karyawan</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 mb-3 d-flex justify-content-between">
                    <h4 class="font-weight-bold d-flex align-items-center">Tambah Karyawan</h4>
                    <a href="{{route('employee.index')}}"
                       class="btn btn-primary btn-sm d-flex align-items-center justify-content-between ml-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                  d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                                  clip-rule="evenodd"/>
                        </svg>
                        <span class="ml-2">Kembali</span>
                    </a>
                </div>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <form class="row" action="{{route('employee.store')}}"
                                  method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="col-md-3 mb-3">
                                    <div class="card-body rounded bg-light">
                                        <div class="d-flex justify-content-center mb-3">
                                            <div style="width: 200px; height: 200px; border-radius: 10px; overflow: hidden; border: 3px solid #dee2e6;">
                                                <img id="previewImage" src="{{ asset('images/user/unknown.jpg') }}"
                                                     style="width: 100%; height: 100%; object-fit: cover;" alt="profile">
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-center">
                                            <input type="file" name="image" id="imageUpload" accept=".jpg, .jpeg, .png"
                                                   onchange="previewFile()" style="display: none;">
                                            <button type="button" class="btn btn-primary btn-sm" onclick="document.getElementById('imageUpload').click()">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-upload mr-1" viewBox="0 0 16 16">
                                                    <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                                                    <path d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708l3-3z"/>
                                                </svg>
                                                Pilih Gambar
                                            </button>
                                        </div>
                                        <div class="d-flex justify-content-center mt-2">
                                            <small class="text-muted" id="fileName">Format: JPG, JPEG, PNG (Max: 2MB)</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-9">
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
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <strong>Whoops!</strong> There were some problems with your
                                            input.<br><br>
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    <div class="row g-3 date-icon-set-modal">
                                        <div class="col-md-6 mb-3">
                                            <label for="Text1"
                                                   class="form-label font-weight-bold text-muted text-uppercase">Nama
                                                Lengkap<span style="color: red">*</span></label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                                   id="name" name="name" placeholder="Masukan Nama Lengkap"
                                                   value="{{ old('name') }}" required maxlength="255">
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label font-weight-bold text-muted text-uppercase mb-3">Jenis
                                                Kelamin<span style="color: red">*</span></label><br>
                                            <div class="form-check form-check-inline">
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="inlineRadio1" name="gender"
                                                           class="custom-control-input" value="Pria" required>
                                                    <label class="custom-control-label" for="inlineRadio1">Pria</label>
                                                </div>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="inlineRadio2" name="gender"
                                                           class="custom-control-input" value="Wanita" required>
                                                    <label class="custom-control-label"
                                                           for="inlineRadio2">Wanita</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="place_of_birth"
                                                   class="form-label font-weight-bold text-muted text-uppercase">Tempat
                                                Lahir</label>
                                            <input type="text" class="form-control" id="place_of_birth"
                                                   name="place_of_birth"
                                                   placeholder="Masukan Tempat Lahir" value="">
                                        </div>
                                        <div class="col-md-6 mb-3  position-relative">
                                            <label for="date_of_birth"
                                                   class="form-label font-weight-bold text-muted text-uppercase">Tanggal
                                                Lahir</label>
                                            <input type="date" class="form-control" id="date_of_birth"
                                                   name="date_of_birth" placeholder="Masukan Tanggal Lahir"
                                                   autocomplete="off" data-date-format="Y-m-d"
                                                   value="">
                                            <span class="search-link">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="" width="20" fill="none"
                                                     viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                            </span>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="type_of_blood"
                                                   class="form-label font-weight-bold text-muted text-uppercase">Golongan
                                                Darah</label>
                                            <select id="type_of_blood" name="type_of_blood"
                                                    class="form-select form-control choicesjs">
                                                <option value="">Pilih Golongan Darah</option>
                                                <option value="A">A</option>
                                                <option value="B">B</option>
                                                <option value="AB">AB</option>
                                                <option value="O">O</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="nik"
                                                   class="form-label font-weight-bold text-muted text-uppercase">NIK<span
                                                        style="color: red">*</span></label>
                                            <input type="text" class="form-control @error('nik') is-invalid @enderror"
                                                   id="nik" name="nik" placeholder="Masukkan NIK 16 digit"
                                                   value="{{ old('nik') }}" required maxlength="16" minlength="16" pattern="[0-9]{16}">
                                            @error('nik')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="form-text text-muted">NIK harus 16 digit angka</small>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="email"
                                                   class="form-label font-weight-bold text-muted text-uppercase">Email</label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                                   id="email" name="email" placeholder="Masukan Email"
                                                   value="{{ old('email') }}">
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="phone2"
                                                   class="form-label font-weight-bold text-muted text-uppercase">Telepon</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control col-md-3" id="default_phone"
                                                       name="default_phone" value="+62" readonly>
                                                <input type="tel" class="form-control col-md-9 @error('phone') is-invalid @enderror"
                                                       id="phone" name="phone" placeholder="Masukan Nomor Telepon"
                                                       pattern="[0-9]*" value="{{ old('phone') }}">
                                            </div>
                                            @error('phone')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                            <small class="form-text text-muted">Contoh: 81234567890</small>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="religion"
                                                   class="form-label font-weight-bold text-muted text-uppercase">Agama</label>
                                            <select id="religion" name="religion"
                                                    class="form-select form-control choicesjs">
                                                <option value="">Pilih Agama</option>
                                                <option value="Islam">Islam</option>
                                                <option value="Kristen">Kristen</option>
                                                <option value="Katolik">Katolik</option>
                                                <option value="Budha">Budha</option>
                                                <option value="Hindu">Hindu</option>
                                                <option value="Konghucu">Konghucu</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="inputCountry"
                                                   class="form-label font-weight-bold text-muted text-uppercase">Negara</label>
                                            <select id="country" name="country"
                                                    class="form-select form-control choicesjs">
                                                <option value="">Pilih Negara</option>
                                                <option value="INDONESIA" selected>INDONESIA</option>
                                                <option value="LUAR NEGERI">LUAR NEGERI</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="region"
                                                   class="form-label font-weight-bold text-muted text-uppercase">Provinsi</label>
                                            <input type="text" class="form-control" id="region" name="region"
                                                   placeholder="Masukan Provinsi"
                                                   value="">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="Text7"
                                                   class="form-label font-weight-bold text-muted text-uppercase">Kode
                                                Pos</label>
                                            <input type="text" class="form-control" id="zip_code" name="zip_code"
                                                   placeholder="Masukan Kode Pos" value="">
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label for="address"
                                                   class="form-label font-weight-bold text-muted text-uppercase">Alamat</label>
                                            <textarea class="form-control" id="address" name="address" rows="2"
                                                      placeholder="Masukan Alamat">
                                            </textarea>
                                        </div>
                                        <div class="col-md-6 mb-3  position-relative">
                                            <label for="date_start_of_work"
                                                   class="form-label font-weight-bold text-muted text-uppercase">Tanggal
                                                Bekerja</label>
                                            <input type="date" class="form-control"
                                                   id="date_start_of_work"
                                                   name="date_start_of_work" placeholder="Masukan Tanggal Bekerja"
                                                   autocomplete="off" data-date-format="Y-m-d"
                                                   value="">
                                            <span class="search-link">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="" width="20" fill="none"
                                                     viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                            </span>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="employment_status"
                                                   class="form-label font-weight-bold text-muted text-uppercase">Status
                                                Karyawan<span style="color: red">*</span></label>
                                            <select id="employment_status" class="form-select form-control choicesjs"
                                                    name="employment_status" required>
                                                <option value="">Pilih Status Karyawan</option>
                                                @foreach($employmentStatuses as $employmentStatus)
                                                    <option
                                                            value="{{$employmentStatus->id}}">{{$employmentStatus->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="employment_division"
                                                   class="form-label font-weight-bold text-muted text-uppercase">Divisi<span
                                                        style="color: red">*</span></label>
                                            <select id="employment_division" name="employment_division"
                                                    class="form-select form-control choicesjs" required>
                                                <option value="">Pilih Divisi</option>
                                                @foreach($employmentDivisions as $employmentDivision)
                                                    <option
                                                            value="{{$employmentDivision->id}}">{{$employmentDivision->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="employment_country"
                                                   class="form-label font-weight-bold text-muted text-uppercase">Jabatan<span
                                                        style="color: red">*</span></label>
                                            <select id="employment_role" name="employment_role"
                                                    class="form-select form-control choicesjs" required>
                                                <option value="">Pilih Jabatan</option>
                                                @foreach($employmentRoles as $employmentRole)
                                                    <option
                                                            value="{{$employmentRole->id}}">{{$employmentRole->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="leave_quota"
                                                   class="form-label font-weight-bold text-muted text-uppercase">Jumlah
                                                Cuti<span style="color: red">*</span></label>
                                            <input type="number" class="form-control @error('leave_quota') is-invalid @enderror"
                                                   id="leave_quota" name="leave_quota" placeholder="Masukkan Jumlah Cuti"
                                                   value="{{ old('leave_quota') }}" required min="0" max="365">
                                            @error('leave_quota')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="form-text text-muted">Maksimal 365 hari</small>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="no_account"
                                                   class="form-label font-weight-bold text-muted text-uppercase">Nomor
                                                Rekening</label>
                                            <input type="text" class="form-control @error('no_account') is-invalid @enderror"
                                                   id="no_account" name="no_account" placeholder="Masukkan Nomor Rekening"
                                                   value="{{ old('no_account') }}" pattern="[0-9]*">
                                            @error('no_account')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="ptkp_status"
                                                   class="form-label font-weight-bold text-muted text-uppercase">Status PTKP (PPh 21)<span style="color: red">*</span></label>
                                            <select id="ptkp_status" name="ptkp_status" class="form-select form-control" required>
                                                <option value="TK/0" {{ old('ptkp_status', 'TK/0') == 'TK/0' ? 'selected' : '' }}>TK/0 - Tidak Kawin (0 Tanggungan) [TER A]</option>
                                                <option value="TK/1" {{ old('ptkp_status') == 'TK/1' ? 'selected' : '' }}>TK/1 - Tidak Kawin (1 Tanggungan) [TER A]</option>
                                                <option value="TK/2" {{ old('ptkp_status') == 'TK/2' ? 'selected' : '' }}>TK/2 - Tidak Kawin (2 Tanggungan) [TER B]</option>
                                                <option value="TK/3" {{ old('ptkp_status') == 'TK/3' ? 'selected' : '' }}>TK/3 - Tidak Kawin (3 Tanggungan) [TER B]</option>
                                                <option value="K/0" {{ old('ptkp_status') == 'K/0' ? 'selected' : '' }}>K/0 - Kawin (0 Tanggungan) [TER A]</option>
                                                <option value="K/1" {{ old('ptkp_status') == 'K/1' ? 'selected' : '' }}>K/1 - Kawin (1 Tanggungan) [TER B]</option>
                                                <option value="K/2" {{ old('ptkp_status') == 'K/2' ? 'selected' : '' }}>K/2 - Kawin (2 Tanggungan) [TER B]</option>
                                                <option value="K/3" {{ old('ptkp_status') == 'K/3' ? 'selected' : '' }}>K/3 - Kawin (3 Tanggungan) [TER C]</option>
                                            </select>
                                            <small class="form-text text-muted">Kategori TER (A, B, C) dihitung otomatis sesuai PP 58/2023</small>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary font-weight-bold btn-sm">+
                                                Tambah
                                            </button>
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
    <script>
        function previewFile() {
            var preview = document.getElementById('previewImage');
            var fileInput = document.getElementById('imageUpload');
            var fileName = document.getElementById('fileName');
            var file = fileInput.files[0];

            if (file) {
                // Validate file size (2MB max)
                if (file.size > 2048 * 1024) {
                    alert('Ukuran file terlalu besar. Maksimal 2MB');
                    fileInput.value = '';
                    return;
                }

                // Validate file type
                var validTypes = ['image/jpeg', 'image/jpg', 'image/png'];
                if (!validTypes.includes(file.type)) {
                    alert('Format file tidak valid. Gunakan JPG, JPEG, atau PNG');
                    fileInput.value = '';
                    return;
                }

                var reader = new FileReader();
                reader.onload = function () {
                    preview.src = reader.result;
                };
                reader.readAsDataURL(file);
                fileName.textContent = file.name;
            }
        }

        flatpickr("input[type=date]", {
            allowInput: true,
            maxDate: "today"
        });

        // NIK validation - only numbers, max 16 digits
        var nikInput = document.getElementById("nik");
        nikInput.addEventListener("input", function () {
            this.value = this.value.replace(/[^0-9]/g, '').slice(0, 16);
        });

        // Leave quota validation - only numbers, max 365
        var leaveQuotaInput = document.getElementById("leave_quota");
        leaveQuotaInput.addEventListener("input", function () {
            var value = parseInt(this.value);
            if (value > 365) {
                this.value = 365;
            } else if (value < 0) {
                this.value = 0;
            }
        });

        // Phone validation - only numbers
        var phoneInput = document.getElementById("phone");
        phoneInput.addEventListener("input", function () {
            this.value = this.value.replace(/[^0-9]/g, '');
        });

        // Zip code validation - only numbers, max 6 digits
        var zipCode = document.getElementById("zip_code");
        zipCode.addEventListener("input", function () {
            this.value = this.value.replace(/[^0-9]/g, '').slice(0, 6);
        });

        // Account number validation - only numbers
        var noAccount = document.getElementById("no_account");
        noAccount.addEventListener("input", function () {
            this.value = this.value.replace(/[^0-9]/g, '');
        });

        // Form validation before submit
        document.querySelector('form').addEventListener('submit', function(e) {
            var nik = document.getElementById('nik').value;
            if (nik.length !== 16) {
                e.preventDefault();
                alert('NIK harus 16 digit!');
                document.getElementById('nik').focus();
                return false;
            }
        });
    </script>
@endsection

