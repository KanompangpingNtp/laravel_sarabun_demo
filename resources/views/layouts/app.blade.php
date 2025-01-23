<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="คำอธิบายเว็บไซต์">
    <title>@yield('title', 'Default Title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        @font-face {
            font-family: 'th-krub';
            src: url('/fonts/TH-Krub.ttf') format('woff2');
            font-weight: normal;
        }

        @font-face {
            font-family: 'th-krub';
            src: url('/fonts/TH-Krub-Bold.ttf') format('woff2');
            font-weight: bold;
        }

        body {
            font-family: 'th-krub', sans-serif;
            font-size: 20px;
        }

        /* เปลี่ยนสีของแท็บที่ active */
        .nav-link.active {
            color: white;
            border-radius: 0px;
            font-weight: bold;
        }

        /* เปลี่ยนสีของแท็บเมื่อ hover */
        .nav-link:hover {
            background-color: #f1f1f1;
            /* สีพื้นหลังเมื่อ hover */
            color: #5a9bd5;
            /* สีข้อความเมื่อ hover */
            border-radius: 0px;
            border: 0px solid #000;
        }

        .nav-link {
            color: #808080;
            /* สีข้อความเมื่อแท็บไม่ active */

            border: 0px solid #000;
        }

        /* เมื่อ hover บนรายการใน dropdown */
        .dropdown-item:hover {
            background-color: #f1f1f1;
            /* เปลี่ยนพื้นหลังเมื่อ hover */
            color: #5a9bd5;
            /* เปลี่ยนสีข้อความเมื่อ hover */
        }

        /* หากต้องการให้เมนู logout เปลี่ยนสีเมื่อ hover */
        .dropdown-item.text-danger:hover {
            background-color: #ffebeb;
            /* สีพื้นหลังเมื่อ hover */
            color: #dc3545;
            /* เปลี่ยนสีข้อความให้เข้มขึ้น */
        }

        /* ปรับขนาด scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            /* ความกว้างของ scrollbar */
            height: 8px;
            /* ความสูงของ scrollbar ในกรณีที่เลื่อนแนวนอน */
        }

        /* รูปลักษณ์ของ scrollbar thumb (ส่วนที่เลื่อน) */
        ::-webkit-scrollbar-thumb {
            background-color: #5a9bd5;
            /* สีของ thumb */
            border-radius: 10px;
            /* ขอบโค้งมน */
        }

        /* เมื่อ hover บน scrollbar thumb */
        ::-webkit-scrollbar-thumb:hover {
            background-color: #398cd4;
            /* สีที่เปลี่ยนเมื่อ hover */
        }

        /* รูปลักษณ์ของ track (พื้นหลังของ scrollbar) */
        ::-webkit-scrollbar-track {
            background-color: #f1f1f1;
            /* สีพื้นหลังของ track */
            border-radius: 10px;
            /* ขอบโค้งมน */
        }

        /* ปรับขนาด scrollbar สำหรับกรณีเลื่อนแนวนอน */
        ::-webkit-scrollbar-horizontal {
            height: 6px;
        }

        /* ปรับ scrollbar สำหรับกรณีเลื่อนแนวตั้ง */
        ::-webkit-scrollbar-vertical {
            width: 6px;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white px-4 border-bottom">
        <!-- Logo -->
        <a class="navbar-brand text-uppercase fs-1" href="#"><span style="color: #5a9bd5">Sarabun</span> Demo</a>

        <!-- Spacer -->
        <div class="flex-grow-1"></div>

        <!-- User Account Dropdown -->
        <div class="dropdown">
            <button class="btn btn-light dropdown-toggle d-flex align-items-center" id="dropdownMenuButton"
                data-bs-toggle="dropdown" aria-expanded="false">
                <!-- ชื่อและตำแหน่งงาน -->
                <div class="text-end lh-1">
                    <span class="d-block fs-4 fw-bold" style="color: #5a9bd5;">กระเพรา</span>
                    <small class="fs-5" style="color: #808080;">นักพัฒนาเว็บไซต์</small>
                </div>
                <!-- รูปโปรไฟล์ -->
                <img src="{{ asset('images/1006-200x200.jpg') }}" alt="User Avatar"
                    class="rounded-circle mx-2 border border-gray" style="width: 50px; height: 50px;" />
            </button>

            <!-- เมนู Dropdown -->
            <ul class="dropdown-menu dropdown-menu-end bg-light text-dark fs-5" aria-labelledby="dropdownMenuButton">
                <li><a class="dropdown-item" href="#">Profile</a></li>
                <li><a class="dropdown-item" href="#">Settings</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item text-danger" href="#">Logout</a></li>
            </ul>
        </div>

    </nav>

    <!-- Tabs -->
    <div>
        <!-- Tab Navigation -->
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="home-tab" data-bs-toggle="tab" href="#home" role="tab"
                    aria-controls="home" aria-selected="true">รับหนังสือ</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="profile-tab" data-bs-toggle="tab" href="#profile" role="tab"
                    aria-controls="profile" aria-selected="false">แฟ้มบนโต๊ะ</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="tracking-tab" data-bs-toggle="tab" href="#tracking" role="tab"
                    aria-controls="tracking" aria-selected="false">ติดตามหนังสือ</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="create-tab" data-bs-toggle="tab" href="#create" role="tab"
                    aria-controls="create" aria-selected="false">สร้างหนังสือ</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="send-tab" data-bs-toggle="tab" href="#send" role="tab"
                    aria-controls="send" aria-selected="false">ส่งหนังสือ</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="file-tab" data-bs-toggle="tab" href="#file" role="tab"
                    aria-controls="file" aria-selected="false">แฟ้มในตู้</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="result-tab" data-bs-toggle="tab" href="#result" role="tab"
                    aria-controls="result" aria-selected="false">ผลการดำเนินงาน</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="booking-tab" data-bs-toggle="tab" href="#booking" role="tab"
                    aria-controls="booking" aria-selected="false">จองเลข</a>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content px-4" id="myTabContent">
            <!-- Home Tab -->
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                @yield('home1')
            </div>

            <!-- Other Tabs -->
            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <h3>แฟ้มบนโต๊ะ</h3>
                <p>This is the content for the Profile tab.</p>
            </div>

            <div class="tab-pane fade" id="tracking" role="tabpanel" aria-labelledby="tracking-tab">
                <h3>ติดตามหนังสือ</h3>
                <p>This is the content for the Tracking tab.</p>
            </div>

            <div class="tab-pane fade" id="create" role="tabpanel" aria-labelledby="create-tab">
                <h3>สร้างหนังสือ</h3>
                <p>This is the content for the Create tab.</p>
            </div>

            <div class="tab-pane fade" id="send" role="tabpanel" aria-labelledby="send-tab">
                <h3>ส่งหนังสือ</h3>
                <p>This is the content for the Send tab.</p>
            </div>

            <div class="tab-pane fade" id="file" role="tabpanel" aria-labelledby="file-tab">
                <h3>แฟ้มในตู้</h3>
                <p>This is the content for the File tab.</p>
            </div>

            <div class="tab-pane fade" id="result" role="tabpanel" aria-labelledby="result-tab">
                <h3>ผลการดำเนินงาน</h3>
                <p>This is the content for the Result tab.</p>
            </div>

            <div class="tab-pane fade" id="booking" role="tabpanel" aria-labelledby="booking-tab">
                <h3>จองเลข</h3>
                <p>This is the content for the Booking tab.</p>
            </div>
        </div>
    </div>


    
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>


</html>
