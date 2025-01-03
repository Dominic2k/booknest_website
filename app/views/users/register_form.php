<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <title>Sign Up Form</title>
  <style>
        /* Reset */
        * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: "Inter", sans-serif;
    }
    body{
        background-color: #f8f5ef;
        font-family: Arial, sans-serif;
        color: #5e3927;
        margin: 0;
        padding: 0;
    }
    
    /* responsive để k bị che khuất thẻ ngoài cùng */
    @media (max-width: 768px) {
        .literature-books {
            grid-template-columns: 1fr 1fr 1fr;
        }
    }

    /* ------------------------------------------------------------------------ */

    .form-title {
      margin-top: 36px;
    }

    .container {
      background-color: #fefbf6;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      width: 100%;
    }

    .signUpForm {
      margin: 0 auto;
      width: 50%;
    }

    h1 {
      text-align: center;
      font-size: 36px;
      font-weight: bold;
      color: #5e3927;
      margin-bottom: 20px;
    }

    label {
      font-size: 16px;
      font-weight: bold;
      color: #5e3927;
      margin-bottom: 8px;
      display: block;
    }

    input {
      width: 100%;
      padding: 12px 15px;
      margin-bottom: 20px;
      border: 1.5px solid #c3a89f;
      border-radius: 5px;
      box-sizing: border-box;
      font-size: 16px;
      background-color: #fefbf6;
    }

    input::placeholder {
      color: #c3a89f;
      font-style: italic;
    }

    input:focus {
      outline: none;
      border-color: #5e3927;
    }

    .btn {
        text-align: center;
    }

    .btn-register {
      width: 20%;
      padding: 12px;
      background-color: #5e3927;
      color: #fff;
      border: none;
      border-radius: 5px;
      font-size: 16px;
      font-weight: bold;
      text-transform: uppercase;
      cursor: pointer;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .btn-register:hover {
      background-color: #4d3221;
    }

    .footer-img-reg {
        background-image: url("../public/img/footer_register.png");
        background-repeat: repeat-x;
        background-size: auto;
        width: 100%;
        height: 200px;
        background-position: center;
    }

    .back-to-home i{
        margin: 16px;
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
    <div class="back-to-home">
    <a href="/booknest_website/"><i class="fa-solid fa-arrow-left"></i></a>
    </div>
  <div class="form-title">
    <h1>Sign Up</h1>
  </div>
  <hr>
  <div class="container">
    
     <!-- Hiển thị thông báo -->

    <form id="signUpForm" class="signUpForm" action="/booknest_website/userController/register" method="POST">
      <label for="username">User Name</label>
      <input type="text" id="username" name="username" placeholder="User Name" required>

      <label for="email">Email</label>
      <input type="email" id="email" name="email" placeholder="E-Mail" required>

      <label for="password">Password</label>
      <input type="password" id="password" name="password" placeholder="Password" required>

      <label for="confirmPassword">Confirm Password</label>
      <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" required>

      <div class="btn">
        <button type="submit" class="btn-register">Sign Up</button>
      </div>
    </form>
</div>
<div class="footer-img-reg">
</div>

  <script>
    document.getElementById('signUpForm').addEventListener('submit', function(event) {
      const username = document.getElementById('username').value;
      const email = document.getElementById('email').value;
      const password = document.getElementById('password').value;
      const confirmPassword = document.getElementById('confirmPassword').value;

      if (password !== confirmPassword) {
        alert('Passwords do not match!');
        return;
      }
    });
  </script>
</body>
</html>
