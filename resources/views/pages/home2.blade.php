@extends('layouts.app')
@section('home')

<h1>Hello</h1><br>

@foreach ($ReceivedBook as $book)
    <div>
        <p>เลขที่รับ: {{ $book->number_receive }}</p>
        <p>หัวข้อ: {{ $book->subject }}</p>
        <p>วันที่รับ:
            @if (\Carbon\Carbon::parse($book->received_date)->isYesterday())
                เมื่อวาน
            @else
                {{ \Carbon\Carbon::parse($book->received_date)->format('d-m-Y') }}
            @endif
        </p>

        <!-- แสดงไฟล์ PDF -->
        @if ($book->documentPdf)
            <a href="{{ asset('storage/' . $book->documentPdf->pdf_files) }}" target="_blank">ดูไฟล์ PDF</a>
        @else
            <p>ไม่มีไฟล์ PDF</p>
        @endif

    </div>
@endforeach


@endsection
