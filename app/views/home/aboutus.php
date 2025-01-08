<?php
    session_start();    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Barlow:ital,wght@0,100;0,200&family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/homepage.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../public/css/about_us.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Barlow:ital,wght@0,100;0,200&family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Barlow:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Tinos:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <title>About Us</title>
    <style>
        .container{
            max-width: auto;
            padding: 50px;
            padding-top: 70px;
        }

        /* About Section */
        .about-details {
          display: flex;
          flex-wrap: wrap;
          align-items: center;
          padding: 20px 0;
        }

        .about-image {
          flex: 1;
          padding: 20px;
          transition: transform 0.3s;
        }

        .about-image:hover{
            transform: scale(1.05);
        }

        .about-image img {
          width: 100%;
          border-radius: 10px;
        }

        .about-intro {
          flex: 1;
          padding: 20px;
        }

        .title-intro{
            font-size: 34px;
            margin-bottom: 6px;
            color: #815C5C;
        }

        .intro-detail{
            color: #815C5C;
            text-align: justify;
            font-style: italic;
        }

        .btn {
          display: inline-block;
          padding: 10px 20px;
          color: #fff;
          background-color: #815C5C;
          border-radius: 5px;
          text-decoration: none;
          margin-top: 20px;
        }

        .btn:hover {
          background-color:rgb(107, 71, 71);
        }

        /* Features Section */
        .features {
          padding: 50px 20px;
          border-radius: 6px;
        }

        .title-features {
          text-align: center;
          font-size: 36px;
          margin-bottom: 30px;
          color: #815C5C;
        }

        .features-grid {
          display: grid;
          grid-template-columns: 1fr 1fr 1fr 1fr;
          justify-content: space-between;
          column-gap: 20px;
        }

        .feature-item {
          flex: 1 1 calc(25% - 20px);
          margin: 10px;
          text-align: center;
          background-color: #fff;
          transition: transform 0.3s;
          height: 210px;
          box-sizing: border-box;
          padding: 20px;
          border-radius: 10px; 
          box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); 
        }

        .feature-item:hover{
            transform: scale(1.05);
        }

        .feature-item img {
          height: 80px;
          width: 94px;
          border-radius: 8px;
          margin-bottom: 10px;
        }

        .feature-item .title{
          font-size: 18px;
          margin-bottom: 10px;
          color:#815C5C;
        }

        .feature-item .description{
            color: #815C5C;
            font-style: italic;
        }
    </style>
</head>

<body>  
    <header class="header">
        <div class="logo-brand">
            <img src="../public/img/image.png" alt="BookNest Logo" class="logo">
            <h1 class="brand-name"><a href="/booknest_website/">BookNest</a></h1>
        </div>
        <ul class="navigation">
            <li class="nav-link"><a href="/booknest_website/">Home</a></li>
            <li class="nav-link"><a href="<?php echo BASE_URL; ?>BookController/showSearch">Search</a></li>
            <li class="nav-link active"><a href="<?php echo BASE_URL; ?>homeController/showAboutUs">About us</a></li>
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
    <div class="container">
      <section class="about-details">
          <div class="about-image">
            <img src="../public/img/aboutus.png" alt="Bookshelf">
          </div>
          <div class="about-intro">
            <h2 class="title-intro">Your Gateway to a World of Books</h2>
            <p class="intro-detail">At BookNest, we are passionate about connecting readers with stories that inspire, educate, and entertain. With a vast collection of books across all genres, we aim to make reading accessible and enjoyable for everyone.</p>
            <a href="<?php echo BASE_URL; ?>BookController/showSearch" class="btn">Browse Books</a>
          </div>
      </section>
      <!-- Features Section -->
      <section class="features">
        <h2 class="title-features">What We Offer</h2>
        <div class="features-grid">
          <div class="feature-item">
            <img src="../public/img/TypeOfBook.png" alt="Collection Icon">
            <h3 class="title">Extensive Collection</h3>
            <p class="description">Thousands of books spanning every genre imaginable.</p>
          </div>
          <div class="feature-item">
            <img src="../public/img/fastDelivery.png" alt="Delivery Icon">
            <h3 class="title">Fast Delivery</h3>
            <p class="description">Get your books delivered to your doorstep quickly and reliably.</p>
          </div>
          <div class="feature-item">
            <img src="../public/img/support.jpg" alt="Support Icon">
            <h3 class="title">Customer Support</h3>
            <p class="description">Our team is here to assist you with all your queries.</p>
          </div>
          <div class="feature-item">
            <img src="../public/img/deal.png" alt="Discount Icon">
            <h3 class="title">Exclusive Deals</h3>
            <p class="description">Enjoy discounts and special offers for our loyal readers.</p>
          </div>
        </div>
      </section>
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