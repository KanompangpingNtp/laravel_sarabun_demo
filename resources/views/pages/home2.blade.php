@extends('layouts.app')
@section('home')

<div class="container">
    <div class="row">
        <!-- ฝั่งซ้าย: รายการข้อมูล -->
        <div class="col-md-4">
            <div class="list-group" id="book-list">
                @foreach ($ReceivedBook as $book)
                    <a href="#"
                       class="list-group-item list-group-item-action book-item"
                       data-pdf="{{ $book->documentPdf ? asset('storage/' . $book->documentPdf->pdf_files) : '' }}">
                        <h5 class="mb-1">เลขที่รับ: {{ $book->number_receive }}</h5>
                        <p class="mb-1">หัวข้อ: {{ $book->subject }}</p>
                        <small>
                            วันที่รับ:
                            @if (\Carbon\Carbon::parse($book->received_date)->isYesterday())
                                เมื่อวาน
                            @else
                                {{ \Carbon\Carbon::parse($book->received_date)->format('d-m-Y') }}
                            @endif
                        </small>
                    </a>
                @endforeach
            </div>
        </div>

        <!-- ฝั่งขวา: แสดง PDF -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-body text-center">
                    <h5 class="card-title">แสดง PDF</h5>
                    <iframe id="pdf-viewer" src="" width="100%" height="500px" style="border: none;"></iframe>
                    <p id="no-pdf-message" class="text-danger" style="display: none;">ไม่มีไฟล์ PDF</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const items = document.querySelectorAll('.book-item');
        const pdfViewer = document.getElementById('pdf-viewer');
        const noPdfMessage = document.getElementById('no-pdf-message');

        items.forEach(item => {
            item.addEventListener('click', function (e) {
                e.preventDefault();
                const pdfUrl = this.getAttribute('data-pdf');

                if (pdfUrl) {
                    pdfViewer.src = pdfUrl; // แสดง PDF
                    pdfViewer.style.display = 'block';
                    noPdfMessage.style.display = 'none';
                } else {
                    pdfViewer.src = ''; // ซ่อน PDF
                    pdfViewer.style.display = 'none';
                    noPdfMessage.style.display = 'block';
                }

                // กำหนด active ให้ item ที่ถูกคลิก
                items.forEach(i => i.classList.remove('active'));
                this.classList.add('active');
            });
        });
    });
</script>


@endsection
