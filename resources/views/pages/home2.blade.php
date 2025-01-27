@extends('layouts.app')
@section('home')
<div class="py-4">
    <div class="row g-3"> <!-- ใช้ Bootstrap grid layout -->
        @foreach($ReceivedBook as $receivedbook)
        <div class="col-md-3"> <!-- การ์ดแต่ละอันจะมีขนาด 1/4 ของแถว -->
            <a href="{{ route('viewFile', $receivedbook->id) }}" class="text-decoration-none"> <!-- กดการ์ด -->
                <div class="card shadow h-100 border-0 hover-card"> <!-- เพิ่ม hover effect -->
                    <div class="card-body lh-sm">
                        <div class="card-title text-center fw-bold text-primary fs-3 mb-0">
                            <i class="fas fa-file-alt me-2"></i> <!-- เพิ่มไอคอนเลขที่รับ -->
                            เลขที่รับ: {{ convertToThaiNumber($receivedbook->number_receive) }}
                        </div>
                        <div class="card-text text-center text-muted">
                            <i class="fas fa-calendar-day me-2"></i> <!-- เพิ่มไอคอนวันที่ -->
                            วันที่: 
                            @if (\Carbon\Carbon::parse($receivedbook->received_date)->isYesterday())
                                <span class="text-danger">เมื่อวาน</span>
                            @else
                                {{ convertToThaiDate($receivedbook->received_date) }}
                            @endif
                        </div>
                        
                        <div class="card-text">
                            <i class="fas fa-bookmark me-2"></i> <!-- เพิ่มไอคอนเรื่อง -->
                            <strong>เรื่อง:</strong> {{ $receivedbook->subject }}
                        </div>
                        <div class="card-text">
                            <i class="fas fa-user me-2"></i> <!-- เพิ่มไอคอนจาก -->
                            <strong>จาก:</strong> {{ $receivedbook->from_person }}
                        </div>
                        {{-- <div class="card-text">
                            <i class="fas fa-file-pdf me-2"></i> 
                            <strong>ไฟล์ PDF:</strong> 
                            @if ($receivedbook->documentPdf)
                                <a href="{{ asset('storage/' . $receivedbook->documentPdf->pdf_files) }}" target="_blank" class="text-decoration-underline text-primary">ดูไฟล์ PDF</a>
                            @else
                                <span class="text-muted">ไม่มีไฟล์ PDF</span>
                            @endif
                        </div> --}}
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
        transition: transform 0.3s ease, box-shadow 0.3s ease; /* เพิ่มการเปลี่ยนแปลง */
    }
    .hover-card:hover {
        transform: translateY(-10px); /* ยกการ์ดขึ้นเมื่อ hover */
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2); /* เงาเพิ่มเมื่อ hover */
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

