@extends('layouts.app')
@section('home')
    <div class="container-fluid">
        <div class="row">
            <!-- ซ้าย: รายการข้อมูล -->
            <div class="col-md-3">
                <div class="list-group" id="book-list">
                    @foreach ($ReceivedBook as $book)
                        <a href="#" class="list-group-item list-group-item-action book-item"
                            data-pdf="{{ $book->documentPdf ? asset('storage/' . $book->documentPdf->pdf_files) : '' }}"
                            data-number-receive="{{ $book->number_receive }}">
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

            <!-- กลาง: PDF Viewer -->
            <div class="col-md-6" style="position: relative;">
                <canvas id="pdf-canvas" style="border: 1px solid #ccc; width: 100%;"></canvas>
            </div>

            <!-- ขวา: ปุ่มเพิ่ม Stamp / ลบ Stamp -->
            <div class="col-md-3">
                <div class="d-flex flex-column align-items-center">
                    <button id="add-stamp-btn" class="btn btn-primary mb-2">
                        <i class="fa fa-stamp"></i> เพิ่ม Stamp
                    </button>

                    <button id="remove-stamp-btn" class="btn btn-danger mb-2" style="display: none;">
                        <i class="fa fa-trash"></i> ลบ Stamp
                    </button>
                    <button id="download-btn" class="btn btn-success" style="display: none;">
                        <i class="fa fa-download"></i> บันทึก PDF
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf-lib/1.17.1/pdf-lib.min.js"></script>
    <script>
        const pdfCanvas = document.getElementById('pdf-canvas');
        const addStampBtn = document.getElementById('add-stamp-btn');
        const removeStampBtn = document.getElementById('remove-stamp-btn');
        const downloadBtn = document.getElementById('download-btn');
        const canvasContext = pdfCanvas.getContext('2d');

        let pdfDoc = null;
        let currentPage = 1;
        let isStampMode = false;
        let stampImage = null;
        let stampPosition = null; // ใช้เก็บตำแหน่งแสตมป์ใน PDF
        let stampWidth = 0;
        let stampHeight = 0;
        let stampText = '';
        let pdfUrl = '';
        // ฟังก์ชันแปลงตัวเลขเป็นเลขไทย
        function toThaiNumber(num) {
            const thaiNumbers = ['๐', '๑', '๒', '๓', '๔', '๕', '๖', '๗', '๘', '๙'];
            return num.toString().split('').map(digit => thaiNumbers[parseInt(digit)]).join('');
        }

        // ฟังก์ชันแปลงวันที่เป็นภาษาไทย
        function getCurrentDateThai() {
            const today = new Date();
            const thaiMonth = ["มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน",
                "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"
            ];
            const day = today.getDate();
            const month = thaiMonth[today.getMonth()];
            const year = today.getFullYear() + 543; // ปรับปีให้เป็นปีไทย
            return `${toThaiNumber(day)} ${month} ${toThaiNumber(year)}`;
        }

        // ฟังก์ชันแปลงเวลาเป็นภาษาไทย
        function getCurrentTimeThai() {
            const today = new Date();
            const hours = today.getHours();
            const minutes = today.getMinutes().toString().padStart(2, '0');
            return `${toThaiNumber(hours)}:${toThaiNumber(minutes)} น.`;
        }

        // Load PDF.js Worker
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.worker.min.js';

        // Load PDF
        async function loadPDF(url) {
            try {
                // รีเซ็ตแสตมป์ก่อนโหลด PDF ใหม่
                stampPosition = null; // รีเซ็ตแสตมป์
                removeStampBtn.style.display = 'none'; // ซ่อนปุ่มลบ

                const loadingTask = pdfjsLib.getDocument(url);
                pdfDoc = await loadingTask.promise;
                renderPage(currentPage);
            } catch (error) {
                console.error('Error loading PDF:', error);
                alert('ไม่สามารถโหลดไฟล์ PDF ได้');
            }
        }

        // Render PDF Page (เพิ่มการแสดงผลของข้อความแสตมป์)
        async function renderPage(pageNum) {
            const page = await pdfDoc.getPage(pageNum);
            const viewport = page.getViewport({
                scale: 2
            });

            pdfCanvas.width = viewport.width;
            pdfCanvas.height = viewport.height;

            const renderContext = {
                canvasContext: canvasContext,
                viewport: viewport,
            };

            await page.render(renderContext).promise;

            // วาดแสตมป์ถ้ามี
            if (stampPosition && stampImage) {
                // วาดแสตมป์ด้วยขนาดจริง
                canvasContext.drawImage(stampImage, stampPosition.x, stampPosition.y);

                // วาดข้อความบนแสตมป์
                canvasContext.font = '25px Arial'; // กำหนดฟอนต์และขนาด
                canvasContext.fillStyle = 'blue'; // สีของข้อความ
                canvasContext.textAlign = 'center';

                // วาดข้อความ
                const lines = stampText.split('\n'); // แยกข้อความเป็นบรรทัด
                lines.forEach((line, index) => {
                    canvasContext.fillText(line, stampPosition.x + 180, stampPosition.y + (index * 35) +
                        73); // วาดข้อความในแต่ละบรรทัด
                });

                removeStampBtn.style.display = 'block'; // แสดงปุ่มลบ
                downloadBtn.style.display = 'inline-block'; // แสดงปุ่มบันทึก
            } else {
                addStampBtn.style.display = 'block'; // แสดงปุ่มเพิ่ม
                downloadBtn.style.display = 'none'; // ซ่อนปุ่มบันทึก
            }
        }

        // Load Stamp Image
        async function loadStampImage() {
            try {
                const response = await fetch('/stamp/stamp.png');
                if (!response.ok) throw new Error('Failed to load image');
                const blob = await response.blob();

                const img = new Image();
                img.src = URL.createObjectURL(blob);
                await img.decode(); // ทำให้แน่ใจว่าโหลดภาพเสร็จสมบูรณ์
                return img;
            } catch (error) {
                console.error('Error loading stamp image:', error);
                return null; // คืนค่า null ถ้าโหลดไม่สำเร็จ
            }
        }

        // เพิ่มแสตมป์
        addStampBtn.addEventListener('click', async () => {
            if (stampPosition) {
                alert("แสตมป์มีแล้วใน PDF นี้");
                return; // ถ้ามีแสตมป์แล้ว จะไม่ให้เพิ่มแสตมป์ใหม่
            }

            stampImage = await loadStampImage();
            if (!stampImage) return;

            // เปลี่ยนสถานะเป็นการเพิ่มแสตมป์
            isStampMode = true;
            addStampBtn.style.display = 'none'; // ซ่อนปุ่มเพิ่ม
            pdfCanvas.style.cursor = 'crosshair';
        });

        // ลบแสตมป์
        removeStampBtn.addEventListener('click', () => {
            // ลบแสตมป์ทั้งหมด
            stampPosition = null;
            addStampBtn.style.display = 'block'; // แสดงปุ่มเพิ่ม
            removeStampBtn.style.display = 'none'; // ซ่อนปุ่มลบ
            downloadBtn.style.display = 'none'; // ซ่อนปุ่มบันทึก

            renderPage(currentPage); // รีเฟรชหน้า PDF
            pdfCanvas.style.cursor = 'auto'; // รีเซ็ตเคอร์เซอร์
        });

        // Handle Canvas Click
        pdfCanvas.addEventListener('click', (event) => {
            const rect = pdfCanvas.getBoundingClientRect();
            const x = event.clientX - rect.left;
            const y = event.clientY - rect.top;

            if (isStampMode && !stampPosition) {
                // วางแสตมป์บน Canvas โดยตำแหน่งแสตมป์ใกล้เคอร์เซอร์
                stampPosition = {
                    x: x - (stampWidth / 1000), // วางแสตมป์ให้อยู่ตรงกลางเคอร์เซอร์
                    y: y - (stampHeight * 0)
                };
                renderPage(currentPage); // รีเฟรชหน้า PDF
                pdfCanvas.style.cursor = 'auto'; // รีเซ็ตเคอร์เซอร์
            }
        });

        async function createStampImage(stampImage, stampText) {

    const canvasStamp = document.createElement('canvas');
    const ctx = canvasStamp.getContext('2d');

    // กำหนดขนาดของ canvas ให้ตรงกับขนาดของรูปแสตมป์
    canvasStamp.width = stampImage.width;  // ขนาดความกว้างจากรูปแสตมป์
    canvasStamp.height = stampImage.height;  // ขนาดความสูงจากรูปแสตมป์

    // วาดรูปแสตมป์เป็นพื้นหลัง
    ctx.drawImage(stampImage, 0, 0, canvasStamp.width, canvasStamp.height);  // วาดรูปแสตมป์ตามขนาดจริง

    // วาดข้อความบนแสตมป์
    ctx.font = '25px Arial';
    ctx.fillStyle = 'blue';  // สีของข้อความ
    ctx.textAlign = 'center';
    const lines = stampText.split('\n');  // แยกข้อความเป็นบรรทัด
    lines.forEach((line, index) => {
        ctx.fillText(line, canvasStamp.width / 2, 120 + (index * 30));  // วาดข้อความบนแสตมป์
    });

    // แปลง canvas เป็นรูปภาพ
    const stampImg = await canvasToImage(canvasStamp);
    return stampImg;
}

// ฟังก์ชันแปลง canvas เป็นรูปภาพ
function canvasToImage(canvas) {
    return new Promise((resolve) => {
        const image = new Image();
        image.onload = () => resolve(image);
        image.src = canvas.toDataURL('image/png');
    });
}



        function canvasToImage(canvas) {
            return new Promise((resolve) => {
                const image = new Image();
                image.onload = () => resolve(image);
                image.src = canvas.toDataURL('image/png');
            });
        }


        // ดาวน์โหลด PDF จาก pdf-lib หลังจากเพิ่มแสตมป์
        downloadBtn.addEventListener('click', async () => {
            const existingPdfBytes = await fetch(pdfUrl).then(res => res
        .arrayBuffer()); // โหลด PDF ที่เลือกจาก backend
            const pdfDocLib = await PDFLib.PDFDocument.load(existingPdfBytes);

            // โหลดรูปแสตมป์และข้อความที่ถูกแปลงเป็นรูปภาพ
            const stampImageLib = await createStampImage();

            const imageBytes = await fetch(stampImageLib.src).then(res => res.arrayBuffer());
            const embeddedStampImage = await pdfDocLib.embedPng(imageBytes);

            const page = pdfDocLib.getPage(0); // เลือกหน้าแรก
            page.drawImage(embeddedStampImage, {
                x: stampPosition.x,
                y: stampPosition.y,
                width: embeddedStampImage.width / 2,
                height: embeddedStampImage.height / 2,
            });

            // บันทึกไฟล์ PDF ใหม่
            const newPdfBytes = await pdfDocLib.save();
            const blob = new Blob([newPdfBytes], {
                type: 'application/pdf'
            });
            const url = URL.createObjectURL(blob);

            const link = document.createElement('a');
            link.href = url;
            link.download = 'stamped.pdf';
            link.click();
        });



        // ส่งข้อมูล PDF ไปยัง backend
        async function sendPDFToBackend(pdfBytes) {
            const formData = new FormData();
            formData.append('pdf', new Blob([pdfBytes], {
                type: 'application/pdf'
            }));

            try {
                const response = await fetch('/save-pdf', {
                    method: 'POST',
                    body: formData
                });

                const result = await response.json();
                if (result.success) {
                    alert('PDF ถูกบันทึกเรียบร้อย');
                } else {
                    alert('เกิดข้อผิดพลาดในการบันทึก PDF');
                }
            } catch (error) {
                console.error('Error sending PDF to backend:', error);
                alert('ไม่สามารถส่ง PDF ไปยัง server');
            }
        }


        // กำหนดข้อความแสตมป์ใน `book-item` ที่ถูกเลือก
        document.querySelectorAll('.book-item').forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                pdfUrl = this.getAttribute('data-pdf'); // ดึงค่า pdfUrl จาก attribute ของ <a> ที่ถูกคลิก
                const numberReceive = this.getAttribute('data-number-receive'); // ดึงค่า number_receive

                if (pdfUrl) {
                    isStampMode = false; // รีเซ็ตโหมดแสตมป์
                    loadPDF(pdfUrl); // โหลด PDF จาก pdfUrl ที่ได้รับ

                    // กำหนดข้อความแสตมป์ตามเลขที่รับที่เลือก
                    stampText =
                        `${toThaiNumber(numberReceive)}\n${getCurrentDateThai()}\n${getCurrentTimeThai()}`;
                    // รีเซ็ตค่าที่แสดงแสตมป์
                    stampPosition = null;
                    removeStampBtn.style.display = 'none'; // ซ่อนปุ่มลบ
                } else {
                    alert('ไม่มีไฟล์ PDF');
                }
            });
        });


        // ส่งข้อมูล PDF ไปยัง backend
        async function sendPDFToBackend(pdfBytes) {
            const formData = new FormData();
            formData.append('pdf', new Blob([pdfBytes], {
                type: 'application/pdf'
            }));

            try {
                const response = await fetch('/save-pdf', {
                    method: 'POST',
                    body: formData
                });

                const result = await response.json();
                if (result.success) {
                    alert('PDF ถูกบันทึกเรียบร้อย');
                } else {
                    alert('เกิดข้อผิดพลาดในการบันทึก PDF');
                }
            } catch (error) {
                console.error('Error sending PDF to backend:', error);
                alert('ไม่สามารถส่ง PDF ไปยัง server');
            }
        }
    </script>
@endsection
