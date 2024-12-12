<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Barlow:ital,wght@0,100;0,200&family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/homepage.css">
    <link rel="stylesheet" href="../public/css/book_details.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <title>BookDetails</title>
</head>
<body>
<header class="header">
    <div class="logo-brand">
        <img src="../public/img/image.png" alt="BookNest Logo" class="logo">
        <h1 class="brand-name"><a href="http://localhost/booknest_website/">BookNest</a></h1>
    </div>
    <ul class="navigation">
        <li class="nav-link active"><a href="http://localhost/booknest_website/">Home</a></li>
        <li class="nav-link"><a href="#">Search</a></li>
    </ul>
    <div class="right-header">
        <div class="iconCart"><i class="fa-solid fa-cart-shopping icon-cart"></i></div>
        <div class="iconUser"><i class="fa-solid fa-user icon-user"></i></div>

        <button class="sign-up">Sign Up</button>
        <button class="log-in">Log In</button>
        
        <div class="log-out">Log Out</div>
    </div>
</header>

<div class="book-details-container">
    <div class="images-details-wrapper">
        <!-- Hình ảnh sách -->
        <div class="images-wrapper">
        <?php
            $counter = 0; 
            foreach($bookById as $key => $value) { 
                if ($counter == 0) { ?>
                    <div class="large-image">
                        <img src="../public/img/<?php echo $value['image_path']; ?>" alt="Book Cover" class="book-image">
                    </div>
                <?php }
                elseif ($counter == 1) { ?>
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
        <?php foreach($bookById as $key => $value) { ?>

        <div class="title"><?php echo $value['title']?></div>
            <div class="price-quantity-wrapper">
                <div class="price">
                    <span class="original-price"><?php echo number_format($value['price'], 0, '', '.') . 'đ'; ?></span> 
                </div>
                <div class="quantity-wrapper">
                    <label for="quantity">Quantity:</label>
                    <div class="quantity-buttons">
                        <button class="btn-decrement">-</button>
                        <button class="quantity-input" id="quantity">1</button>
                        <button class="btn-increment">+</button>
                    </div>
                </div>
            </div>
        <!-- nút bấm -->
            <div class="button-wrapper">
                <button class="btn add-to-cart">Add to cart</button>
                <button class="btn buy-now">Buy now</button>
            </div>
            <div class="description">
                <ul>
                    <li><strong>Author: </strong><?php echo $value['author']?></li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Mô tả chi tiết -->
    <div class="descriptions">
        <p>Description</p>
        <div class="description-content describe">
            <p><?php echo $value['description']?></p>
        </div>
    </div>
    <?php break; } ?>
    <!-- Sách cùng thể loại -->
    <div class="same-genre">
        <div class="same-genre-title">Books in the same genre</div>
        <div class="genre-books">
            <?php foreach($bookHasTheSameType as $key => $value) { ?>
            <div class="genre-book">
                <img src="../public/img/<?php echo $value['image_path']?>" alt="Book 1">
                <div class="genre-book-title"><?php echo $value['title']?></div>
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
</body>
</html>