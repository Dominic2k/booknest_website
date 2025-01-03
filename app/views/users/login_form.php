<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <title>Log In Form</title>
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
            padding-bottom: 166px;
        }

        .logInForm {
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

        .btn-login {
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

        .btn-login:hover {
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
        .forgetPassword{
            height: 30px;
            margin-bottom: 18px;
            text-align: right;
        }
        .forget-password{
            font-size: 20px;
            color: #5e3927;
        }

        .back-to-home {
            cursor: pointer;
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


    <div class="back-to-home" onclick="location.href='/booknest_website/'">
        <i class="fa-solid fa-arrow-left" title="Go Back"></i>

    </div>

    <div class="form-title">
        <h1>Log In</h1>
    </div>
    <hr>
    <div class="container">
    
        <!-- Hiển thị thông báo -->
        <form id="logInForm" class="logInForm" action="/booknest_website/userController/login" method="POST">
            <label for="username">User Name</label>
            <input type="text" name="username" placeholder="Username" required>

            <label for="password">Password</label>
            <input type="password" name="password" placeholder="Password" required>
            
            <div class="forgetPassword">
                <a href="/booknest_website/userController/forgotPassForm" class="forget-password">Forget the password</a>
            </div>
            
            <div class="btn">
                <button type="submit" class="btn-login">Log In</button>
            </div>
        </form>
    </div>

    <div class="footer-img-reg"></div>

</body>
</html>
