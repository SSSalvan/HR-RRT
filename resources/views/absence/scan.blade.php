@extends('layouts.app')

@section('content')
<div class="content-page">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
                    <div>
                        <h4 class="font-weight-bold text-primary mb-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-person-bounding-box mr-2 text-primary" viewBox="0 0 16 16">
                                <path d="M1.5 1a.5.5 0 0 0-.5.5v3a.5.5 0 0 1-1 0v-3A1.5 1.5 0 0 1 1.5 0h3a.5.5 0 0 1 0 1h-3zM11 .5a.5.5 0 0 1 .5-.5h3A1.5 1.5 0 0 1 16 1.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 1-.5-.5zM.5 11a.5.5 0 0 1 .5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 1 0 1h-3A1.5 1.5 0 0 1 0 14.5v-3a.5.5 0 0 1 .5-.5zm15 0a.5.5 0 0 1 .5.5v3a1.5 1.5 0 0 1-1.5 1.5h-3a.5.5 0 0 1 0-1h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 1 .5-.5z"/>
                                <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm8-9a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                            </svg>
                            Smart Face Recognition Attendance (Hands-Free AI)
                        </h4>
                        <p class="text-muted mb-0">Presensi biometrik otomatis berbasis AI Vision — Cukup tatap kamera untuk clock-in/out tanpa sentuh tombol</p>
                    </div>
                    <div class="d-flex align-items-center gap-2 mt-2 mt-md-0">
                        <button type="button" class="btn btn-outline-primary btn-sm mr-2 shadow-sm font-weight-bold" data-toggle="modal" data-target="#enrollModal">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-plus-fill mr-1" viewBox="0 0 16 16">
                                <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
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

            <!-- Panel Kamera & AI Recognition -->
            <div class="col-lg-7">
                <div class="card card-block card-stretch card-height shadow-sm border-0">
                    <div class="card-body p-3">

                        <!-- Mode Switcher & Attendance Type Selector -->
                        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 p-2 bg-light rounded border">
                            <div class="d-flex align-items-center">
                                <span class="font-weight-bold text-dark mr-2 small text-uppercase">Tipe Presensi:</span>
                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                    <label class="btn btn-sm btn-outline-success active" id="label_mode_in">
                                        <input type="radio" name="att_type" id="type_in" value="in" checked autocomplete="off">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-box-arrow-in-right mr-1" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14 2H6a1.5 1.5 0 0 0-1.5 1.5v2a.5.5 0 0 0 1 0v-2z"/>
                                            <path fill-rule="evenodd" d="M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
                                        </svg>
                                        Absen Masuk
                                    </label>
                                    <label class="btn btn-sm btn-outline-warning" id="label_mode_out">
                                        <input type="radio" name="att_type" id="type_out" value="out" autocomplete="off">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-box-arrow-left mr-1" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6 1h8A1.5 1.5 0 0 1 15.5 2.5v9a1.5 1.5 0 0 1-1.5 1.5H6a1.5 1.5 0 0 1-1.5-1.5v-2a.5.5 0 0 1 1 0v2z"/>
                                            <path fill-rule="evenodd" d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3z"/>
                                        </svg>
                                        Absen Pulang
                                    </label>
                                </div>
                            </div>
                            <div class="mt-2 mt-sm-0">
                                <span id="enrolled_count_badge" class="badge badge-info px-2 py-1">
                                    {{ count($enrolledEmployees) }} Wajah Terdaftar
                                </span>
                            </div>
                        </div>

                        <!-- Kotak Viewfinder Kamera & Canvas Overlay -->
                        <div class="camera-wrapper position-relative mx-auto rounded overflow-hidden shadow-sm" style="max-width: 540px; background-color: #0b0f19; min-height: 400px;">
                            <video id="webcam" autoplay playsinline muted style="width: 100%; height: 400px; object-fit: cover; transform: scaleX(-1);"></video>
                            <canvas id="overlay_canvas" class="position-absolute" style="top: 0; left: 0; width: 100%; height: 100%; pointer-events: none;"></canvas>
                            <canvas id="snapshot_canvas" style="display: none;"></canvas>

                            <!-- Scan Guide Frame -->
                            <div id="scanner_guide" class="position-absolute" style="top: 15%; left: 22%; width: 56%; height: 70%; border: 2px dashed rgba(0, 230, 118, 0.4); border-radius: 20px; pointer-events: none; transition: all 0.3s ease;">
                                <div class="scanner-laser" id="scanner_laser"></div>
                            </div>

                            <!-- Status AI Badge (Kiri Atas) -->
                            <div class="position-absolute" style="top: 12px; left: 12px; z-index: 10;">
                                <span id="ai_status_badge" class="badge badge-warning px-2 py-1 shadow" style="font-size: 11px;">
                                    <span class="spinner-border spinner-border-sm text-light mr-1" role="status" style="width: 10px; height: 10px;"></span> Memuat Model AI...
                                </span>
                            </div>

                            <!-- Live Digital Clock (Kanan Bawah) -->
                            <div class="position-absolute" style="bottom: 12px; right: 12px; background: rgba(0,0,0,0.7); backdrop-filter: blur(4px); padding: 4px 10px; border-radius: 6px; z-index: 10;">
                                <span id="live_clock" class="text-white font-weight-bold" style="font-family: monospace; font-size: 13px;">00:00:00 WIB</span>
                            </div>

                            <!-- Active Recognition Toast (Tengah Bawah) -->
                            <div id="ai_recognition_banner" class="position-absolute text-center w-100 d-none" style="bottom: 15px; left: 0; z-index: 15;">
                                <span id="ai_recognition_text" class="badge badge-success px-3 py-2 shadow-lg" style="font-size: 13px; border-radius: 20px; background-color: rgba(0, 200, 83, 0.95);">
                                    ✓ Wajah Terdeteksi
                                </span>
                            </div>
                        </div>

                        <!-- Feedback Box -->
                        <div id="feedback_alert" class="alert mt-3 mb-2 d-none shadow-sm" role="alert">
                            <span id="feedback_message"></span>
                        </div>

                        <!-- Petunjuk Hands-Free / Fallback Manual -->
                        <div class="mt-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="small font-weight-bold text-muted text-uppercase">
                                    <i class="ri-information-line text-info mr-1"></i> Mode AI Hands-Free Aktif
                                </span>
                                <a href="javascript:void(0)" class="small text-primary font-weight-bold" onclick="toggleManualMode()">
                                    <span id="manual_toggle_text">Gunakan Mode Manual</span>
                                </a>
                            </div>

                            <!-- Panel Manual (Disembunyikan secara default) -->
                            <div id="manual_control_panel" class="mt-2 p-3 bg-light rounded border d-none">
                                <div class="form-group mb-2">
                                    <label class="font-weight-bold text-muted small mb-1">Pilih Karyawan Secara Manual:</label>
                                    <select id="employee_select" class="form-control form-control-sm select2" style="width: 100%;">
                                        <option value="">-- Cari Nama / NIK Karyawan --</option>
                                        @foreach($employments as $emp)
                                            <option value="{{ $emp->nik }}">
                                                {{ $emp->nik }} - {{ $emp->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-sm btn-success flex-fill font-weight-bold mr-1" onclick="submitAttendance('in', true)">
                                        Absen Masuk (Manual)
                                    </button>
                                    <button type="button" class="btn btn-sm btn-warning text-white flex-fill font-weight-bold ml-1" onclick="submitAttendance('out', true)">
                                        Absen Pulang (Manual)
                                    </button>
                                </div>
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-clock-history mr-1 text-primary" viewBox="0 0 16 16">
                                <path d="M8.515 1.019A7 7 0 0 0 8 1V0a8 8 0 0 1 .589.022l-.074.997zm2.004.45a7.003 7.003 0 0 0-.985-.299l.219-.976c.383.086.76.2 1.126.342l-.36.933zm1.376.795c.382.188.745.407 1.085.655l-.602.8a7.015 7.015 0 0 0-.923-.563l.44-.892zM16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM4.5 7.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 .5-.5v-4a.5.5 0 0 0-1 0v3.5H4.5z"/>
                            </svg>
                            Presensi Hari Ini (Live)
                        </h5>
                        <span class="badge badge-primary px-2 py-1 font-weight-bold">{{ date('d M Y') }}</span>
                    </div>
                    <div class="card-body p-3">
                        <div class="table-responsive" style="max-height: 480px; overflow-y: auto;">
                            <table class="table table-hover mb-0" id="today_table">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Foto</th>
                                        <th>Karyawan</th>
                                        <th>Metode</th>
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
                                                @if($today->method == 'camera')
                                                    <span class="badge badge-light-success text-success font-weight-bold" style="font-size: 10px;">
                                                        <i class="ri-scan-line mr-1"></i>AI Vision
                                                    </span>
                                                @else
                                                    <span class="badge badge-light font-weight-bold text-muted" style="font-size: 10px;">Manual</span>
                                                @endif
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
                                            <td colspan="5" class="text-center text-muted py-5">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-inbox text-muted mb-2 d-block mx-auto" viewBox="0 0 16 16">
                                                    <path d="M4.98 4a.5.5 0 0 0-.39.188L1.54 8H6a.5.5 0 0 1 .5.5 1.5 1.5 0 1 0 3 0A.5.5 0 0 1 10 8h4.46l-3.05-3.812A.5.5 0 0 0 11.02 4H4.98zm9.954 5H10.45a2.5 2.5 0 0 1-4.9 0H1.066l.32 2.562a.5.5 0 0 0 .497.438h12.234a.5.5 0 0 0 .496-.438L14.934 9zM3.804 3.5A1.5 1.5 0 0 1 4.98 3h6.04a1.5 1.5 0 0 1 1.176.5l3.5 4.375A1.5 1.5 0 0 1 16 8.875v4.625a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 13.5V8.875c0-.327.107-.643.304-.897L3.804 3.5z"/>
                                                </svg>
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

<!-- Modal Pendaftaran Wajah Karyawan (Face Enrollment) -->
<div class="modal fade" id="enrollModal" tabindex="-1" role="dialog" aria-labelledby="enrollModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content shadow-lg border-0">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title text-white font-weight-bold" id="enrollModalLabel">
                    <i class="ri-user-smile-line mr-1"></i> Daftarkan Wajah Karyawan
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <p class="text-muted small mb-3">
                    Pilih nama karyawan, lalu hadapkan wajah lurus ke kamera. Sistem AI akan mengekstrak 128 titik biometrik wajah sebagai profil pengenal otomatis.
                </p>

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

                <div class="enroll-preview-box text-center p-3 rounded bg-light border position-relative">
                    <canvas id="enroll_canvas" class="rounded shadow-sm" width="280" height="210" style="object-fit: cover; background-color: #000;"></canvas>
                    <div id="enroll_indicator" class="mt-2">
                        <span class="badge badge-secondary px-3 py-1 font-weight-bold" id="enroll_badge">
                            Menunggu Posisi Wajah...
                        </span>
                    </div>
                </div>

                <div class="alert alert-info mt-3 mb-0 small">
                    <i class="ri-lightbulb-line mr-1"></i>
                    <strong>Tips:</strong> Pastikan wajah berada di area terang dan menghadap lurus ke kamera tanpa masker.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Tutup</button>
                <button type="button" id="btn_save_face" class="btn btn-primary btn-sm font-weight-bold" onclick="saveEnrolledFace()">
                    <i class="ri-check-line mr-1"></i> Simpan Biometrik Wajah
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    .scanner-laser {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 2px;
        background: linear-gradient(90deg, transparent, #00e676, transparent);
        box-shadow: 0 0 12px #00e676;
        animation: laserScan 2.5s infinite alternate ease-in-out;
    }
    @keyframes laserScan {
        0% { top: 0%; opacity: 0.2; }
        50% { opacity: 1; }
        100% { top: 98%; opacity: 0.2; }
    }
</style>

<!-- Load Face-API.js library from CDN -->
<script src="https://cdn.jsdelivr.net/npm/face-api.js@0.22.2/dist/face-api.min.js"></script>

<script>
    var video = document.getElementById('webcam');
    var overlayCanvas = document.getElementById('overlay_canvas');
    var snapshotCanvas = document.getElementById('snapshot_canvas');
    var clockElement = document.getElementById('live_clock');
    var aiStatusBadge = document.getElementById('ai_status_badge');

    // Data Karyawan Terdaftar dari Database
    var registeredEmployeesData = @json($enrolledEmployees);
    var faceMatcher = null;
    var isModelLoaded = false;
    var isCheckingIn = false;
    var lastCheckinNik = null;
    var lastCheckinTimestamp = 0;
    var consecutiveMatchCount = 0;
    var currentMatchedNik = null;
    var currentMatchedName = null;

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

    // Audio Chime (Web Audio API Synthesizer)
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
            osc.frequency.setValueAtTime(523.25, ctx.currentTime); // C5
            osc.frequency.setValueAtTime(659.25, ctx.currentTime + 0.08); // E5
            osc.frequency.setValueAtTime(783.99, ctx.currentTime + 0.16); // G5
            osc.frequency.setValueAtTime(1046.50, ctx.currentTime + 0.24); // C6
            gain.gain.setValueAtTime(0.2, ctx.currentTime);
            gain.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + 0.5);
            osc.start();
            osc.stop(ctx.currentTime + 0.5);
        } catch(e) {}
    }

    // 1. Inisialisasi Model AI Face-API
    async function loadAIModels() {
        var MODEL_URL = 'https://cdn.jsdelivr.net/gh/cgarciagl/face-api.js@master/weights';
        try {
            updateAiBadge('warning', 'Memuat Model AI Biometrik...');
            await Promise.all([
                faceapi.nets.tinyFaceDetector.loadFromUri(MODEL_URL),
                faceapi.nets.faceLandmark68Net.loadFromUri(MODEL_URL),
                faceapi.nets.faceRecognitionNet.loadFromUri(MODEL_URL)
            ]);

            isModelLoaded = true;
            buildFaceMatcher();
            updateAiBadge('success', 'AI Aktif & Siap Mengenali Wajah');
            startAutoScanLoop();
        } catch (err) {
            console.error("Gagal memuat model face-api:", err);
            updateAiBadge('danger', 'Gagal Memuat Model AI (Periksa Internet)');
        }
    }

    // 2. Bangun FaceMatcher dari data database
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
            } catch(e) {
                console.warn("Parse descriptor error:", e);
            }
        });

        if (labeledDescriptors.length > 0) {
            faceMatcher = new faceapi.FaceMatcher(labeledDescriptors, 0.52);
            document.getElementById('enrolled_count_badge').innerText = labeledDescriptors.length + ' Wajah Terdaftar';
        } else {
            faceMatcher = null;
            document.getElementById('enrolled_count_badge').innerText = '0 Wajah Terdaftar';
        }
    }

    // 3. Menyalakan Webcam
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
                    loadAIModels();
                };
            })
            .catch(function(err) {
                console.error("Camera access error:", err);
                updateAiBadge('danger', 'Kamera Tidak Tersedia (Berikan Izin)');
            });
        }
    }

    function updateAiBadge(type, text) {
        if (!aiStatusBadge) return;
        aiStatusBadge.className = 'badge badge-' + type + ' px-2 py-1 shadow';
        aiStatusBadge.innerHTML = '<span class="spinner-grow spinner-grow-sm text-light mr-1" role="status" style="width: 8px; height: 8px;"></span> ' + text;
    }

    // 4. Real-time Face Detection & Recognition Loop
    async function startAutoScanLoop() {
        if (!isModelLoaded || !video || video.paused || video.ended) {
            requestAnimationFrame(startAutoScanLoop);
            return;
        }

        try {
            var options = new faceapi.TinyFaceDetectorOptions({ inputSize: 320, scoreThreshold: 0.5 });
            var detection = await faceapi.detectSingleFace(video, options)
                .withFaceLandmarks()
                .withFaceDescriptor();

            var ctx = overlayCanvas.getContext('2d');
            ctx.clearRect(0, 0, overlayCanvas.width, overlayCanvas.height);

            if (detection) {
                var box = detection.detection.box;
                // Karena video di-mirror scaleX(-1), kita hitung posisi mirror untuk canvas
                var mirroredX = overlayCanvas.width - box.x - box.width;

                var label = "Wajah Belum Terdaftar";
                var boxColor = "#ff9800"; // Orange
                var isRecognized = false;
                var recognizedNik = null;
                var recognizedName = null;

                if (faceMatcher) {
                    var match = faceMatcher.findBestMatch(detection.descriptor);
                    if (match && match.label !== 'unknown') {
                        var parts = match.label.split(':::');
                        recognizedNik = parts[0];
                        recognizedName = parts[1] || parts[0];
                        var confidence = Math.round((1 - match.distance) * 100);

                        label = recognizedName + " (" + confidence + "%)";
                        boxColor = "#00e676"; // Hijau cerah
                        isRecognized = true;
                    }
                }

                // Gambar Bounding Box Keren Berorientasi Sudut (Cyber HUD style)
                drawBoundingBox(ctx, mirroredX, box.y, box.width, box.height, boxColor, label);

                // Logika Verifikasi Otomatis Hands-Free
                if (isRecognized && !isCheckingIn) {
                    if (currentMatchedNik === recognizedNik) {
                        consecutiveMatchCount++;
                    } else {
                        currentMatchedNik = recognizedNik;
                        currentMatchedName = recognizedName;
                        consecutiveMatchCount = 1;
                    }

                    // Jika wajah cocok stabil selama minimal 3 frame (~1 detik)
                    if (consecutiveMatchCount >= 3) {
                        var now = Date.now();
                        // Cooldown 15 detik agar tidak absen berulang-ulang
                        if (recognizedNik !== lastCheckinNik || (now - lastCheckinTimestamp > 15000)) {
                            triggerAutoCheckIn(recognizedNik, recognizedName);
                        }
                    }
                } else if (!isRecognized) {
                    consecutiveMatchCount = 0;
                    currentMatchedNik = null;
                }
            } else {
                consecutiveMatchCount = 0;
                currentMatchedNik = null;
            }
        } catch (e) {
            console.warn("Scan loop frame error:", e);
        }

        setTimeout(startAutoScanLoop, 150);
    }

    function drawBoundingBox(ctx, x, y, width, height, color, label) {
        ctx.strokeStyle = color;
        ctx.lineWidth = 3;
        ctx.strokeRect(x, y, width, height);

        // Header Label Background
        ctx.fillStyle = color;
        var textWidth = ctx.measureText(label).width;
        ctx.fillRect(x, y - 26, textWidth + 16, 26);

        // Header Label Text
        ctx.fillStyle = '#000000';
        ctx.font = 'bold 12px sans-serif';
        ctx.fillText(label, x + 8, y - 8);
    }

    // 5. Eksekusi Check-In Otomatis
    function triggerAutoCheckIn(nik, name) {
        isCheckingIn = true;
        lastCheckinNik = nik;
        lastCheckinTimestamp = Date.now();
        consecutiveMatchCount = 0;

        playSuccessSound();

        var attType = document.querySelector('input[name="att_type"]:checked').value || 'in';
        var typeLabel = (attType === 'in') ? 'Masuk' : 'Pulang';

        var banner = document.getElementById('ai_recognition_banner');
        var bannerText = document.getElementById('ai_recognition_text');
        bannerText.innerHTML = '✓ ' + name + ' Teridentifikasi! Memproses Presensi ' + typeLabel + '...';
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
        .then(function(res) { return res.json(); })
        .then(function(data) {
            isCheckingIn = false;

            if (data.success) {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Presensi Otomatis Berhasil!',
                        html: '<b>' + name + '</b> berhasil melakukan <b>Presensi ' + typeLabel + '</b> pada pukul ' + data.data.time,
                        timer: 3500,
                        showConfirmButton: false,
                        backdrop: false,
                        position: 'top-end',
                        toast: true
                    });
                }

                updateTodayTable(data.data, attType);
                setTimeout(function() { banner.classList.add('d-none'); }, 3000);
            } else {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'info',
                        title: 'Pemberitahuan',
                        text: data.message,
                        timer: 4000,
                        showConfirmButton: false,
                        backdrop: false,
                        position: 'top-end',
                        toast: true
                    });
                }
                setTimeout(function() { banner.classList.add('d-none'); }, 2000);
            }
        })
        .catch(function() {
            isCheckingIn = false;
            banner.classList.add('d-none');
        });
    }

    // Capture Frame to Base64
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
            '<td><span class="badge badge-light-success text-success font-weight-bold" style="font-size: 10px;"><i class="ri-scan-line mr-1"></i>AI Vision</span></td>' +
            '<td><span class="badge badge-success">' + (type === 'in' ? data.time : '-') + '</span></td>' +
            '<td><span class="badge badge-warning text-white">' + (type === 'out' ? data.time : '-') + '</span></td>';

        list.insertBefore(newRow, list.firstChild);
    }

    // 6. Daftarkan Wajah Karyawan (Face Enrollment)
    var enrollCanvas = document.getElementById('enroll_canvas');
    var enrollInterval = null;

    $('#enrollModal').on('shown.bs.modal', function () {
        var ctx = enrollCanvas.getContext('2d');
        enrollInterval = setInterval(function() {
            if (video && !video.paused) {
                ctx.save();
                ctx.translate(enrollCanvas.width, 0);
                ctx.scale(-1, 1);
                ctx.drawImage(video, 0, 0, enrollCanvas.width, enrollCanvas.height);
                ctx.restore();
            }
        }, 100);
    });

    $('#enrollModal').on('hidden.bs.modal', function () {
        if (enrollInterval) clearInterval(enrollInterval);
    });

    async function saveEnrolledFace() {
        var nik = $('#enroll_employee_select').val();
        if (!nik) {
            Swal.fire('Perhatian', 'Silakan pilih karyawan terlebih dahulu.', 'warning');
            return;
        }

        var btn = document.getElementById('btn_save_face');
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm mr-1"></span> Menganalisis Biometrik...';

        try {
            var options = new faceapi.TinyFaceDetectorOptions({ inputSize: 320, scoreThreshold: 0.5 });
            var detection = await faceapi.detectSingleFace(video, options)
                .withFaceLandmarks()
                .withFaceDescriptor();

            if (!detection) {
                btn.disabled = false;
                btn.innerHTML = '<i class="ri-check-line mr-1"></i> Simpan Biometrik Wajah';
                Swal.fire({
                    icon: 'error',
                    title: 'Wajah Tidak Terdeteksi',
                    text: 'Pastikan wajah Anda menghadap lurus ke kamera dan berada di tempat terang.'
                });
                return;
            }

            var descriptorArray = Array.from(detection.descriptor);
            var snapshot = captureSnapshot();

            var response = await fetch('{{ route("absence.enrollFace") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    nik: nik,
                    descriptor: descriptorArray,
                    image: snapshot
                })
            });

            var result = await response.json();
            btn.disabled = false;
            btn.innerHTML = '<i class="ri-check-line mr-1"></i> Simpan Biometrik Wajah';

            if (result.success) {
                // Update active memory registered employees
                var empName = $('#enroll_employee_select option:selected').data('name') || result.data.name;
                var found = registeredEmployeesData.find(e => e.nik === nik);
                if (found) {
                    found.face_descriptor = descriptorArray;
                } else {
                    registeredEmployeesData.push({
                        nik: nik,
                        name: empName,
                        face_descriptor: descriptorArray
                    });
                }

                buildFaceMatcher();
                $('#enrollModal').modal('hide');

                Swal.fire({
                    icon: 'success',
                    title: 'Pendaftaran Berhasil!',
                    html: 'Wajah <b>' + empName + '</b> telah tersimpan di AI biometrik.<br>Silakan hadapkan wajah Anda ke kamera untuk uji coba absensi otomatis!',
                    confirmButtonText: 'Keren, Coba Sekarang!'
                });
            } else {
                Swal.fire('Gagal', result.message, 'error');
            }
        } catch(err) {
            btn.disabled = false;
            btn.innerHTML = '<i class="ri-check-line mr-1"></i> Simpan Biometrik Wajah';
            Swal.fire('Error', 'Terjadi kesalahan sistem saat memproses wajah: ' + err.message, 'error');
        }
    }

    function toggleManualMode() {
        var panel = document.getElementById('manual_control_panel');
        var toggleText = document.getElementById('manual_toggle_text');
        if (panel.classList.contains('d-none')) {
            panel.classList.remove('d-none');
            toggleText.innerText = 'Sembunyikan Mode Manual';
        } else {
            panel.classList.add('d-none');
            toggleText.innerText = 'Gunakan Mode Manual';
        }
    }

    function submitAttendance(type, isManual) {
        var nik = $('#employee_select').val();
        if (!nik) {
            Swal.fire('Pilih Karyawan', 'Silakan pilih karyawan terlebih dahulu di dropdown.', 'warning');
            return;
        }

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
            if (data.success) {
                Swal.fire('Berhasil', data.message, 'success');
                updateTodayTable(data.data, type);
                $('#employee_select').val('').trigger('change');
            } else {
                Swal.fire('Gagal', data.message, 'error');
            }
        })
        .catch(() => {
            Swal.fire('Error', 'Gagal memproses presensi manual.', 'error');
        });
    }

    // Inisialisasi saat Halaman Dimuat
    document.addEventListener("DOMContentLoaded", function() {
        startCamera();
    });
</script>
@endsection
