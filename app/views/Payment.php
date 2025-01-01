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
  <title>Successful Payment</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
  <!-- link font chữ -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Barlow:ital,wght@0,100;0,200&family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Barlow:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Tinos:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../public/css/Payment.css?v=<?php echo time(); ?>">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

  <div class="container">
    <?php include 'header.php'; ?>
    <?php if (empty($user_cart) || count($user_cart) < 1): ?>
      <p>Không có sản phẩm nào trong giỏ hàng.</p>
    <?php else: ?>

      <main class="main-content">
        <section class="delivery-form">
          <h2 class="title-content">Delivery Information</h2>
          <form id="paymentForm" class="paymentForm" method="POST" action="/booknest_website/paymentController/order">
            <input class="input-address" name="inputAddress" type="text" placeholder="Add new address..." required>
            <input class="input-name" name="inputName" type="text" value="<?php echo $_SESSION['current_user']['username']; ?>" placeholder="Enter your name" required>
            <input class="input-phone" name="inputPhone" type="tel" value="<?php echo $_SESSION['current_user']['phone']; ?>" placeholder="Enter your phone" required>
            <input class="input-note" name="inputNote" type="text" placeholder="Enter a note to the seller">

            <h2 class="title-content">Payment Method</h2>
            <div class="payment-methods">
              <label class="label">
                <input type="radio" name="paymentMethod" value="cash_payment" onclick="toggleBankTransferInfo()" checked>
                Cash On Delivery
              </label>
              <label class="label">
                <input type="radio" name="paymentMethod" value="bank_transfer" onclick="toggleBankTransferInfo()">
                Bank Transfer
              </label>
            </div>

            <div id="bankTransferInfo" style="display: none; margin-top: 10px;">
              <h2 class="title-content">Bank Transfer Details</h2>
              <p>Please transfer the payment to the following bank account:</p>
              <ul class="bankTransferInfo">
                <li>Account Name: <?php echo $bankTransferInfo['accountHolder']; ?></li>
                <li>Account Number: <?php echo $bankTransferInfo['accountNumber']; ?></li>
                <li>Bank: <?php echo $bankTransferInfo['bankName']; ?></li>
                <li>Total Price: <?php echo number_format($bankTransferInfo['amount']); ?> VND</li>
              </ul>
              <h4>Scan QR Code for Payment:</h4>
              <img class="qrCode" src="<?php echo $bankTransferInfo['qrFilePath']; ?>" alt="QR Code thanh toán">
            </div>

            <?php foreach ($user_cart as $key => $item): ?>
              <div>
                <input type="hidden" name="products[<?php echo $key; ?>][book_id]" value="<?php echo $item['book_id']; ?>">
                <input type="hidden" name="products[<?php echo $key; ?>][quantity]" value="<?php echo $item['quantity']; ?>">
              </div>
            <?php endforeach; ?>
            <input type="hidden" name="total_price" value="<?php echo $total_price; ?>">

            <div class="btn">
              <button class="order-btn" type="submit">Order</button>
            </div>
          </form>
        </section>

        <section class="order-summary">
          <ul class="items-list">
            <?php
            $displayed_books = [];
            foreach ($user_cart as $key => $book) {
              if (in_array($book['title'], $displayed_books)) {
                continue;
              }
              $displayed_books[] = $book['title'];
            ?>
              <li>
                <img src="../public/img/<?php echo $book['image_path']; ?>" alt="Glow Cream" class="img-product">
                <div class="order-detail">
                  <div class="orderProduct-name"><?php echo $book['title']; ?></div>
                  <div class="quantity">
                    <input class="input_sl" id="input_sl-<?php echo $key; ?>" type="number" value="<?php echo $book['quantity']; ?>" min="1" readonly />
                  </div>
                </div>
                <p class="price"><?php echo number_format($book['price'], 0, '', '.') . 'đ'; ?></p>
              </li>
            <?php
            }
            ?>
          </ul>

          <hr>
          <div class="total-price">
            <p class="total">Total</p>
            <p class="amount"><?php echo number_format($total_price, 0, '', '.') . 'đ'; ?></p>
          </div>
        </section>
      </main>
    <?php endif; ?>

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
  </div>
  </div>

  <script>
    function toggleBankTransferInfo() {
      const selectedPaymentMethod = document.querySelector('input[name="paymentMethod"]:checked').value;
      const bankTransferInfo = document.getElementById('bankTransferInfo');

      if (selectedPaymentMethod === 'bank_transfer') {
        bankTransferInfo.style.display = 'block';
      } else {
        bankTransferInfo.style.display = 'none';
      }
    }
  </script>
</body>

</html>