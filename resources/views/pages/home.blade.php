@extends('layouts.app')
@section('title','Sarabun-Demo-GM-SKY')
@section('home1')

<div class="row">
    <div class="col-md-4 mt-4 p-3 rounded lh-1" style="background-color: #f1f1f1; overflow:auto; max-height: 83vh;">
        <div class="fs-3 fw-bold">ข้อมูลหนนังสือ</div>
        <form action="{{ route('getbookCreate') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-1 row">
                <label for="register_type" class="col-sm-2 col-form-label text-end">สมุดทะเบียน</label>
                <div class="col-sm-5 position-relative">
                    <select class="form-select" id="register_type" name="register_type" required>
                        <option value="" disabled selected hidden>เลือกสมุดทะเบียน</option>
                        <option value="option1">ทั่วไป</option>
                        <option value="option2">ทั่วไป 2568</option>
                    </select>
                    <span class="text-danger position-absolute fw-bold" style="top: 10%; right: 5px; transform: translateY(-50%);">*</span>
                </div>
                <label for="number_receive" class="col-sm-2 col-form-label text-end">เลขที่รับ</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" id="number_receive" name="number_receive" value="{{ $lastReceivedBookId }}" placeholder="เลขที่รับ" readonly>
                </div>
            </div>

            <hr>

            <div class="mb-1 row">
                <label for="book_number" class="col-sm-2 col-form-label text-end">เลขที่หนังสือ</label>
                <div class="col-sm-3 position-relative">
                    <input type="text" class="form-control" id="book_number" name="book_number" required>
                    <span class="text-danger position-absolute fw-bold" style="top: 10%; right: 5px; transform: translateY(-50%);">*</span>
                </div>
                <div class="col-sm-1  fs-1 p-0 text-center">/</div>
                <div class="col-sm-3">
                    <select class="form-select" id="book_year" name="book_year">
                        <option value="" disabled selected hidden></option>
                        <option value="option1">ว</option>
                        <option value="option2">ว 2566</option>
                        <option value="option3">2567</option>
                    </select>
                </div>
                <div class="col-sm-3 position-relative">
                    <input type="text" class="form-control" id="book_receipt_number" name="book_receipt_number" required>
                    <span class="text-danger position-absolute fw-bold" style="top: 10%; right: 5px; transform: translateY(-50%);">*</span>
                </div>
            </div>

            <div class="mb-1 row">
                <label for="urgency_level" class="col-sm-2 col-form-label text-end">ชั้นความเร็ว</label>
                <div class="col-sm-10">
                    <select class="form-select" id="urgency_level" name="urgency_level">
                        <option value="" disabled selected hidden>เลือกชั้นความเร็ว</option>
                        <option value="1">ด่วน</option>
                        <option value="2">ด่วนมาก</option>
                        <option value="3">ด่วนมากที่สุด</option>
                    </select>
                </div>
            </div>
            <div class="mb-1 row">
                <label for="received_date" class="col-sm-2 col-form-label text-end">วันที่ได้รับ</label>
                <div class="col-sm-3">
                    <input type="date" class="form-control" id="received_date" name="received_date" value="<?= date('Y-m-d'); ?>" placeholder="วันที่ได้รับ" readonly>
                </div>
                <label for="date_receipt" class="col-sm-2 col-form-label text-end">วันที่รับ</label>
                <div class="col-sm-3">
                    <input type="date" class="form-control" id="date_receipt" name="date_receipt" value="<?= date('Y-m-d'); ?>" placeholder="วันที่รับ" readonly>
                </div>
                <div class="col-sm-2">
                    <button class="btn btn-outline-dark pt-2"><i class="fa-solid fa-clock"></i></button>
                </div>
            </div>
            <div class="mb-1 row">
                <label for="registered_date" class="col-sm-2 col-form-label text-end">ลงวันที่</label>
                <div class="col-sm-5 position-relative">
                    <input type="date" class="form-control" id="registered_date" name="registered_date" value="<?= date('Y-m-d'); ?>" placeholder="ลงวันที่">
                    <span class="text-danger position-absolute fw-bold" style="top: 10%; right: 5px; transform: translateY(-50%);">*</span>
                </div>
            </div>
            <hr>
            <div class="mb-2 row">
                <label for="subject" class="col-sm-2 col-form-label text-end">เรื่อง</label>
                <div class="col-sm-10 position-relative">
                    <textarea class="form-control" id="subject" name="subject" required></textarea>
                    <span class="text-danger position-absolute fw-bold" style="top: 10%; right: 5px; transform: translateY(-50%);">*</span>
                </div>
            </div>
            <div class="mb-1 row">
                <label for="to_person" class="col-sm-2 col-form-label text-end">เรียน</label>
                <div class="col-sm-10 position-relative">
                    <input type="text" class="form-control" id="to_person" name="to_person" required>
                    <span class="text-danger position-absolute fw-bold" style="top: 10%; right: 5px; transform: translateY(-50%);">*</span>
                </div>
            </div>
            <div class="mb-1 row">
                <label for="reference" class="col-sm-2 col-form-label text-end">อ้างถึง</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="reference" name="reference">
                </div>
            </div>
            <div class="mb-2 row">
                <label for="content" class="col-sm-2 col-form-label text-end">เนื้อหา</label>
                <div class="col-sm-10 position-relative">
                    <textarea class="form-control" id="content" name="content" required></textarea>
                    <span class="text-danger position-absolute fw-bold" style="top: 10%; right: 5px; transform: translateY(-50%);">*</span>
                </div>
            </div>
            <div class="mb-2 row">
                <label for="note" class="col-sm-2 col-form-label text-end">หมายเหตุ</label>
                <div class="col-sm-10">
                    <textarea class="form-control" id="note" name="note"></textarea>
                </div>
            </div>
            <div class="mb-1 row">
                {{-- <label for="from_person" class="col-sm-2 col-form-label text-end">จาก</label>
                <div class="col-sm-8 position-relative">
                    <select class="form-control" id="from_person" name="from_person">
                        <option value="" disabled selected hidden></option>
                        <option value="option1">Option 1</option>
                        <option value="option2">Option 2</option>
                        <option value="option3">Option 3</option>
                    </select>
                    <span class="text-danger position-absolute fw-bold" style="top: 10%; right: 5px; transform: translateY(-50%);">*</span>
                </div> --}}
                <label for="from_person" class="col-sm-2 col-form-label text-end">จาก</label>
                <div class="col-sm-8 position-relative">
                    <input type="text" class="form-control" id="from_person" name="from_person">
                    <span class="text-danger position-absolute fw-bold" style="top: 10%; right: 5px; transform: translateY(-50%);">*</span>
                </div>

                <div class="col-sm-2">
                    <button type="button" class="btn btn-outline-dark pt-2" data-bs-toggle="modal" data-bs-target="#staticBackdropx">
                        <i class="fa-solid fa-address-book"></i>
                    </button>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="staticBackdropx" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                ...
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                                <button type="button" class="btn btn-primary">เลือก</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="mb-1 row">
                <label for="registrationBook" class="col-sm-2 col-form-label text-end">รายงานผล</label>
                <div class="col-sm-3">
                    <input type="checkbox" class="form-check-input fs-4" id="enableDate" onchange="toggleDateInput()">
                </div>
                <label for="registrationBook" class="col-sm-2 col-form-label text-end">วันที่</label>
                <div class="col-sm-5">
                    <input type="date" class="form-control" id="dateInput" disabled>
                </div>
            </div>

            <script>
                function toggleDateInput() {
                    const checkbox = document.getElementById("enableDate");
                    const dateInput = document.getElementById("dateInput");

                    if (checkbox.checked) {
                        dateInput.disabled = false;
                    } else {
                        dateInput.disabled = true;
                        dateInput.value = '';
                    }
                }

            </script>
            <input type="file" id="fileInput" accept="application/pdf" class="d-none" name="file_input" required>
            <hr>
            <button type="submit" class="btn btn-primary w-100 fs-5 fw-bold"><i class="fa-solid fa-file-arrow-up"></i> บันทึก</button>
        </form>

    </div>

    <!-- คอลัมน์ขวาสำหรับการแสดง Tab Menu -->
    <div class="col-md-6">
        <ul class="nav nav-tabs" id="myTab2" role="tablist" style="justify-content: flex-end;">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="home-tab2" data-bs-toggle="tab" href="#home2" role="tab" aria-controls="home2" aria-selected="true">หนังสือรับ</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="profile-tab2" data-bs-toggle="tab" href="#profile2" role="tab" aria-controls="profile2" aria-selected="false">สิ่งที่ส่งมาด้วย</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="settings-tab2" data-bs-toggle="tab" href="#settings2" role="tab" aria-controls="settings2" aria-selected="false">อ้างถึง</a>
            </li>
        </ul>

        <div class="tab-content border border-top-0" id="myTabContent2" style="overflow:auto; max-height: 80vh; height: 80vh; ">
            <div class="tab-pane fade show active" id="home2" role="tabpanel" aria-labelledby="home-tab2">
                <div id="drop-area" class="d-flex flex-column justify-content-center align-items-center mb-3 text-uppercase fw-bold lh-1" style="max-height: 78vh; height: 78vh;">
                    <p class="text-center fs-1" style="color: #5a9bd5">ลากและวางไฟล์ PDF</p>
                    <!-- ปุ่มสำหรับเลือกไฟล์ -->
                    <button id="customFileButton" class="btn btn-primary fs-4 px-5 shadow">
                        เลือกไฟล์ PDF
                    </button>

                </div>

                <!-- พื้นที่ที่จะแสดงไฟล์ PDF ทุกหน้า -->
                <div id="pdf-container" style="display: flex; flex-direction: column;"></div>

                <script></script>
            </div>


            <div class="tab-pane fade" id="profile2" role="tabpanel" aria-labelledby="profile-tab2">
                <p>This is the content for the Profile tab.</p>
            </div>
            <div class="tab-pane fade" id="settings2" role="tabpanel" aria-labelledby="settings-tab2">
                <p>This is the content for the Settings tab.</p>
            </div>
        </div>
    </div>
    <div class="col-md-2 bg-light border-start" id="sidebar">
        <div class="p-3">
            <div class="text-center fs-1" style="color: #5a9bd5"><i class="fa-solid fa-gear"></i> เครื่องมือ</div>
            <hr>
            <button id="sidebarFileButton" class="btn btn-primary w-100 mb-3 fs-5">
                <i class="fa-solid fa-circle-plus"></i> เลือกไฟล์ PDF ใหม่
            </button>
        </div>
    </div>
</div>

<script>
    // ดึงปุ่มและ input ไฟล์
    const customFileButton = document.getElementById("customFileButton");
    const fileInput = document.getElementById("fileInput");
    const sidebarFileButton = document.getElementById('sidebarFileButton')
    // เมื่อคลิกปุ่ม ให้ทำงานเหมือนคลิก input file
    customFileButton.addEventListener("click", () => {
        fileInput.click();
    });


    sidebarFileButton.addEventListener("click", () => {
        fileInput.click();
    });

    // ฟังก์ชันสำหรับแสดงทุกหน้าใน PDF
    function renderPDF(pdfFile) {
        const reader = new FileReader();

        reader.onload = function(e) {
            const loadingTask = pdfjsLib.getDocument(e.target.result);
            loadingTask.promise.then(function(pdf) {
                // เพิ่มคลาส d-none เพื่อซ่อน drop-area
                document.getElementById('drop-area').classList.add('d-none');

                // รับจำนวนหน้าทั้งหมดของ PDF
                const numPages = pdf.numPages;
                const container = document.getElementById('pdf-container');
                container.innerHTML = ''; // ลบเนื้อหาที่มีอยู่ก่อน

                // วาดทุกหน้า
                for (let pageNum = 1; pageNum <= numPages; pageNum++) {
                    pdf.getPage(pageNum).then(function(page) {
                        const canvas = document.createElement('canvas');
                        const context = canvas.getContext('2d');
                        const viewport = page.getViewport({
                            scale: 2
                        });

                        canvas.height = viewport.height;
                        canvas.width = viewport.width;

                        page.render({
                            canvasContext: context
                            , viewport: viewport
                        });

                        // เพิ่ม canvas ลงใน container
                        container.appendChild(canvas);
                    });
                }
            });
        };

        reader.readAsArrayBuffer(pdfFile);
    }

    // ฟังก์ชันเมื่อเลือกไฟล์จาก input
    document.getElementById('fileInput').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file && file.type === 'application/pdf') {
            renderPDF(file);
        } else {
            alert('โปรดเลือกไฟล์ PDF');
        }
    });

    // ฟังก์ชันสำหรับการลากและวางไฟล์
    const dropArea = document.getElementById('drop-area');
    dropArea.addEventListener('dragover', function(event) {
        event.preventDefault();
        dropArea.style.backgroundColor = '#f0f0f0';
    });

    dropArea.addEventListener('dragleave', function() {
        dropArea.style.backgroundColor = 'transparent';
    });

    dropArea.addEventListener('drop', function(event) {
        event.preventDefault();
        dropArea.style.backgroundColor = 'transparent';
        const file = event.dataTransfer.files[0];
        if (file && file.type === 'application/pdf') {
            renderPDF(file);
        } else {
            alert('โปรดลากไฟล์ PDF');
        }
    });

</script>
@endsection
