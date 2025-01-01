<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>category</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
  <!-- link font chữ -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Barlow:ital,wght@0,100;0,200&family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Barlow:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Tinos:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../public/css/Payment.css?v=<?php echo time(); ?>">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #F9F5EE;
    }

    .container {
      display: flex;
      justify-content: center;
      padding: 90px 80px;
    }

    .sidebar {
      width: 20%;
      background-color: #F9F5EE;
      border: 1px solid #815C5C;
      padding: 20px;
    }

    .sidebar h3 {
      margin-top: 0;
      font-size: 28px;
      color: #815C5C;
      font-weight: bold;
    }

    .sidebar ul {
      list-style-type: none;
      margin: 0;
      font-size: 20px;
    }

    .sidebar ul li {
      margin: 10px 0;
      font-size: 20px;
      margin: 30px 0;
      cursor: pointer;
      font-style: italic;
    }

    .sidebar ul li a {
      color: #815C5C;
    }

    .sidebar ul li a:hover {
      color: brown;
    }

    .sidebar ul li.active a {
      font-weight: bold;
    }

    .sidebar ul li a {
      text-decoration: none;
    }

    .category-books-container {
      margin-left: 48px;
    }

    .title-type {
      color: #815C5C;
      font-style: italic;
    }

    .category-books {
      display: grid;
      grid-template-columns: 1fr 1fr 1fr 1fr;
      gap: 16px;
    }

    .book-item {
      background-color: #f9f9f9;
      border: 1px solid #ddd;
      border-radius: 8px;
      padding: 20px 20px 0 20px;
      text-align: center;
      transition: transform 0.3s;
      height: 330px;
      width: 200px;
      text-decoration: none;
    }

    .book-item:hover {
      transform: scale(1.05);
      /*Phóng to khi hover */
    }

    .img-book {
      width: 100%;
      height: 65%;
      margin-bottom: 8px;
      object-fit: cover;
    }

    .book-info .name-book {
      font-weight: bold;
      margin-bottom: 8px;
      color: #815C5C;
      text-decoration: none;
    }

    .book-info .price {
      color: #e91e63;
      font-size: 18px;
    }
  </style>
</head>

<body>
  <?php include 'header.php'; ?>
  <div class="container">
    <div class="sidebar">
      <h3>Categories</h3>
      <ul>
        <?php
        foreach ($categories as $key => $value) {
        ?>
          <li <?php echo $_GET['category_id'] == $value['category_id'] ? 'class="active"' : '' ?>>
            <a href="/booknest_website/categoryController/showCategory?category_id=<?php echo $value['category_id']; ?>"><?php echo $value['name'] ?></a>
          </li>
        <?php } ?>
      </ul>
    </div>

    <div class="category-books-container">
      <h2 class="title-type"><?php echo $category['name'] ?></h2>
      <div class="category-books">
        <?php
        foreach ($books as $key => $value) {
        ?>
          <a class="book-item" href="/booknest_website/bookController/showBookDetail?book_id=<?php echo $value['book_id']; ?>">
            <img class="img-book" src="../public/img/<?php echo $value['image_path'] ?>" alt="img-book">
            <div class="book-info">
              <p class="name-book"><?php echo $value['title']; ?></p>
              <p class="price"><?php echo number_format($value['price'], 0, '', '.') . 'đ'; ?></p>
            </div>
          </a>
        <?php } ?>
      </div>
    </div>
  </div>
  <?php include 'footer.php'; ?>
</body>

</html>