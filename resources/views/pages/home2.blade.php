@extends('layouts.app')
@section('home')
<div class="py-4">
    <div class="row g-3">
        @foreach($ReceivedBook as $receivedbook)
        <div class="col-md-3">
            <a href="{{ route('viewFile', $receivedbook->id) }}" class="text-decoration-none">
                <div class="card shadow h-100 border-0 hover-card">
                    <div class="card-body lh-sm">
                        <div class="card-title text-center fw-bold text-primary fs-3 mb-0">
                            <i class="fas fa-file-alt me-2"></i>
                            เลขที่รับ: {{ convertToThaiNumber($receivedbook->number_receive) }}
                        </div>
                        <div class="card-text text-start text-muted">
                            <i class="fas fa-calendar-day me-2"></i>
                            วันที่: 
                            @if (\Carbon\Carbon::parse($receivedbook->received_date)->isYesterday())
                                <span class="text-danger">เมื่อวาน</span>
                            @else
                                {{ convertToThaiDate($receivedbook->received_date) }}
                            @endif
                        </div>
                        <div class="card-text">
                            <i class="fas fa-bookmark me-2"></i>
                            <strong>เรื่อง:</strong> {{ $receivedbook->subject }}
                        </div>
                        <div class="card-text">
                            <i class="fas fa-user me-2"></i>
                            <strong>จาก:</strong> {{ $receivedbook->from_person }}
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>

<!-- Custom CSS -->
<style>
    .hover-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease, background-color 0.3s ease;
        border-radius: 15px; /* เพิ่มขอบมน */
        overflow: hidden; /* ซ่อนส่วนเกิน */
        background-color: #ffffff; /* สีพื้นหลังการ์ด */
    }
    .hover-card:hover {
        transform: translateY(-10px); /* ยกการ์ดขึ้นเมื่อ hover */
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2); /* เงาเพิ่มเมื่อ hover */
        background-color: #f8f9fa; /* เปลี่ยนสีพื้นหลังเมื่อ hover */
    }
    .hover-card .card-body {
        padding: 1.5rem; /* เพิ่ม padding */
    }
    .hover-card .card-title {
        color: #0d6efd; /* สีหัวข้อ */
        transition: color 0.3s ease; /* เพิ่มเอฟเฟกต์เปลี่ยนสี */
    }
    .hover-card:hover .card-title {
        color: #0b5ed7; /* เปลี่ยนสีหัวข้อเมื่อ hover */
    }
    .hover-card .card-text {
        color: #6c757d; /* สีข้อความ */
        transition: color 0.3s ease; /* เพิ่มเอฟเฟกต์เปลี่ยนสี */
    }
    .hover-card:hover .card-text {
        color: #495057; /* เปลี่ยนสีข้อความเมื่อ hover */
    }
    .hover-card i {
        color: #0d6efd; /* สีไอคอน */
        transition: color 0.3s ease; /* เพิ่มเอฟเฟกต์เปลี่ยนสี */
    }
    .hover-card:hover i {
        color: #0b5ed7; /* เปลี่ยนสีไอคอนเมื่อ hover */
    }
</style>

@endsection

<!-- Custom Helper Functions -->
@php
// ฟังก์ชันแปลงเลขอารบิกเป็นเลขไทย
function convertToThaiNumber($number) {
    $thaiNumbers = ['๐', '๑', '๒', '๓', '๔', '๕', '๖', '๗', '๘', '๙'];
    return str_replace(range(0, 9), $thaiNumbers, $number);
}

// ฟังก์ชันแปลงวันที่เป็นภาษาไทย พร้อมเพิ่ม "พ.ศ."
function convertToThaiDate($date) {
    $months = [
        '01' => 'มกราคม', '02' => 'กุมภาพันธ์', '03' => 'มีนาคม',
        '04' => 'เมษายน', '05' => 'พฤษภาคม', '06' => 'มิถุนายน',
        '07' => 'กรกฎาคม', '08' => 'สิงหาคม', '09' => 'กันยายน',
        '10' => 'ตุลาคม', '11' => 'พฤศจิกายน', '12' => 'ธันวาคม'
    ];
    $carbonDate = \Carbon\Carbon::parse($date);
    $day = convertToThaiNumber($carbonDate->format('d'));
    $month = $months[$carbonDate->format('m')];
    $year = convertToThaiNumber($carbonDate->year + 543); // แปลง ค.ศ. เป็น พ.ศ.
    return "{$day} {$month} พ.ศ. {$year}";
}
@endphp

