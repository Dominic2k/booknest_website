<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bookstore Layout</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #F9F5EE;
    }

    .container {
      display: flex;
      padding: 60px 80px;
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
      margin-left: 16px;
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
  <div class="container">
    <div class="sidebar">
      <h3>Categories</h3>
      <ul>
        <?php
        foreach ($categories as $key => $value) {
        ?>
          <li <?php echo $_GET['category_id'] == $value['category_id'] ? 'class="active"' : '' ?>>
            <a href="/booknest_website/categoryController/showCategory?category_id=<?php echo $value['category_id'];?>"><?php echo $value['name'] ?></a>
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
</body>

</html>