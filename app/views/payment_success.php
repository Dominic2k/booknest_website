<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Successfully</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <!-- link font chữ -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow:ital,wght@0,100;0,200&family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Barlow:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Tinos:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/homepage.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .order-success {
        background-color: #EFEFEF;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        text-align: center;
        width: 560px;
        margin: 136px auto; /* Căn giữa phần nội dung */
        }

        .header-order-successfull {
        font-size: 18px;
        font-weight: bold;
        color: #6a4c40;
        margin-top: 30px;
        margin-bottom: 40px;
        }

        .store-name {
        font-weight: bold;
        color: #6a4c40;
        }

        .order-details {
        margin-bottom: 20px;
        }

        .book-info {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
        }

        .book-image {
        width: 50px;
        height: 70px;
        margin-right: 10px;
        object-fit: cover;
        }

        .book-title {
        font-size: 16px;
        margin: 0;
        color: #333;
        }

        .book-price {
        font-size: 14px;
        color: #999;
        margin: 0;
        }

        .total-payment {
        color: red;
        font-weight: bold;
        }

        .order-note {
        border-top: 1px solid #ddd;
        padding-top: 30px;
        font-size: 12px;
        color: #666;
        }

        .order-success-title {
            text-align: left;
            margin-bottom: 20px;
        }

        .order-info {
            text-align: left;
        }

        .order-info p {
            margin-bottom: 16px;
        }

        .book-title-price {
            text-align: left;
        }
    </style>
</head>
<body>
<?php if (isset($_SESSION['flash_message'])): ?>
    <script>
        Swal.fire({
            title: "<?php echo $_SESSION['flash_message']['type'] === 'success' ? 'Thành công!' : 'Thất bại!'; ?>",
            text: "<?php echo $_SESSION['flash_message']['message']; ?>",
            icon: "<?php echo $_SESSION['flash_message']['type']; ?>",
            timer: 3000,
            showConfirmButton: false
        });
    </script>
    <?php unset($_SESSION['flash_message']); ?>
<?php endif; ?>
<header class="header">
    <div class="logo-brand">
        <img src="../public/img/image.png" alt="BookNest Logo" class="logo">
        <h1 class="brand-name"><a href="/booknest_website/">BookNest</a></h1>
    </div>
    <ul class="navigation">
        <li class="nav-link active"><a href="/booknest_website/">Home</a></li>
        <li class="nav-link"><a href="#">Search</a></li>
    </ul>
    <div class="right-header">
        <?php if (isset($_SESSION['is_logged_in'])): ?>
            <div class="iconCart"><i class="fa-solid fa-cart-shopping icon-cart"></i></div>
            <div class="iconUser"><a href="<?php echo BASE_URL; ?>userController/userProfile"><i class="fa-solid fa-user icon-user"></i></a></div>
            <div class="username"><?php echo $_SESSION['current_user']['username'] ?></div>
            <div class="sign-up"><a href="<?php echo BASE_URL; ?>userController/logout">Log Out</a></div>
        <?php else: ?>
            <button class="sign-up"><a href="<?php echo BASE_URL; ?>userController/registerForm">Sign up</a></button>
            <button class="sign-up"><a href="<?php echo BASE_URL; ?>userController/loginForm">Log In</a></button>
        <?php endif; ?>
    </div>
</header>


<div class="order-success">
    <h1 class="header-order-successfull">ORDER SUCCESSFUL</h1>
    <div class="order-success-title">
        <p>Thank you for ordering at <span class="store-name">BookNest</span></p>
    </div>
    <div class="order-details">
      <!-- Loop through the books in the order -->
     

    <?php
        $displayed_books = []; 
        foreach ($bookInOrder as $key => $book) {
            if (in_array($book['title'], $displayed_books)) {
                continue;
            }
            $displayed_books[] = $book['title'];
        ?>
      <div class="book-info">
        <img src="../public/img/<?= $book['path']; ?>" alt="Book Cover" class="book-image">
        <div class="book-title-price">
          <h3 class="book-title"><?= $book['title']; ?></h3>
          <p class="book-price"><?= number_format($book['price'], 0, ',', '.') ?>đ</p>
        </div>
      </div>
      <?php
            }
            ?>
      <div class="order-info">
        <p class="order-info-total"><strong>Total payment:</strong> <span class="total-payment"><?= number_format($book['total_price'], 0, ',', '.') ?>đ</span></p>
        <p><strong>Delivery address:</strong> <?= $book['address_delivery']; ?></p> <!-- Assuming you have the delivery address variable -->
      </div>
    </div>
    <div class="order-note">
      <p>Your order will be delivered to you soon, please check your email for detailed information</p>
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
    const tabs = document.querySelectorAll(".nav-link");
    tabs.forEach((tab) => {
        tab.addEventListener("click", () => {
            tabs.forEach((t) => {
                t.classList.remove("active");
            });
            tab.classList.add("active");
        });
    });
</script>
</body>
</html>