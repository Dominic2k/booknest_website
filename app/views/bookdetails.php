<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Barlow:ital,wght@0,100;0,200&family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/homepage.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../public/css/book_details.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Barlow:ital,wght@0,100;0,200&family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Barlow:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Tinos:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <title>BookDetails</title>
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
    <div class="book-details-container">
        <div class="images-details-wrapper">
            <!-- Hình ảnh sách -->
            <div class="images-wrapper">
                <?php
                $counter = 0;
                foreach ($bookById as $key => $value) {
                    if ($counter == 0) { ?>
                        <div class="large-image">
                            <img src="../public/img/<?php echo $value['image_path']; ?>" alt="Book Cover" class="book-image">
                        </div>
                    <?php } elseif ($counter == 1) { ?>
                        <div class="small-image">
                            <img src="../public/img/<?php echo $value['image_path']; ?>" alt="Small Image 1" class="small-book-image">
                        </div>
                <?php }
                    $counter++;
                    if ($counter >= 2) break;
                }
                ?>
            </div>
            <!-- Chi tiết sách -->
            <div class="details-wrapper">
                <?php foreach ($bookById as $key => $value) { ?>
                    
                    <div class="title"><?php echo $value['title'] ?></div>
                    <div class="price-quantity-wrapper">
                        <div class="price">
                            <span class="original-price"><?php echo number_format($value['price'], 0, '', '.') . 'đ'; ?></span>
                        </div>
                        <div class="quantity-wrapper">
                            <label for="quantity">Quantity:</label>
                            <div class="quantity-buttons">
                                <button class="btn-decrement">-</button>
                                <span class="quantity-input" id="quantity">1</span>
                                <button class="btn-increment">+</button>
                            </div>
                        </div>
                        <div id="quantity-message" class="quantity-message"></div>
                    </div>
                    <!-- nút bấm -->
                    <div class="button-wrapper">
                        <a href="javascript:void(0);" id="add-to-cart" class="btn add-to-cart" data-book-id="<?php echo $value['book_id']; ?>">Add to cart</a>
                        <a href="javascript:void(0);" id="buy-now-btn" class="btn add-to-cart" data-book-id="<?php echo $value['book_id']; ?>">Buy now</a>
                    </div>
                    <div class="description">
                        <ul>
                            <li><strong>Author: </strong><?php echo $value['author'] ?></li>
                            <li data-stock="<?php echo $value['stock']; ?>"><strong>Stock available: </strong><?php echo $value['stock'] ?></li>
                        </ul>
                    </div>
            </div>
        </div>
        <!-- Mô tả chi tiết -->
        <div class="descriptions">
            <p>Description</p>
            <div class="description-content describe">
                <p><?php echo $value['description'] ?></p>
            </div>
        </div>
    <?php break;
                } ?>
    <!-- Sách cùng thể loại -->
    <div class="same-genre">
        <div class="same-genre-title">Books in the same genre</div>
        <div class="genre-books">
            <?php foreach ($bookHasTheSameType as $key => $value) { ?>
                <div class="genre-book">
                    <img src="../public/img/<?php echo $value['image_path'] ?>" alt="Book 1">
                    <a class="name-book genre-book-title" href="/booknest_website/bookController/showBookDetail?book_id=<?php echo $value['book_id']; ?>"><?php echo $value['title']; ?></a>
                    <div class="genre-book-price"><?php echo number_format($value['price'], 0, '', '.') . 'đ'; ?></div>
                </div>
            <?php } ?>
        </div>
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
    <script src="../public/js/book-detail.js"></script>
</body>

</html>