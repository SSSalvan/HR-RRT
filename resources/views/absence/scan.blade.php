@extends('layouts.app')

@section('content')
<div class="content-page">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
                    <div>
                        <h4 class="font-weight-bold text-primary mb-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-camera mr-2" viewBox="0 0 16 16">
                                <path d="M15 12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1h1.172a3 3 0 0 0 2.12-.879l.83-.828A1 1 0 0 1 7.829 3h.342a1 1 0 0 1 .707.293l.828.828A3 3 0 0 0 11.828 5H13a1 1 0 0 1 1 1v6zM2 4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1.172a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 9.172 2H6.828a2 2 0 0 0-1.414.586l-.828.828A2 2 0 0 1 3.172 4H2z"/>
                                <path d="M8 11a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5zm0 1a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7zM3 6.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0z"/>
                            </svg>
                            Presensi Kamera Cerdas (Smart Attendance)
                        </h4>
                        <p class="text-muted mb-0">Scan wajah dan presensi live langsung melalui kamera web browser atau mobile</p>
                    </div>
                    <div>
                        <a href="{{ route('absence.index') }}" class="btn btn-outline-secondary btn-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left mr-1" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                            </svg>
                            Daftar Absensi
                        </a>
                    </div>
                </div>
            </div>

            <!-- Panel Kamera & Scan -->
            <div class="col-lg-7">
                <div class="card card-block card-stretch card-height shadow-sm">
                    <div class="card-body text-center p-3">
                        <!-- Kotak Viewfinder Kamera -->
                        <div class="camera-container position-relative mx-auto rounded overflow-hidden shadow-sm" style="max-width: 500px; background-color: #000; min-height: 360px;">
                            <video id="webcam" autoplay playsinline style="width: 100%; height: 360px; object-fit: cover; transform: scaleX(-1);"></video>
                            <canvas id="snapshot_canvas" style="display: none;"></canvas>

                            <!-- Overlay Garis Pemandu Wajah -->
                            <div class="face-guide-overlay position-absolute" style="top: 15%; left: 20%; width: 60%; height: 70%; border: 2px dashed rgba(255,255,255,0.7); border-radius: 50%; pointer-events: none;"></div>
                            
                            <!-- Status Badges -->
                            <div class="position-absolute" style="top: 10px; left: 10px;">
                                <span id="camera_status_badge" class="badge badge-success px-2 py-1">
                                    <span class="spinner-grow spinner-grow-sm text-light mr-1" role="status" style="width: 8px; height: 8px;"></span> Live Camera
                                </span>
                            </div>

                            <div class="position-absolute" style="bottom: 10px; right: 10px; background: rgba(0,0,0,0.6); padding: 4px 10px; border-radius: 4px;">
                                <span id="live_clock" class="text-white font-weight-bold" style="font-family: monospace; font-size: 14px;">00:00:00 WIB</span>
                            </div>
                        </div>

                        <!-- Feedback Box -->
                        <div id="feedback_alert" class="alert mt-3 mb-2 d-none" role="alert">
                            <span id="feedback_message"></span>
                        </div>

                        <!-- Kontrol Form Absen -->
                        <div class="mt-3 text-left">
                            <div class="form-group mb-3">
                                <label for="employee_select" class="font-weight-bold text-muted text-uppercase small">Pilih Karyawan :</label>
                                <select id="employee_select" class="form-control form-control-lg select2" style="width: 100%;">
                                    <option value="">-- Cari Nama / NIK Karyawan --</option>
                                    @foreach($employments as $emp)
                                        <option value="{{ $emp->nik }}">
                                            {{ $emp->nik }} - {{ $emp->name }} ({{ $emp->employmentRole->name ?? 'Staff' }} - {{ $emp->employmentDivision->name ?? '' }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="d-flex justify-content-between gap-2">
                                <button type="button" id="btn_check_in" class="btn btn-success btn-lg flex-fill mr-2 font-weight-bold" onclick="submitAttendance('in')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-box-arrow-in-right mr-1" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14 2H6a1.5 1.5 0 0 0-1.5 1.5v2a.5.5 0 0 0 1 0v-2z"/>
                                        <path fill-rule="evenodd" d="M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
                                    </svg>
                                    Absen Masuk
                                </button>
                                <button type="button" id="btn_check_out" class="btn btn-warning btn-lg flex-fill ml-2 font-weight-bold text-white" onclick="submitAttendance('out')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-box-arrow-left mr-1" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6 1h8A1.5 1.5 0 0 1 15.5 2.5v9a1.5 1.5 0 0 1-1.5 1.5H6a1.5 1.5 0 0 1-1.5-1.5v-2a.5.5 0 0 1 1 0v2z"/>
                                        <path fill-rule="evenodd" d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3z"/>
                                    </svg>
                                    Absen Pulang
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Panel Riwayat Presensi Hari Ini -->
            <div class="col-lg-5">
                <div class="card card-block card-stretch card-height shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center pb-0 border-0">
                        <h5 class="font-weight-bold">Presensi Hari Ini (Live)</h5>
                        <span class="badge badge-primary px-2 py-1">{{ date('d M Y') }}</span>
                    </div>
                    <div class="card-body p-3">
                        <div class="table-responsive" style="max-height: 480px; overflow-y: auto;">
                            <table class="table table-hover mb-0" id="today_table">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Foto</th>
                                        <th>Nama / NIK</th>
                                        <th>Masuk</th>
                                        <th>Pulang</th>
                                    </tr>
                                </thead>
                                <tbody id="today_attendance_list">
                                    @forelse($todayAbsences as $today)
                                        <tr>
                                            <td>
                                                @if($today->image_path)
                                                    <img src="{{ asset('images/absence/' . $today->image_path) }}" alt="Snapshot" class="rounded-circle shadow-sm" width="36" height="36" style="object-fit: cover;">
                                                @else
                                                    <div class="rounded-circle bg-secondary text-white text-center" style="width: 36px; height: 36px; line-height: 36px; font-size: 12px;">N/A</div>
                                                @endif
                                            </td>
                                            <td>
                                                <strong class="d-block text-dark">{{ $today->employment->name ?? '-' }}</strong>
                                                <small class="text-muted">{{ $today->employment->nik ?? '-' }}</small>
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
                                            <td colspan="4" class="text-center text-muted py-4">
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

<script>
    var video = document.getElementById('webcam');
    var canvas = document.getElementById('snapshot_canvas');
    var clockElement = document.getElementById('live_clock');

    // Update Live Clock
    setInterval(function() {
        var now = new Date();
        var hours = String(now.getHours()).padStart(2, '0');
        var minutes = String(now.getMinutes()).padStart(2, '0');
        var seconds = String(now.getSeconds()).padStart(2, '0');
        if (clockElement) {
            clockElement.innerText = hours + ':' + minutes + ':' + seconds + ' WIB';
        }
    }, 1000);

    // Start Webcam
    function startCamera() {
        if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
            navigator.mediaDevices.getUserMedia({ video: { width: 640, height: 480, facingMode: "user" } })
                .then(function(stream) {
                    video.srcObject = stream;
                    video.play();
                })
                .catch(function(err) {
                    console.warn("Camera access warning:", err);
                    var statusBadge = document.getElementById('camera_status_badge');
                    if (statusBadge) {
                        statusBadge.className = 'badge badge-warning px-2 py-1';
                        statusBadge.innerText = 'Kamera Standby (Izin Dibutuhkan)';
                    }
                });
        }
    }

    document.addEventListener("DOMContentLoaded", function() {
        startCamera();
    });

    // Capture Frame to Base64
    function captureSnapshot() {
        try {
            canvas.width = video.videoWidth || 640;
            canvas.height = video.videoHeight || 480;
            var ctx = canvas.getContext('2d');
            // Mirror back to normal
            ctx.translate(canvas.width, 0);
            ctx.scale(-1, 1);
            ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
            return canvas.toDataURL('image/jpeg', 0.85);
        } catch(e) {
            return null;
        }
    }

    // Submit Attendance via AJAX
    function submitAttendance(type) {
        var employeeSelect = document.getElementById('employee_select');
        var nik = employeeSelect.value;

        if (!nik) {
            showFeedback('warning', 'Silakan pilih karyawan terlebih dahulu sebelum melakukan presensi.');
            return;
        }

        var snapshot = captureSnapshot();
        var btnIn = document.getElementById('btn_check_in');
        var btnOut = document.getElementById('btn_check_out');

        btnIn.disabled = true;
        btnOut.disabled = true;

        showFeedback('info', 'Sedang memproses presensi...');

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
        .then(function(res) { return res.json(); })
        .then(function(data) {
            btnIn.disabled = false;
            btnOut.disabled = false;

            if (data.success) {
                showFeedback('success', data.message);

                // Prepend to Today's Table
                var list = document.getElementById('today_attendance_list');
                var noDataRow = document.getElementById('no_data_row');
                if (noDataRow) noDataRow.remove();

                var newRow = document.createElement('tr');
                var imgHtml = data.data.image 
                    ? '<img src="' + data.data.image + '" class="rounded-circle shadow-sm" width="36" height="36" style="object-fit: cover;">'
                    : '<div class="rounded-circle bg-success text-white text-center" style="width: 36px; height: 36px; line-height: 36px; font-size: 12px;">OK</div>';

                newRow.innerHTML = 
                    '<td>' + imgHtml + '</td>' +
                    '<td><strong class="d-block text-dark">' + data.data.name + '</strong><small class="text-muted">' + data.data.nik + '</small></td>' +
                    '<td><span class="badge badge-success">' + (type === 'in' ? data.data.time : '-') + '</span></td>' +
                    '<td><span class="badge badge-warning text-white">' + (type === 'out' ? data.data.time : '-') + '</span></td>';

                list.insertBefore(newRow, list.firstChild);

                // Reset selection
                employeeSelect.value = '';
            } else {
                showFeedback('danger', data.message);
            }
        })
        .catch(function(err) {
            btnIn.disabled = false;
            btnOut.disabled = false;
            showFeedback('danger', 'Gagal memproses presensi. Silakan coba lagi.');
        });
    }

    function showFeedback(type, message) {
        var alertBox = document.getElementById('feedback_alert');
        var messageSpan = document.getElementById('feedback_message');

        alertBox.className = 'alert alert-' + type + ' mt-3 mb-2';
        messageSpan.innerText = message;
        alertBox.classList.remove('d-none');
    }
</script>
@endsection
