<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <!-- link font chữ -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow:ital,wght@0,100;0,200&family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Barlow:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Tinos:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/Payment.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .body-wrapper {
            font-family: "Inter", sans-serif;
            margin: 0;
            padding: 0;
            background-color: #F9F5EE;
        }


        .container {
            display: flex;
            max-width: auto;
            padding: 20px;
        }


        .sidebar {
            width: 20%;
            background-color: #fff;
            padding: 20px;
            border-right: 1px solid #ddd;
        }


        .sidebar h3 {
            margin-bottom: 30px;
            font-size: 20px;
            color: black;
            cursor: pointer;
            position: relative;
        }


        .sidebar h3::after {
            content: "\25BC";
            float: right;
            font-size: 12px;
            transform: rotate(0deg);
            transition: transform 0.3s ease;
        }


        .sidebar h3.active::after {
            transform: rotate(180deg);
        }


        .sidebar h3+ul {
            padding: 0;
            margin: 0;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }


        .sidebar ul.active {
            max-height: 200px;
        }

        .outstanding-product {
            margin-top: 50px;
        }


        .outstanding-product h3::after {
            content: none;
        }


        .outstanding-product-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 20px;
        }


        .outstanding-product-item img {
            width: 50px;
            height: 70px;
            margin-right: 10px;
            object-fit: cover;
        }


        .outstanding-product-item .name {
            font-size: 14px;
            color: #815C5C;
            margin-bottom: 4px;
        }


        .outstanding-product-item .price {
            font-size: 13px;
            color: #000;
            display: block;
        }

        .search-wrapper {
            padding: 90px 60px;
            min-height: 540px;
        }

        .search-container {
            width: 100%;
            padding: 20px;
        }


        .search-bar {
            display: flex;
            margin-bottom: 40px;
            justify-content: center;
        }


        .search-bar input {
            width: 50%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px 0 0 4px;
        }


        .search-bar input:focus {
            border-color: #815C5C;
            outline: none;
        }


        .search-bar button {
            padding: 10px 15px;
            border: none;
            background-color: #8b5d5d;
            color: #fff;
            cursor: pointer;
            border-radius: 0 4px 4px 0;
        }

        .search-bar button:hover {
            background-color: #6b3d3d;
        }

        .book-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
        }


        .book {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 4px;
            overflow: hidden;
            text-align: center;
            padding: 10px;
            transition: transform 0.3s ease;
            text-decoration: none;
        }


        .book:hover {
            transform: scale(1.1);
        }


        .book img {
            width: 100%;
            height: 100%;
            max-height: 250px;
            object-fit: cover;
        }


        .book h4 {
            margin: 10px 0;
            font-size: 16px;
            color: #815C5C;
        }


        .book-price {
            font-size: 14px;
            font-weight: bold;
            color: #000;
            font-style: italic;
        }

        #allbook {
            font-size: 1.5rem;
            font-style: italic;
            color: #815C5C;
        }
    </style>
</head>
<body class="body-wrapper">
<header class="header">
    <div class="logo-brand">
        <img src="../public/img/image.png" alt="BookNest Logo" class="logo">
        <h1 class="brand-name"><a href="/booknest_website/">BookNest</a></h1>
    </div>
    <ul class="navigation">
        <li class="nav-link"><a href="/booknest_website/">Home</a></li>
        <li class="nav-link active"><a href="<?php echo BASE_URL; ?>BookController/showSearch">Search</a></li>
    </ul>
    <div class="right-header">
        <?php if (isset($_SESSION['is_logged_in'])): ?>
            <div class="iconCart"><a href="<?php echo BASE_URL; ?>CartController/viewCart"><i class="fa-solid fa-cart-shopping icon-cart"></i></a></div>
            <div class="iconUser"><a href="<?php echo BASE_URL; ?>userController/userProfile"><i class="fa-solid fa-user icon-user"></i></a></div>
            <div class="username"><?php echo $_SESSION['current_user']['username'] ?></div>
            <div class="sign-up"><a href="<?php echo BASE_URL; ?>userController/logout">Log Out</a></div>
        <?php else: ?>
            <button class="sign-up"><a href="<?php echo BASE_URL; ?>userController/registerForm">Sign up</a></button>
            <button class="sign-up"><a href="<?php echo BASE_URL; ?>userController/loginForm">Log In</a></button>
        <?php endif; ?>
    </div>
</header>
    <div class="search-wrapper">
        <div class="container">
            <main class="search-container">
                <div class="search-bar">
                    <input id="search-input" value="" type="text" placeholder="Search your book">
                    <button id="search-btn">Search</button>
                </div>

                <?php if (!empty($term)): ?>
                    <h2 id="Results for">Results for: <?php echo $term; ?></h2>
                <?php else: ?>
                    <h2 id="allbook">All books</h2>
                <?php endif; ?>

                <?php if (empty($books)): ?>
                    <p id="Results for">No result</p>
                <?php else: ?>
                    <div class="book-grid">
                        <?php
                        foreach ($books as $key => $value) {
                        ?>
                            <a class="book" href="/booknest_website/BookController/showBookDetail?book_id=<?php echo $value['book_id']; ?>">
                                <img src="../public/img/<?php echo $value['image_path'] ?>" alt="Book Cover">
                                <h4><?php echo $value['title']; ?></h4>
                                <p class="book-price"><?php echo number_format($value['price'], 0, '', '.') . 'đ'; ?></p>
                            </a>
                        <?php } ?>
                    </div>
                <?php endif; ?>
            </main>
        </div>
    </div>
    <div class="footer">
        <div class="columns">
            <div class="columnone">
                <h4>SERVICES</h4>
                <a class="link" href="#">Terms of Service</a>
                <a class="link" href="#">Privacy Policy</a>
                <a class="link" href="#">Contact</a>
                <a class="link" href="#">Bookstore System</a>
                <a class="link" href="#">Order Tracking</a>
            </div>
            <div class="columntwo">
                <h4>SUPPORT</h4>
                <a class="link" href="#">Order Guide</a>
                <a class="link" href="#">Return and Refund Policy</a>
                <a class="link" href="#">Shipping Policy</a>
                <a class="link" href="#">Payment Methods</a>
                <a class="link" href="#">Customer Policy</a>
            </div>
            <div class="columnthree">
                <h4>ADDRESS</h4>
                <br>
                <p>Phuoc My - Son Tra - Da Nang</p>
                <br>
                <p>booknest_shd@gmail.com</p>
                <br>
                <p>0762 778 450</p>
            </div>
        </div>
        <div class="footer-line"></div>
        <div class="footer-content">
            <div class="footer-left">
                BookNest.com.vn © 2024. All Rights Reserved.
            </div>
            <div class="footer-right">
                Follow us:
                <img src="../public/img/facebook.png" alt="Facebook">
                <img src="../public/img/instagram.png" alt="Instagram">
                <img src="../public/img/twitter.png" alt="Twitter">
                <img src="../public/img/mail.png" alt="Mail">
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const headers = document.querySelectorAll('.sidebar h3');
            headers.forEach(header => {
                header.addEventListener('click', function() {
                    const list = this.nextElementSibling;
                    if (list && list.tagName === 'UL') {
                        list.classList.toggle('active');
                        this.classList.toggle('active');
                    }
                });
            });
        });
    </script>
    <script src="../public/js/search.js"></script>
</body>
</html>