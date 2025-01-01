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
    <title>BookNest</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <!-- link font chữ -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow:ital,wght@0,100;0,200&family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Barlow:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Tinos:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="public/css/homepage.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <!-- Header -->
    <?php
    require_once 'header.php';
    ?>
    <div class="content">
        <div class="content-left">
            <div class="categories">
                <h2 class="title-categories">Categories</h2>
                <ul class="categories-list">
                    <?php
                    foreach ($categories as $key => $value) {
                    ?>
                        <li class="categories-item">
                            <a href="/booknest_website/CategoryController/showCategory?category_id=<?php echo $value['category_id']; ?>"><?php echo $value['name'] ?></a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
            <img class="poster" src="public/img/Horror-book.png" alt="horror book">
            <div class="best-seller">
                <h2 class="title-type">Bestselling New Books</h2>
                <div class="products-bestSeller">
                    <?php
                    foreach ($bookBestSelling as $key => $value) {
                    ?>
                        <div class="product-item-bestSeller">
                            <img class="image-book" src="public/img/<?php echo $value['image_path'] ?>" alt="image-book">
                            <div class="name-price">
                                <a class="name-book" href="/booknest_website/BookController/showBookDetail?book_id=<?php echo $value['book_id'] ?>"><?php echo $value['title'] ?></a>
                                <p class="price-book"><?php echo number_format($value['price'], 0, '', '.') . 'đ'; ?>
                                </p>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>

        <div class="content-right">
            <!-- Slider -->
            <div class="slider-container">
                <div class="slider">
                    <!-- Clone slide cuối -->
                    <img class="slider-item" src="public/img/slider4.png" alt="Slider 4">

                    <img class="slider-item" src="public/img/slider1.jpg" alt="Slider 1">
                    <img class="slider-item" src="public/img/slider2.png" alt="Slider 2">
                    <img class="slider-item" src="public/img/slider3.png" alt="Slider 3">
                    <img class="slider-item" src="public/img/slider4.png" alt="Slider 4">

                    <!-- Clone slide đầu -->
                    <img class="slider-item" src="public/img/slider1.jpg" alt="Slider 1">
                </div>

                <!-- Nút điều hướng -->
                <div class="slider-control slider-control-prev"><i class="bi bi-arrow-left-circle"></i></div>
                <div class="slider-control slider-control-next"><i class="bi bi-arrow-right-circle"></i></div>

                <!-- Chấm chỉ mục -->
                <div class="slider-pagination">
                    <div class="slider-pagination-dot active"></div>
                    <div class="slider-pagination-dot"></div>
                    <div class="slider-pagination-dot"></div>
                    <div class="slider-pagination-dot"></div>
                </div>
            </div>

            <img class="image-hero" src="public/img/hero.png" alt="hero">

            <div class="literature">
                <h2 class="title-type">Literature Books</h2>
                <div class="literature-books">
                    <?php
                    $old_book_name = "";
                    foreach ($LiteratureBooks as $key => $value) {
                        $new_book_name = $value['title'];
                        if ($new_book_name === $old_book_name) {
                            continue;
                        }
                        $old_book_name = $new_book_name;
                    ?>
                        <div class="literature-item">
                            <img class="img-book" src="public/img/<?php echo $value['image_path'] ?>" alt="img-book">
                            <div class="book-info">
                                <a class="name-book" href="/booknest_website/BookController/showBookDetail?book_id=<?php echo $value['book_id']; ?>"><?php echo $value['title']; ?></a>
                                <p class="price"><?php echo number_format($value['price'], 0, '', '.') . 'đ'; ?></p>
                            </div>
                        </div>
                    <?php } ?>
                </div>

            </div>

            <div class="economics">
                <h2 class="title-type">Economics Books</h2>
                <div class="literature-books">
                    <?php
                    $old_book_name = "";
                    foreach ($EconomicBooks as $key => $value) {
                        $new_book_name = $value['title'];
                        if ($new_book_name === $old_book_name) {
                            continue;
                        }
                        $old_book_name = $new_book_name;
                    ?>
                        <div class="literature-item">
                            <img class="img-book" src="public/img/<?php echo $value['image_path'] ?>" alt="img-book">
                            <div class="book-info">
                                <a class="name-book" href="/booknest_website/BookController/showBookDetail?book_id=<?php echo $value['book_id']; ?>"><?php echo $value['title']; ?></a>
                                <p class="price"><?php echo number_format($value['price'], 0, '', '.') . 'đ'; ?></p>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>

            <div class="life skills">
                <h2 class="title-type">Life Skills Books</h2>
                <div class="literature-books">
                    <?php
                    $old_book_name = "";
                    foreach ($LifeSkillsBooks as $key => $value) {
                        $new_book_name = $value['title'];
                        if ($new_book_name === $old_book_name) {
                            continue;
                        }
                        $old_book_name = $new_book_name;
                    ?>
                        <div class="literature-item">
                            <img class="img-book" src="public/img/<?php echo $value['image_path'] ?>" alt="img-book">
                            <div class="book-info">
                                <a class="name-book" href="/booknest_website/BookController/showBookDetail?book_id=<?php echo $value['book_id']; ?>"><?php echo $value['title']; ?></a>
                                <p class="price"><?php echo number_format($value['price'], 0, '', '.') . 'đ'; ?></p>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>

            <div class="health-lifestyle">
                <h2 class="title-type">Health & Lifestyle</h2>
                <div class="literature-books">
                    <?php
                    $old_book_name = "";
                    foreach ($HealthLifestyle as $key => $value) {
                        $new_book_name = $value['title'];
                        if ($new_book_name === $old_book_name) {
                            continue;
                        }
                        $old_book_name = $new_book_name;
                    ?>
                        <div class="literature-item">
                            <img class="img-book" src="public/img/<?php echo $value['image_path'] ?>" alt="img-book">
                            <div class="book-info">
                                <a class="name-book" href="/booknest_website/BookController/showBookDetail?book_id=<?php echo $value['book_id']; ?>"><?php echo $value['title']; ?></a>
                                <p class="price"><?php echo number_format($value['price'], 0, '', '.') . 'đ'; ?></p>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="children's">
                <h2 class="title-type">Children Books</h2>
                <div class="literature-books">
                    <?php
                    $old_book_name = "";
                    foreach ($Childrens_books as $key => $value) {
                        $new_book_name = $value['title'];
                        if ($new_book_name === $old_book_name) {
                            continue;
                        }
                        $old_book_name = $new_book_name;
                    ?>
                        <div class="literature-item">
                            <img class="img-book" src="public/img/<?php echo $value['image_path'] ?>" alt="img-book">
                            <div class="book-info">
                                <a class="name-book" href="/booknest_website/BookController/showBookDetail?book_id=<?php echo $value['book_id']; ?>"><?php echo $value['title']; ?></a>
                                <p class="price"><?php echo number_format($value['price'], 0, '', '.') . 'đ'; ?></p>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>

            <div class="horror">
                <h2 class="title-type">Horror Books</h2>
                <div class="literature-books">
                    <?php
                    $old_book_name = "";
                    foreach ($Horror_books as $key => $value) {
                        $new_book_name = $value['title'];
                        if ($new_book_name === $old_book_name) {
                            continue;
                        }
                        $old_book_name = $new_book_name;
                    ?>
                        <div class="literature-item">
                            <img class="img-book" src="public/img/<?php echo $value['image_path'] ?>" alt="img-book">
                            <div class="book-info">
                                <a class="name-book" href="/booknest_website/BookController/showBookDetail?book_id=<?php echo $value['book_id']; ?>"><?php echo $value['title']; ?></a>
                                <p class="price"><?php echo number_format($value['price'], 0, '', '.') . 'đ'; ?></p>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php
    require_once 'footer.php';
    ?>

    <script>
        const slider = document.querySelector('.slider');
        const sliderItems = document.querySelectorAll('.slider-item');
        const prevButton = document.querySelector('.slider-control-prev');
        const nextButton = document.querySelector('.slider-control-next');
        const paginationDots = document.querySelectorAll('.slider-pagination-dot');

        let currentIndex = 1;
        const totalSlides = sliderItems.length;

        function updateSlider() {
            slider.style.transform = `translateX(-${currentIndex * 100}%)`;

            paginationDots.forEach((dot, index) => {
                dot.classList.toggle('active', index === currentIndex - 1);
            });
        }


        function nextSlide() {
            if (currentIndex >= totalSlides - 1) {
                currentIndex = 1;
                slider.style.transition = 'none';
                slider.style.transform = `translateX(-${currentIndex * 100}%)`;
                setTimeout(() => {
                    slider.style.transition = 'transform 0.8s ease-in-out';
                    nextSlide();
                }, 50);
                return;
            }
            currentIndex++;
            updateSlider();
        }

        // Chuyển slide trước đó
        function prevSlide() {
            if (currentIndex <= 0) {
                // Đến slide clone đầu tiên
                currentIndex = totalSlides - 2; // Reset về slide thực cuối cùng
                slider.style.transition = 'none'; // Tắt hiệu ứng chuyển đổi
                slider.style.transform = `translateX(-${currentIndex * 100}%)`;
                setTimeout(() => {
                    slider.style.transition = 'transform 0.8s ease-in-out'; // Khôi phục hiệu ứng
                    prevSlide();
                }, 50);
                return;
            }
            currentIndex--;
            updateSlider();
        }

        // Tự động chạy slider
        let autoSlideInterval = setInterval(nextSlide, 2000);

        // Thêm sự kiện click cho nút
        nextButton.addEventListener('click', () => {
            nextSlide();
            resetAutoSlide();
        });

        prevButton.addEventListener('click', () => {
            prevSlide();
            resetAutoSlide();
        });

        // Reset thời gian chạy khi thao tác
        function resetAutoSlide() {
            clearInterval(autoSlideInterval);
            autoSlideInterval = setInterval(nextSlide, 2000);
        }

        // Khởi chạy slider
        updateSlider();
    </script>
</body>

</html>