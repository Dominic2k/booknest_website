<?php
// Start session nếu chưa bắt đầu
session_start();

// Kiểm tra xem người dùng đã đăng nhập chưa
$is_logged_in = isset($_SESSION['current']) && !empty($_SESSION['current']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookNest Header</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <!-- link font chữ -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Tinos:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Barlow:ital,wght@0,100;0,200&family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        /* Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Header Styling */
        .header {
            display: flex;
            align-items: center;
            padding: 10px 20px;
            background-color:#DEE3E5;
            font-family: "Inter", sans-serif;
        }

        /*logo brand*/
        .logo-brand {
            display: flex;
            align-items: center;
            margin-left: 40px;
        }

        .logo {
            width: 75px;
            height: 60px;
            margin-right: 10px;
        }

        .brand-name {
            font-size: 40px;
            color: #815C5C;
            font-weight: normal;
        }

        /* Navigation Links */
        .nav {
            display: flex;
            align-items: center;
            cursor: pointer;
            list-style: none;
            margin-left: 600px;
        }
        .nav-link {
            margin: 0 28px;
            align-items: center;
            position: relative;
        }
        .nav-link a{
            text-decoration: none;
            color: #815C5C;
            font-size: 22px;
            font-weight: bold;
        }

        .nav-link:hover{
            color: #815C5C;
        }
        .nav-link.active{
            color:#815C5C;
        }
        .nav-link.active::after{
            content: "";
            position: absolute;
            bottom: -11.5px;
            left: 0;
            right: 0;
            height: 3.5px;
            background-color:#815C5C; 
            border-radius: 8px;
        }
        /* style of right header */
        .right-header{
            display: flex;
            gap: 40px;
            color: #815C5C;
            margin-left: 90px;
        }
        .icon-cart, .icon-user{
            font-size: 26px;
        }
        .log-out{
            font-size: 22px;
        }

        /* Màu nền của footer */
        .footer {
            background-color: #DEE3E5; /* Màu xám nhạt */
            font-family: "Inter", sans-serif; /* Áp dụng font Inter cho footer */
        }

        /* Tiêu đề trong footer */
        .footer h6 {
            color: #815C5C; /* Màu chữ */
            font-weight: bold;
            padding-top: 30px; /* Thêm khoảng cách trên */
        }

        /* Liên kết trong footer */
        .footer a {
            color: #815C5C; /* Màu chữ */
            text-decoration: none;
        }

        .footer a:hover {
            color: #815C5C; /* Không thay đổi màu chữ khi hover */
            text-decoration: underline;
        }

        /* Icon trong footer */
        .footer i {
            font-size: 1.5rem; /* Tăng kích thước icon */
            color: gray; /* Màu chữ */
            transition: color 0.3s ease;
        }

        .footer i:hover {
            color: #815C5C; /* Màu chữ khi hover */
        }

        /* Dòng phân cách */
        #footer-hr {
            border-color: #815C5C; /* Màu xám nhạt cho đường kẻ */
        }

        /* Văn bản bản quyền */
        .footer p {
            color: #815C5C; /* Màu chữ */
            font-size: 0.9rem;
        }

        /* Cập nhật các ID cho các thẻ p */
        #address-1, #address-2, #address-3 {
            margin-bottom: 0.5rem; /* Giảm khoảng cách giữa các đoạn văn */
        }
    </style>
</head>
<body>
    <!-- Header -->
<?php
    require_once './app/views/header.php';
?>
<h1>Xin chào tất cả các bạn</h1>

    <!-- Footer -->
<?php
    require_once './app/views/footer.php';
?>
</body>
</html>