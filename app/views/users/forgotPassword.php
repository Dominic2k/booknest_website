<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Password Form</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">

  <style>
    /* General Styling */
    body {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Inter",sans-serif;
      background-color: #f8f5ef;
      color: #5e3927;
    }

    #overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color:  #f8f5ef;
      display: none;
    }

    .form-container {
      position: relative;
      background-color: #fefbf6;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      max-width: 400px;
      margin: 50px auto;
      display: none;
    }

    .form-title {
      text-align: center;
      margin-bottom: 20px;
      font-size: 25px;
    }

    .form-label {
      margin-bottom: 8px;
      font-weight: bold;
      font-size: 15px;
      display: block;
    }

    .form-input {
      width: 100%;
      padding: 10px;
      margin-bottom: 20px;
      border: 1px solid #c3a89f;
      border-radius: 5px;
    }

    .form-btn {
      width: 40%;
      padding: 10px;
      background-color: #5e3927;
      color: #fff;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .form-btn:hover {
      background-color: #3e2519;
      transform: scale(1.03);
    }
    .close-btn {
      position: absolute;
      top: 5px;
      right: 5px;
      background: none;
      border: none;
      font-size: 25px;
      color: #8b5e3c;
      cursor: pointer;
      transition: color 0.3s ease, transform 0.2s ease;
    }

    .close-btn:hover {
      color: #5e3927;
      transform: scale(1.2);
    }

    .btn-submit-forget-pass {
      text-align: center;
      width: 100%;
    }
    .back-to-home {
      cursor: pointer;
      padding: 16px;
    }
  </style>
</head>
<body>
<div class="back-to-home" onclick="location.href='/booknest_website/'">
        <i class="fa-solid fa-arrow-left" title="Go Back"></i>

    </div>
  <!-- Reset Password Form -->
  <?php if(isset($data['check-process'])&&$data['check-process'] == 1): ?>
  <div id="reset-container" class="form-container" style="display: block;">
    <button id="close-btn-reset" class="close-btn" type="button">&times;</button>
    <h1 class="form-title">Reset Password</h1>
    <form id="reset-form" action="/booknest_website/userController/forgotPassword" method="POST">
      <label class="form-label" for="email-input">Email</label>
      <input id="email-input" name="email" class="form-input" type="email" placeholder="Enter your email" required>
      <div class="btn-submit-forget-pass">
      <button id="reset-btn" class="form-btn" type="submit">Send</button>
      </div>
    </form>
  </div>
  <?php endif ; ?>
  <?php if(isset($data['check-process'])&&$data['check-process'] == 2) : ?>
  <!-- Code Verification Form -->
  <div id="code-container" class="form-container" style="display: block;">
    <button id="close-btn-code" class="close-btn" type="button">&times;</button>
    <h1 class="form-title">Enter Verification Code</h1>
    <form id="code-form" action="/booknest_website/userController/resetPassword" method="POST">
      <label class="form-label" for="code-input">Verification Code</label>
      <input id="code-input" name="reset_code" class="form-input" type="text" placeholder="Enter the code" required>
      <label class="form-label" for="password-input">New Password</label>
      <input id="password-input" name="new_password" class="form-input" type="password" placeholder="Enter your new password" required>
      <div class="btn-submit-forget-pass">
        <button id="code-btn" class="form-btn" type="submit">Update</button>
      </div>
    </form>
  </div>
  <?php endif ;?>

  <script>

    const closeButtons = document.querySelectorAll('.close-btn');
    // Event: Close buttons
    closeButtons.forEach(button => {
      button.addEventListener('click', () => {
        resetContainer.style.display = 'none';
        codeContainer.style.display = 'none';
        changeContainer.style.display = 'none';
        overlay.style.display = 'none';
      });
    });
  </script>
</body>
</html>
