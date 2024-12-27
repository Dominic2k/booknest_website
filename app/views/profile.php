<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Personal Information</title>
  <link href="https://fonts.googleapis.com/css2?family=Barlow:ital,wght@0,100;0,200&family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../public/css/homepage.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <style>
    .wrapper {
      font-family: "Inter", sans-serif;
      background-color: #F9F5EE;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 71vh;
    }

    .profile-container {
      background: #F9F5EE;
      padding: 20px 30px;
      border-radius: 8px;
      width: 650px;
      text-align: center;
    }

    .profile-title {
      margin-bottom: 6px;
      margin-top: 30px;
      color: #5b3d33;
    }

    .profile-group {
      margin-bottom: 30px;
      text-align: left;
    }

    .profile-label {
      display: block;
      margin-bottom: 5px;
      color: #5b3d33;
      font-size: 14px;
      font-weight: bold;
    }

    .profile-label i {
      margin-right: 8px;
      color: #5b3d33;
    }

    .profile-input {
      width: 100%;
      padding: 10px;
      font-size: 14px;
      border: 1px solid #815C5C;
      border-radius: 5px;
      outline: none;
      background-color: white;
    }

    .profile-input:focus {
      border-color: #F9F5EE;
    }

    .profile-button {
      background-color: #c29d8e;
      color: #fff;
      border: none;
      padding: 10px 20px;
      font-size: 16px;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    .profile-button:hover {
      background-color: #815C5C;
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
        <li class="nav-link active"><a href="/booknest_website/">Home</a></li>
        <li class="nav-link"><a href="#">Search</a></li>
    </ul>
    <div class="right-header">
        <?php if (isset($_SESSION['is_logged_in'])): ?>
            <div class="iconCart"><a href="<?php echo BASE_URL; ?>cartController/viewCart"><i class="fa-solid fa-cart-shopping icon-cart"></i></a></div>
            <div class="iconUser"><a href="<?php echo BASE_URL; ?>userController/userProfile"><i class="fa-solid fa-user icon-user"></i></a></div>
            <div class="username"><?php echo $_SESSION['current_user']['username'] ?></div>
            <div class="sign-up"><a href="<?php echo BASE_URL; ?>userController/logout">Log Out</a></div>
        <?php else: ?>
            <button class="sign-up"><a href="<?php echo BASE_URL; ?>userController/registerForm">Sign up</a></button>
            <button class="sign-up"><a href="<?php echo BASE_URL; ?>userController/loginForm">Log In</a></button>
        <?php endif; ?>
    </div>
</header>
  <div class="wrapper">
    <div class="profile-container">
      <h2 class="profile-title">Personal Information</h2>
      <form action="<?php echo BASE_URL; ?>userController/updateUserInfo" method="POST">
        <?php
         foreach ($user as $key => $value) { 
        ?>
          <div class="profile-group">
            <label class="profile-label" for="username"><i class="fas fa-user"></i> User name</label>
            <input class="profile-input" name="username" type="text" id="username" placeholder="Enter your name" value="<?php echo $value['username'] ?>">
          </div>
          <div class="profile-group">
            <label class="profile-label" for="email"><i class="fas fa-envelope"></i> Email</label>
            <input class="profile-input" name="email" type="email" id="email" placeholder="Enter your email" value="<?php echo $value['email'] ?>">
          </div>
          <div class="profile-group">
            <label class="profile-label" for="phone"><i class="fas fa-phone"></i> Phone</label>
            <input class="profile-input" name="phone" type="tel" id="phone" placeholder="Enter your phone" value="<?php echo $value['phone'] ?>">
          </div>
          <div class="profile-group">
            <label class="profile-label" for="password"><i class="fas fa-lock"></i> Password</label>
            <input class="profile-input" name="password" type="password" id="password" placeholder="Enter your password" value="<?php echo $value['password'] ?>">
          </div>
          <button class="profile-button" type="submit">Update</button>
        <?php
          } 
        ?>
      </form>
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
</body>

</html>