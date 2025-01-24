@extends('layouts.app')
@section('home')

<div class="container">
    <br>
    <table class="table table-bordered table-striped" id="data_table">
        <thead>
            <tr>
                <th class="text-center">เลขที่รับ</th>
                <th class="text-center">วันที่</th>
                <th class="text-center">เรื่อง</th>
                <th>จาก</th>
                <th>pdf</th>
                <th class="text-center">action</th>
            </tr>
        </thead>
        <tbody class="text-center">
            @foreach($ReceivedBook as $receivedbook)
            <tr>
                <td>{{ $receivedbook->number_receive}}</td>
                <td>
                    <p>
                        @if (\Carbon\Carbon::parse($receivedbook->received_date)->isYesterday())
                        เมื่อวาน
                        @else
                        {{ \Carbon\Carbon::parse($receivedbook->received_date)->format('d-m-Y') }}
                        @endif
                    </p>
                </td>
                <td>{{ $receivedbook->subject}}</td>
                <td>{{ $receivedbook->from_person}}</td>
                <td> @if ($receivedbook->documentPdf)
                    <a href="{{ asset('storage/' . $receivedbook->documentPdf->pdf_files) }}" target="_blank">ดูไฟล์ PDF</a>
                    @else
                    <p>ไม่มีไฟล์ PDF</p>
                    @endif</td>
                <td>
                    <a href="{{ route('viewFile', $receivedbook->id) }}" class="btn btn-info"><i class="bi bi-eye"></i></a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
