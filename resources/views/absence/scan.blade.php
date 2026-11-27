@extends('layouts.app')

@section('content')
<div class="content-page">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
                    <div>
                        <h4 class="font-weight-bold text-dark mb-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-camera mr-2 text-primary" viewBox="0 0 16 16">
                                <path d="M15 12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1h1.172a3 3 0 0 0 2.12-.879l.83-.828A1 1 0 0 1 7.829 3h.342a1 1 0 0 1 .707.293l.828.828A3 3 0 0 0 11.828 5H13a1 1 0 0 1 1 1v6zM2 4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1.172a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 9.172 2H6.828a2 2 0 0 0-1.414.586l-.828.828A2 2 0 0 1 3.172 4H2z"/>
                                <path d="M8 11a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5zm0 1a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7zM3 6.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0z"/>
                            </svg>
                            Presensi Kamera & Wajah
                        </h4>
                        <p class="text-muted mb-0">Verifikasi presensi kehadiran karyawan menggunakan kamera secara langsung</p>
                    </div>
                    <div class="d-flex align-items-center gap-2 mt-2 mt-md-0">
                        <button type="button" class="btn btn-outline-info btn-sm mr-2 shadow-sm font-weight-bold" data-toggle="modal" data-target="#manageModal">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-people mr-1" viewBox="0 0 16 16">
                                <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8zm-7.978-1A.261.261 0 0 1 7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002a.274.274 0 0 1-.014.002H7.022zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0zM6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816zM4.92 10A5.493 5.493 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275zM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0zm3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4z"/>
                            </svg>
                            Data Wajah Terdaftar (<span id="btn_enrolled_count">{{ count($enrolledEmployees) }}</span>)
                        </button>
                        <button type="button" class="btn btn-primary btn-sm mr-2 shadow-sm font-weight-bold" data-toggle="modal" data-target="#enrollModal">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-plus mr-1" viewBox="0 0 16 16">
                                <path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H1s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
                                <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z"/>
                            </svg>
                            Daftarkan Wajah Karyawan
                        </button>
                        <a href="{{ route('absence.index') }}" class="btn btn-outline-secondary btn-sm shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-table mr-1" viewBox="0 0 16 16">
                                <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm15 2h-4v3h4V4zm0 4h-4v3h4V8zm0 4h-4v3h3a1 1 0 0 0 1-1v-2zm-5 3v-3H6v3h4zm-5 0v-3H1v2a1 1 0 0 0 1 1h3zm-4-4h4V8H1v3zm0-4h4V4H1v3zm5-3v3h4V4H6zm4 4H6v3h4V8z"/>
                            </svg>
                            Data Absensi
                        </a>
                    </div>
                </div>
            </div>

            <!-- Panel Kamera -->
            <div class="col-lg-7">
                <div class="card card-block card-stretch card-height shadow-sm border-0">
                    <div class="card-body p-3">

                        <!-- Attendance Type Selector & Count -->
                        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 p-2 bg-light rounded border">
                            <div class="d-flex align-items-center">
                                <span class="font-weight-bold text-dark mr-2 small text-uppercase">Tipe:</span>
                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                    <label class="btn btn-sm btn-outline-success active" id="label_mode_in">
                                        <input type="radio" name="att_type" id="type_in" value="in" checked autocomplete="off">
                                        Presensi Masuk
                                    </label>
                                    <label class="btn btn-sm btn-outline-warning" id="label_mode_out">
                                        <input type="radio" name="att_type" id="type_out" value="out" autocomplete="off">
                                        Presensi Pulang
                                    </label>
                                </div>
                            </div>
                            <div class="mt-2 mt-sm-0">
                                <span id="enrolled_count_badge" class="badge badge-light border text-secondary px-2 py-1 font-weight-normal" style="cursor: pointer;" data-toggle="modal" data-target="#manageModal">
                                    {{ count($enrolledEmployees) }} Wajah Terdaftar
                                </span>
                            </div>
                        </div>

                        <!-- Kotak Viewfinder Kamera -->
                        <div class="camera-wrapper position-relative mx-auto rounded overflow-hidden shadow-sm" style="max-width: 540px; background-color: #1a1e29; min-height: 400px;">
                            <video id="webcam" autoplay playsinline muted style="width: 100%; height: 400px; object-fit: cover; transform: scaleX(-1);"></video>
                            <canvas id="overlay_canvas" class="position-absolute" style="top: 0; left: 0; width: 100%; height: 100%; pointer-events: none;"></canvas>
                            <canvas id="snapshot_canvas" style="display: none;"></canvas>

                            <!-- Panduan Area Wajah -->
                            <div id="scanner_guide" class="position-absolute" style="top: 14%; left: 24%; width: 52%; height: 68%; border: 2px dashed rgba(255, 255, 255, 0.45); border-radius: 18px; pointer-events: none; transition: border-color 0.3s ease;">
                            </div>

                            <!-- Status Badge (Kiri Atas) -->
                            <div class="position-absolute" style="top: 12px; left: 12px; z-index: 10;">
                                <span id="camera_status_badge" class="badge badge-dark px-2 py-1 shadow-sm" style="font-size: 11px; background: rgba(0,0,0,0.65);">
                                    <span class="spinner-border spinner-border-sm text-light mr-1" role="status" style="width: 8px; height: 8px;"></span> Menyiapkan Kamera...
                                </span>
                            </div>

                            <!-- Live Digital Clock (Kanan Bawah) -->
                            <div class="position-absolute" style="bottom: 12px; right: 12px; background: rgba(0,0,0,0.65); backdrop-filter: blur(4px); padding: 4px 10px; border-radius: 6px; z-index: 10;">
                                <span id="live_clock" class="text-white font-weight-bold" style="font-family: monospace; font-size: 13px;">00:00:00 WIB</span>
                            </div>

                            <!-- Banner Verifikasi Wajah -->
                            <div id="recognition_banner" class="position-absolute text-center w-100 d-none" style="bottom: 15px; left: 0; z-index: 15;">
                                <span id="recognition_text" class="badge badge-success px-3 py-2 shadow" style="font-size: 13px; border-radius: 20px;">
                                    ✓ Wajah Terverifikasi
                                </span>
                            </div>
                        </div>

                        <!-- Kontrol Presensi (Dropdown & Tombol) -->
                        <div class="mt-3 p-3 bg-light rounded border">
                            <div class="form-group mb-2">
                                <label for="employee_select" class="font-weight-bold text-dark small text-uppercase mb-1">
                                    Karyawan :
                                </label>
                                <select id="employee_select" class="form-control select2" style="width: 100%;">
                                    <option value="">-- Deteksi Wajah Otomatis (atau Pilih Manual) --</option>
                                    @foreach($employments as $emp)
                                        <option value="{{ $emp->nik }}" data-name="{{ $emp->name }}">
                                            {{ $emp->nik }} - {{ $emp->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="d-flex gap-2 mt-2">
                                <button type="button" id="btn_check_in" class="btn btn-success flex-fill font-weight-bold mr-1" onclick="manualSubmit('in')">
                                    Presensi Masuk
                                </button>
                                <button type="button" id="btn_check_out" class="btn btn-warning text-white flex-fill font-weight-bold ml-1" onclick="manualSubmit('out')">
                                    Presensi Pulang
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Panel Riwayat Presensi Hari Ini (Live) -->
            <div class="col-lg-5">
                <div class="card card-block card-stretch card-height shadow-sm border-0">
                    <div class="card-header d-flex justify-content-between align-items-center pb-0 border-0">
                        <h5 class="font-weight-bold text-dark">
                            Presensi Hari Ini
                        </h5>
                        <span class="badge badge-primary px-2 py-1 font-weight-bold">{{ date('d M Y') }}</span>
                    </div>
                    <div class="card-body p-3">
                        <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                            <table class="table table-hover mb-0" id="today_table">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Foto</th>
                                        <th>Karyawan</th>
                                        <th>Masuk</th>
                                        <th>Pulang</th>
                                    </tr>
                                </thead>
                                <tbody id="today_attendance_list">
                                    @forelse($todayAbsences as $today)
                                        <tr>
                                            <td>
                                                @if($today->image_path)
                                                    <img src="{{ asset('images/absence/' . $today->image_path) }}" alt="Snapshot" class="rounded-circle shadow-sm" width="38" height="38" style="object-fit: cover;">
                                                @else
                                                    <div class="rounded-circle bg-secondary text-white text-center font-weight-bold" style="width: 38px; height: 38px; line-height: 38px; font-size: 11px;">N/A</div>
                                                @endif
                                            </td>
                                            <td>
                                                <strong class="d-block text-dark">{{ $today->employment->name ?? '-' }}</strong>
                                                <small class="text-muted font-monospace">{{ $today->employment->nik ?? '-' }}</small>
                                            </td>
                                            <td>
                                                <span class="badge badge-success">{{ $today->time_in ?? '-' }}</span>
                                            </td>
                                            <td>
                                                <span class="badge badge-warning text-white">{{ $today->time_out ?? '-' }}</span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr id="no_data_row">
                                            <td colspan="4" class="text-center text-muted py-5">
                                                Belum ada data presensi hari ini.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Modal 1: Kelola Wajah Terdaftar (List Wajah & Reset) -->
<div class="modal fade" id="manageModal" tabindex="-1" role="dialog" aria-labelledby="manageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content shadow border-0">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title text-white font-weight-bold" id="manageModalLabel">
                    <i class="ri-user-shared-line mr-1"></i> Data Wajah Karyawan Terdaftar
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <p class="text-muted small mb-3">
                    Berikut adalah daftar karyawan yang telah memiliki profil biometrik wajah. Jika wajah salah terdaftar pada karyawan lain, klik tombol <b>Hapus / Reset</b>.
                </p>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th width="60">Foto</th>
                                <th>NIK</th>
                                <th>Nama Karyawan</th>
                                <th width="130" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="enrolled_table_body">
                            @forelse($enrolledEmployees as $enrolled)
                                <tr id="enrolled_row_{{ $enrolled->nik }}">
                                    <td class="text-center">
                                        @if($enrolled->image_path)
                                            <img src="{{ asset('images/absence/' . $enrolled->image_path) }}" width="38" height="38" class="rounded-circle shadow-sm" style="object-fit: cover;">
                                        @else
                                            <div class="rounded-circle bg-info text-white text-center font-weight-bold" style="width: 38px; height: 38px; line-height: 38px; font-size: 11px;">OK</div>
                                        @endif
                                    </td>
                                    <td class="font-weight-bold">{{ $enrolled->nik }}</td>
                                    <td>{{ $enrolled->name }}</td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-outline-danger py-1 px-2 font-weight-bold" onclick="resetFace('{{ $enrolled->nik }}', '{{ $enrolled->name }}')">
                                            <i class="ri-delete-bin-line mr-1"></i> Hapus
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr id="empty_enrolled_row">
                                    <td colspan="4" class="text-center text-muted py-4">
                                        Belum ada data wajah yang didaftarkan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal 2: Pendaftaran Wajah Karyawan (Kamera Live ATAU Upload Foto) -->
<div class="modal fade" id="enrollModal" tabindex="-1" role="dialog" aria-labelledby="enrollModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content shadow border-0">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title text-white font-weight-bold" id="enrollModalLabel">
                    Daftarkan Wajah Karyawan
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <div class="form-group mb-3">
                    <label class="font-weight-bold text-dark small text-uppercase">Pilih Karyawan:</label>
                    <select id="enroll_employee_select" class="form-control select2" style="width: 100%;">
                        <option value="">-- Pilih Nama / NIK Karyawan --</option>
                        @foreach($employments as $emp)
                            <option value="{{ $emp->nik }}" data-name="{{ $emp->name }}">
                                {{ $emp->nik }} - {{ $emp->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Pilihan Sumber: Kamera Webcam vs Upload File Foto -->
                <div class="form-group mb-3">
                    <label class="font-weight-bold text-dark small text-uppercase d-block">Sumber Foto Wajah:</label>
                    <div class="btn-group btn-group-toggle w-100" data-toggle="buttons">
                        <label class="btn btn-sm btn-outline-primary active w-50" id="opt_src_cam" onclick="switchEnrollSource('camera')">
                            <input type="radio" name="enroll_source" value="camera" checked autocomplete="off">
                            <i class="ri-camera-line mr-1"></i> Kamera Webcam
                        </label>
                        <label class="btn btn-sm btn-outline-primary w-50" id="opt_src_upload" onclick="switchEnrollSource('upload')">
                            <input type="radio" name="enroll_source" value="upload" autocomplete="off">
                            <i class="ri-upload-2-line mr-1"></i> Upload File Foto
                        </label>
                    </div>
                </div>

                <!-- Bagian 1: Preview Kamera Langsung -->
                <div id="enroll_camera_box" class="enroll-preview-box text-center p-3 rounded bg-light border position-relative">
                    <canvas id="enroll_canvas" class="rounded shadow-sm" width="280" height="210" style="object-fit: cover; background-color: #000;"></canvas>
                    <div class="mt-2">
                        <small class="text-muted">Arahkan wajah lurus ke arah webcam</small>
                    </div>
                </div>

                <!-- Bagian 2: Upload File Foto Karyawan -->
                <div id="enroll_upload_box" class="p-3 rounded bg-light border d-none">
                    <div class="custom-file mb-3">
                        <input type="file" class="custom-file-input" id="face_file_input" accept="image/jpeg,image/png,image/jpg" onchange="handleFileUpload(event)">
                        <label class="custom-file-label" for="face_file_input" id="face_file_label">Pilih file foto (JPG/PNG)...</label>
                    </div>
                    <div class="text-center">
                        <img id="upload_preview_img" class="rounded shadow-sm border d-none" width="220" height="220" style="object-fit: cover;">
                        <div id="upload_empty_hint" class="py-4 text-muted small">
                            <i class="ri-image-add-line ri-2x d-block mb-1"></i>
                            Pilih pasfoto formal atau foto wajah karyawan
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
                <button type="button" id="btn_save_face" class="btn btn-primary btn-sm font-weight-bold" onclick="saveEnrolledFace()">
                    Simpan Wajah
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Load Face-API.js library from CDN -->
<script src="https://cdn.jsdelivr.net/npm/face-api.js@0.22.2/dist/face-api.min.js"></script>

<script>
    var video = document.getElementById('webcam');
    var overlayCanvas = document.getElementById('overlay_canvas');
    var snapshotCanvas = document.getElementById('snapshot_canvas');
    var clockElement = document.getElementById('live_clock');
    var cameraStatusBadge = document.getElementById('camera_status_badge');

    // Data Karyawan Terdaftar
    var registeredEmployeesData = @json($enrolledEmployees);
    var faceMatcher = null;
    var isModelLoaded = false;
    var isProcessing = false;
    var lastCheckinNik = null;
    var lastCheckinTimestamp = 0;
    var consecutiveMatchCount = 0;
    var currentMatchedNik = null;
    var currentMatchedName = null;
    var currentEnrollSource = 'camera';
    var uploadedBase64 = null;

    // Live Clock
    setInterval(function() {
        var now = new Date();
        var hours = String(now.getHours()).padStart(2, '0');
        var minutes = String(now.getMinutes()).padStart(2, '0');
        var seconds = String(now.getSeconds()).padStart(2, '0');
        if (clockElement) {
            clockElement.innerText = hours + ':' + minutes + ':' + seconds + ' WIB';
        }
    }, 1000);

    // Audio Chime
    function playSuccessSound() {
        try {
            var AudioContext = window.AudioContext || window.webkitAudioContext;
            if (!AudioContext) return;
            var ctx = new AudioContext();
            var osc = ctx.createOscillator();
            var gain = ctx.createGain();
            osc.connect(gain);
            gain.connect(ctx.destination);
            osc.type = 'sine';
            osc.frequency.setValueAtTime(523.25, ctx.currentTime);
            osc.frequency.setValueAtTime(659.25, ctx.currentTime + 0.08);
            osc.frequency.setValueAtTime(783.99, ctx.currentTime + 0.16);
            gain.gain.setValueAtTime(0.2, ctx.currentTime);
            gain.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + 0.4);
            osc.start();
            osc.stop(ctx.currentTime + 0.4);
        } catch(e) {}
    }

    // 1. Inisialisasi Model Face-API
    async function loadModels() {
        var MODEL_URL = 'https://cdn.jsdelivr.net/gh/cgarciagl/face-api.js@master/weights';
        try {
            updateBadge('dark', 'Memuat Sistem Wajah...');
            await Promise.all([
                faceapi.nets.tinyFaceDetector.loadFromUri(MODEL_URL),
                faceapi.nets.faceLandmark68Net.loadFromUri(MODEL_URL),
                faceapi.nets.faceRecognitionNet.loadFromUri(MODEL_URL)
            ]);

            isModelLoaded = true;
            buildFaceMatcher();
            updateBadge('success', 'Kamera Siap');
            startDetectionLoop();
        } catch (err) {
            console.error("Model load error:", err);
            updateBadge('danger', 'Koneksi Model Terputus');
        }
    }

    // 2. Bangun FaceMatcher
    function buildFaceMatcher() {
        var labeledDescriptors = [];
        registeredEmployeesData.forEach(function(emp) {
            try {
                if (emp.face_descriptor) {
                    var descArray = typeof emp.face_descriptor === 'string' 
                        ? JSON.parse(emp.face_descriptor) 
                        : emp.face_descriptor;

                    if (descArray && descArray.length === 128) {
                        var float32 = new Float32Array(descArray);
                        labeledDescriptors.push(
                            new faceapi.LabeledFaceDescriptors(emp.nik + ':::' + emp.name, [float32])
                        );
                    }
                }
            } catch(e) {}
        });

        if (labeledDescriptors.length > 0) {
            faceMatcher = new faceapi.FaceMatcher(labeledDescriptors, 0.60);
            updateCountBadges(labeledDescriptors.length);
        } else {
            faceMatcher = null;
            updateCountBadges(0);
        }
    }

    function updateCountBadges(count) {
        var countEl = document.getElementById('btn_enrolled_count');
        var badgeEl = document.getElementById('enrolled_count_badge');
        if (countEl) countEl.innerText = count;
        if (badgeEl) badgeEl.innerText = count + ' Wajah Terdaftar';
    }

    // 3. Start Webcam
    function startCamera() {
        if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
            navigator.mediaDevices.getUserMedia({ 
                video: { width: 640, height: 480, facingMode: "user" } 
            })
            .then(function(stream) {
                video.srcObject = stream;
                video.onloadedmetadata = function() {
                    video.play();
                    overlayCanvas.width = video.videoWidth || 640;
                    overlayCanvas.height = video.videoHeight || 480;
                    loadModels();
                };
            })
            .catch(function(err) {
                console.error("Camera access error:", err);
                updateBadge('danger', 'Izin Kamera Diperlukan');
            });
        }
    }

    function updateBadge(type, text) {
        if (!cameraStatusBadge) return;
        cameraStatusBadge.className = 'badge badge-' + type + ' px-2 py-1 shadow-sm';
        cameraStatusBadge.innerHTML = '<span class="spinner-grow spinner-grow-sm text-light mr-1" role="status" style="width: 7px; height: 7px;"></span> ' + text;
    }

    // 4. Deteksi Wajah Real-Time Loop
    async function startDetectionLoop() {
        if (!isModelLoaded || !video || video.paused || video.ended) {
            requestAnimationFrame(startDetectionLoop);
            return;
        }

        try {
            var options = new faceapi.TinyFaceDetectorOptions({ inputSize: 416, scoreThreshold: 0.25 });
            var detection = await faceapi.detectSingleFace(video, options)
                .withFaceLandmarks()
                .withFaceDescriptor();

            var ctx = overlayCanvas.getContext('2d');
            ctx.clearRect(0, 0, overlayCanvas.width, overlayCanvas.height);
            var guide = document.getElementById('scanner_guide');

            if (detection) {
                var box = detection.detection.box;
                var mirroredX = overlayCanvas.width - box.x - box.width;

                var label = "Wajah Belum Terdaftar";
                var boxColor = "#17a2b8";
                var isRecognized = false;
                var recognizedNik = null;
                var recognizedName = null;

                if (faceMatcher) {
                    var match = faceMatcher.findBestMatch(detection.descriptor);
                    if (match && match.label !== 'unknown') {
                        var parts = match.label.split(':::');
                        recognizedNik = parts[0];
                        recognizedName = parts[1] || parts[0];

                        label = recognizedName;
                        boxColor = "#28a745";
                        isRecognized = true;
                    }
                }

                if (guide) {
                    guide.style.borderColor = isRecognized ? '#28a745' : 'rgba(255,255,255,0.7)';
                }

                drawFaceBox(ctx, mirroredX, box.y, box.width, box.height, boxColor, label);

                if (isRecognized && !isProcessing) {
                    if (currentMatchedNik === recognizedNik) {
                        consecutiveMatchCount++;
                    } else {
                        currentMatchedNik = recognizedNik;
                        currentMatchedName = recognizedName;
                        consecutiveMatchCount = 1;
                    }

                    if (consecutiveMatchCount >= 2) {
                        var now = Date.now();
                        if (recognizedNik !== lastCheckinNik || (now - lastCheckinTimestamp > 12000)) {
                            executeCheckIn(recognizedNik, recognizedName);
                        }
                    }
                } else if (!isRecognized) {
                    consecutiveMatchCount = 0;
                    currentMatchedNik = null;
                }
            } else {
                if (guide) guide.style.borderColor = 'rgba(255,255,255,0.45)';
                consecutiveMatchCount = 0;
                currentMatchedNik = null;
            }
        } catch (e) {
            console.warn("Detection error:", e);
        }

        setTimeout(startDetectionLoop, 100);
    }

    function drawFaceBox(ctx, x, y, width, height, color, label) {
        ctx.strokeStyle = color;
        ctx.lineWidth = 2.5;
        ctx.strokeRect(x, y, width, height);

        ctx.fillStyle = color;
        var textWidth = ctx.measureText(label).width;
        ctx.fillRect(x, y - 24, textWidth + 14, 24);

        ctx.fillStyle = '#ffffff';
        ctx.font = 'bold 12px sans-serif';
        ctx.fillText(label, x + 7, y - 7);
    }

    // 5. Eksekusi Check-In
    function executeCheckIn(nik, name) {
        isProcessing = true;
        lastCheckinNik = nik;
        lastCheckinTimestamp = Date.now();
        consecutiveMatchCount = 0;

        playSuccessSound();

        var attType = document.querySelector('input[name="att_type"]:checked').value || 'in';
        var typeLabel = (attType === 'in') ? 'Masuk' : 'Pulang';

        var banner = document.getElementById('recognition_banner');
        var bannerText = document.getElementById('recognition_text');
        bannerText.innerText = '✓ ' + name + ' Terverifikasi (Presensi ' + typeLabel + ')';
        banner.classList.remove('d-none');

        var snapshot = captureSnapshot();

        fetch('{{ route("absence.webCheckIn") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                nik: nik,
                type: attType,
                image: snapshot
            })
        })
        .then(res => res.json())
        .then(data => {
            isProcessing = false;

            if (data.success) {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Presensi Berhasil',
                        text: name + ' berhasil presensi ' + typeLabel + ' (' + data.data.time + ')',
                        timer: 3000,
                        showConfirmButton: false,
                        toast: true,
                        position: 'top-end'
                    });
                }
                updateTodayTable(data.data, attType);
                setTimeout(() => { banner.classList.add('d-none'); }, 3000);
            } else {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'info',
                        title: 'Info Presensi',
                        text: data.message,
                        timer: 3500,
                        showConfirmButton: false,
                        toast: true,
                        position: 'top-end'
                    });
                }
                setTimeout(() => { banner.classList.add('d-none'); }, 2000);
            }
        })
        .catch(() => {
            isProcessing = false;
            banner.classList.add('d-none');
        });
    }

    // Manual Submit
    function manualSubmit(type) {
        var nik = $('#employee_select').val();
        if (!nik) {
            Swal.fire('Pilih Karyawan', 'Silakan pilih karyawan terlebih dahulu dari daftar.', 'warning');
            return;
        }

        var btnIn = document.getElementById('btn_check_in');
        var btnOut = document.getElementById('btn_check_out');
        btnIn.disabled = true;
        btnOut.disabled = true;

        var snapshot = captureSnapshot();

        fetch('{{ route("absence.webCheckIn") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                nik: nik,
                type: type,
                image: snapshot
            })
        })
        .then(res => res.json())
        .then(data => {
            btnIn.disabled = false;
            btnOut.disabled = false;

            if (data.success) {
                playSuccessSound();
                Swal.fire('Berhasil', data.message, 'success');
                updateTodayTable(data.data, type);
                $('#employee_select').val('').trigger('change');
            } else {
                Swal.fire('Pemberitahuan', data.message, 'info');
            }
        })
        .catch(() => {
            btnIn.disabled = false;
            btnOut.disabled = false;
            Swal.fire('Error', 'Gagal memproses presensi.', 'error');
        });
    }

    function captureSnapshot() {
        try {
            snapshotCanvas.width = video.videoWidth || 640;
            snapshotCanvas.height = video.videoHeight || 480;
            var ctx = snapshotCanvas.getContext('2d');
            ctx.translate(snapshotCanvas.width, 0);
            ctx.scale(-1, 1);
            ctx.drawImage(video, 0, 0, snapshotCanvas.width, snapshotCanvas.height);
            return snapshotCanvas.toDataURL('image/jpeg', 0.85);
        } catch(e) {
            return null;
        }
    }

    function updateTodayTable(data, type) {
        var list = document.getElementById('today_attendance_list');
        var noDataRow = document.getElementById('no_data_row');
        if (noDataRow) noDataRow.remove();

        var newRow = document.createElement('tr');
        var imgHtml = data.image 
            ? '<img src="' + data.image + '" class="rounded-circle shadow-sm" width="38" height="38" style="object-fit: cover;">'
            : '<div class="rounded-circle bg-success text-white text-center font-weight-bold" style="width: 38px; height: 38px; line-height: 38px; font-size: 11px;">OK</div>';

        newRow.innerHTML = 
            '<td>' + imgHtml + '</td>' +
            '<td><strong class="d-block text-dark">' + data.name + '</strong><small class="text-muted font-monospace">' + data.nik + '</small></td>' +
            '<td><span class="badge badge-success">' + (type === 'in' ? data.time : '-') + '</span></td>' +
            '<td><span class="badge badge-warning text-white">' + (type === 'out' ? data.time : '-') + '</span></td>';

        list.insertBefore(newRow, list.firstChild);
    }

    // 6. Reset Wajah Terdaftar
    function resetFace(nik, name) {
        Swal.fire({
            title: 'Hapus Data Wajah?',
            html: 'Apakah Anda yakin ingin menghapus data biometrik wajah <b>' + name + '</b> (' + nik + ')?<br><small class="text-danger">Karyawan ini tidak akan lagi otomatis terdeteksi.</small>',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then(function(result) {
            if (result.isConfirmed) {
                var csrf = $('meta[name="csrf-token"]').attr('content') || '{{ csrf_token() }}';

                $.ajax({
                    url: '{{ route("absence.resetFace") }}',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrf,
                        'Accept': 'application/json'
                    },
                    data: {
                        nik: nik,
                        _token: csrf
                    },
                    success: function(data) {
                        if (data && data.success) {
                            registeredEmployeesData = registeredEmployeesData.filter(function(e) { return e.nik !== nik; });
                            buildFaceMatcher();

                            var row = document.getElementById('enrolled_row_' + nik);
                            if (row) row.remove();

                            if (registeredEmployeesData.length === 0) {
                                var tbody = document.getElementById('enrolled_table_body');
                                if (tbody) {
                                    tbody.innerHTML = '<tr id="empty_enrolled_row"><td colspan="4" class="text-center text-muted py-4">Belum ada data wajah yang didaftarkan.</td></tr>';
                                }
                            }

                            Swal.fire('Terhapus!', data.message, 'success');
                        } else {
                            Swal.fire('Gagal', (data && data.message) ? data.message : 'Terjadi kesalahan.', 'error');
                        }
                    },
                    error: function(xhr) {
                        var msg = 'Gagal menghapus data wajah.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            msg = xhr.responseJSON.message;
                        }
                        Swal.fire('Error', msg, 'error');
                    }
                });
            }
        });
    }

    // 7. Modal Pendaftaran Wajah (Kamera / Upload)
    var enrollCanvas = document.getElementById('enroll_canvas');
    var enrollInterval = null;

    function switchEnrollSource(src) {
        currentEnrollSource = src;
        if (src === 'camera') {
            $('#enroll_camera_box').removeClass('d-none');
            $('#enroll_upload_box').addClass('d-none');
            startEnrollCameraPreview();
        } else {
            $('#enroll_camera_box').addClass('d-none');
            $('#enroll_upload_box').removeClass('d-none');
            if (enrollInterval) clearInterval(enrollInterval);
        }
    }

    function startEnrollCameraPreview() {
        var ctx = enrollCanvas.getContext('2d');
        if (enrollInterval) clearInterval(enrollInterval);
        enrollInterval = setInterval(function() {
            if (video && !video.paused) {
                ctx.save();
                ctx.translate(enrollCanvas.width, 0);
                ctx.scale(-1, 1);
                ctx.drawImage(video, 0, 0, enrollCanvas.width, enrollCanvas.height);
                ctx.restore();
            }
        }, 100);
    }

    $('#enrollModal').on('shown.bs.modal', function () {
        if (currentEnrollSource === 'camera') {
            startEnrollCameraPreview();
        }
    });

    $('#enrollModal').on('hidden.bs.modal', function () {
        if (enrollInterval) clearInterval(enrollInterval);
    });

    function handleFileUpload(event) {
        var file = event.target.files[0];
        if (!file) return;

        var label = document.getElementById('face_file_label');
        label.innerText = file.name;

        var reader = new FileReader();
        reader.onload = function(e) {
            uploadedBase64 = e.target.result;
            var img = document.getElementById('upload_preview_img');
            img.src = uploadedBase64;
            img.classList.remove('d-none');
            document.getElementById('upload_empty_hint').classList.add('d-none');
        };
        reader.readAsDataURL(file);
    }

    async function saveEnrolledFace() {
        var nik = $('#enroll_employee_select').val();
        if (!nik) {
            Swal.fire('Pilih Karyawan', 'Silakan pilih karyawan terlebih dahulu.', 'warning');
            return;
        }

        var btn = document.getElementById('btn_save_face');
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm mr-1"></span> Menganalisis Wajah...';

        try {
            var options = new faceapi.TinyFaceDetectorOptions({ inputSize: 416, scoreThreshold: 0.25 });
            var detection = null;
            var snapshotData = null;

            if (currentEnrollSource === 'camera') {
                detection = await faceapi.detectSingleFace(video, options)
                    .withFaceLandmarks()
                    .withFaceDescriptor();
                snapshotData = captureSnapshot();
            } else {
                var previewImg = document.getElementById('upload_preview_img');
                if (!previewImg || !previewImg.src || previewImg.classList.contains('d-none')) {
                    btn.disabled = false;
                    btn.innerHTML = 'Simpan Wajah';
                    Swal.fire('Pilih Foto', 'Silakan pilih file foto terlebih dahulu.', 'warning');
                    return;
                }
                detection = await faceapi.detectSingleFace(previewImg, options)
                    .withFaceLandmarks()
                    .withFaceDescriptor();
                snapshotData = uploadedBase64;
            }

            if (!detection) {
                btn.disabled = false;
                btn.innerHTML = 'Simpan Wajah';
                Swal.fire({
                    icon: 'warning',
                    title: 'Wajah Belum Terdeteksi',
                    text: currentEnrollSource === 'camera' 
                        ? 'Pastikan wajah menghadap lurus ke kamera dan pencahayaan cukup.' 
                        : 'Wajah tidak terdeteksi pada foto yang diunggah. Pastikan foto jelas dan menampilkan wajah bagian depan.'
                });
                return;
            }

            var descriptorArray = Array.from(detection.descriptor);

            var response = await fetch('{{ route("absence.enrollFace") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    nik: nik,
                    descriptor: descriptorArray,
                    image: snapshotData
                })
            });

            var result = await response.json();
            btn.disabled = false;
            btn.innerHTML = 'Simpan Wajah';

            if (result.success) {
                var empName = $('#enroll_employee_select option:selected').data('name') || result.data.name;
                var found = registeredEmployeesData.find(e => e.nik === nik);
                if (found) {
                    found.face_descriptor = descriptorArray;
                    if (result.data.image) found.image_path = result.data.image;
                } else {
                    registeredEmployeesData.push({
                        nik: nik,
                        name: empName,
                        face_descriptor: descriptorArray,
                        image_path: result.data.image
                    });
                }

                buildFaceMatcher();

                // Tambahkan atau update di modal Data Wajah Terdaftar
                var emptyRow = document.getElementById('empty_enrolled_row');
                if (emptyRow) emptyRow.remove();

                var existingRow = document.getElementById('enrolled_row_' + nik);
                if (existingRow) {
                    existingRow.querySelector('td:nth-child(3)').innerText = empName;
                } else {
                    var tbody = document.getElementById('enrolled_table_body');
                    var newTr = document.createElement('tr');
                    newTr.id = 'enrolled_row_' + nik;
                    newTr.innerHTML = 
                        '<td class="text-center">' +
                            (result.data.image 
                                ? '<img src="' + result.data.image + '" width="38" height="38" class="rounded-circle shadow-sm" style="object-fit: cover;">' 
                                : '<div class="rounded-circle bg-info text-white text-center font-weight-bold" style="width: 38px; height: 38px; line-height: 38px; font-size: 11px;">OK</div>') +
                        '</td>' +
                        '<td class="font-weight-bold">' + nik + '</td>' +
                        '<td>' + empName + '</td>' +
                        '<td class="text-center">' +
                            '<button type="button" class="btn btn-sm btn-outline-danger py-1 px-2 font-weight-bold" onclick="resetFace(\'' + nik + '\', \'' + empName + '\')">' +
                                '<i class="ri-delete-bin-line mr-1"></i> Hapus' +
                            '</button>' +
                        '</td>';
                    tbody.appendChild(newTr);
                }

                $('#enrollModal').modal('hide');

                Swal.fire({
                    icon: 'success',
                    title: 'Wajah Berhasil Disimpan!',
                    text: 'Wajah ' + empName + ' (' + nik + ') telah aktif. Sekarang arahkan wajah ke kamera untuk presensi.',
                    confirmButtonText: 'OK'
                });
            } else {
                Swal.fire('Gagal', result.message, 'error');
            }
        } catch(err) {
            btn.disabled = false;
            btn.innerHTML = 'Simpan Wajah';
            Swal.fire('Error', 'Gagal memproses pendaftaran wajah: ' + err.message, 'error');
        }
    }

    document.addEventListener("DOMContentLoaded", function() {
        startCamera();
    });
</script>
@endsection
