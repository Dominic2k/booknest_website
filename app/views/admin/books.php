<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin management</title>
    <link rel="stylesheet" href="../public/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://d3js.org/d3.v7.min.js"></script>
    <script src="https://cdn.tiny.cloud/1/swqgfqe5l90l69fjhsx5hywhqrqvo5n5djj34ve5in5yflqu/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <style>
    .pagination {
        text-align: center;
        margin-top: 20px;
    }

    .pagination a {
        padding: 6px 10px;
        border: 1px solid rgb(208, 78, 3);
        margin: 2px;
        color: #D87D4A;
        text-decoration: none;
        min-width: 26px;
        display: inline-block;
    }

    .pagination a.active {
        background-color: #D87D4A;
        color: white;
        border-color: #D87D4A;
    }

    .pagination span {
        padding: 6px 10px;
        color: gray;
        display: inline-block;
        min-width: 26px;
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
    <div class="profile-container">
        <aside class="sidebar">
            <div class="logo">
            <div class="logo-job-header">
                    <img src="../public/img/image.png" alt="Stripe">
                    <span>Booknest</span>
            </div>
            </div>
            <nav class="menu">
                <ul>
                    <li><a href="#" id="homeBtn"><i class="fa-solid fa-house"></i>Dashboard</a></li>
                    <li><a href="#" id="orderListBtn"><i class="fa-solid fa-cart-shopping"></i>Orders</a></li>
                    <li><a href="#" id="customerListBtn"><i class="fa-solid fa-user"></i>Users</a></li>
                    <li class="active"><a href="#" id="productListBtn"><i class="fa-solid fa-book"></i>Books</a></li>
                </ul>
            </nav>
        </aside>
        <main class="main-content">
        <div id="product-list" class="product-section">
                <div id="view-customers">
                    <h2 class="title-section">Product Management</h2>
                    <button id="btn-add-product" class="btn-add-product" onclick="openAddBookModal()">Add New Book</button>
                    <div class="product-table">
                        <table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th>Author</th>
                                    <th>Price</th>
                                    <th>Description</th>
                                    <th>CategoryID</th>
                                    <th>Stock</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $old_book_name = ""; 
                                    foreach($allBook as $key => $value) { 
                                        $new_book_name = $value['title']; 
                                        if ($new_book_name === $old_book_name) {
                                            continue;
                                        }
                                    $old_book_name = $new_book_name;
                                ?>
                                <tr>
                                    <td><?php echo $value['book_id']?></td>
                                    <td>
                                        <img class="img_book" src="../public/img/<?php echo $value['image_path'] ?>" alt="image_book">
                                    </td>
                                    <td><?php echo $value['title']?></td>
                                    <td><?php echo $value['author']?></td>
                                    <td><?php echo $value['price']?></td>
                                    <td><?php echo $value['description']?></td>
                                    <td><?php echo $value['category_name']?></td>
                                    <td><?php echo $value['stock']?></td>
                                    <td>
                                        <button class="edit-btn" onclick="openEditBookModal({
                                            id: <?php echo $value['book_id']; ?>,
                                            title: '<?php echo $value['title']; ?>',
                                            author: '<?php echo $value['author']; ?>',
                                            price: '<?php echo $value['price']; ?>',
                                            description: '<?php echo $value['description']; ?>',
                                            category: '<?php echo $value['category_name']; ?>',
                                            stock: '<?php echo $value['stock']; ?>'
                                        })">Chỉnh Sửa</button>

                                        <button class="delete-btn" onclick="deleteBook(<?php echo $value['book_id']; ?>)">Xóa</button>
                                    </td>
                                </tr>
                                <?php
                                    } 
                                ?>
                            </tbody>
                        </table>
                        <div class="pagination">
                            <?php
                                $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                                $totalPages = $data['numberPage'];
                                if ($currentPage > 1) {
                                    echo '<a href="?page=' . ($currentPage - 1) . '">Pre</a>';
                                }
                                if ($currentPage == 1) {
                                    echo '<a href="?page=1" class="active">1</a>';
                                } else {
                                    echo '<a href="?page=1">1</a>';
                                }
                                if ($currentPage > 3) {
                                    echo '<span>...</span>';
                                }
                                if ($currentPage > 1 && $currentPage < $totalPages) {
                                    echo '<a href="?page=' . $currentPage . '" class="active">' . $currentPage . '</a>';
                                }
                                if ($currentPage < $totalPages - 2) {
                                    echo '<span>...</span>';
                                }
                                if ($totalPages > 1) {
                                    if ($currentPage == $totalPages) {
                                        echo '<a href="?page=' . $totalPages . '" class="active">' . $totalPages . '</a>';
                                    } else {
                                        echo '<a href="?page=' . $totalPages . '">' . $totalPages . '</a>';
                                    }
                                }
                                if ($currentPage < $totalPages) {
                                    echo '<a href="?page=' . ($currentPage + 1) . '">Next</a>';
                                }
                            ?>
                        </div>
                    </div>
                </div>

                <!-- Edit Product Form Modal -->
                <div id="form-edit-bookInfo" class="modal-edit hidden">
                    <div class="modal-content">
                        <h3>Edit Book Information</h3>
                        <form id="editBookForm" method="POST" action="/booknest_website/AdminController/updateBookAdmin" enctype="multipart/form-data">
                            <input type="hidden" id="bookId" name="book_id">

                             <!-- Add input for image upload -->
                             <label for="imageBook">Upload Image:</label>
                            <input type="file" id="imageBook" name="image" accept="image/*" required>

                            <label for="titleBook">Title:</label>
                            <input type="text" id="titleBook" name="title_book" required>

                            <label for="authorBook">Author:</label>
                            <input type="text" id="authorBook" name="author_book" required>

                            <label for="priceBook">Price:</label>
                            <input type="text" id="priceBook" name="price_book" required>

                            <label for="descriptionBook">Description:</label>
                            <input type="text" id="descriptionBook" name="description_book" required>

                            <div class="select-category">
                                <label for="categoryBook">Category:</label>
                                <select name="category" id="categoryBook" class="category-book" >
                                    <option value="Literature books">Literature books</option>
                                    <option value="Economics books">Economics books</option>
                                    <option value="Life skills books">Life skills books</option>
                                    <option value="Health & Lifestyle">Health & Lifestyle</option>
                                    <option value="Children books">Children books</option>
                                    <option value="Horror books">Horror books</option>
                                    <option value="Newly released books">Newly released books</option>
                                </select>
                            </div>

                            <label for="stockBook">Stock:</label>
                            <input type="number" id="stockBook" name="stock_book" required>

                            <div class="form-actions">
                                <button type="submit" class="btn-save-product">Lưu</button>
                                <button type="button" class="btn-cancel-editproduct" onclick="closeEditBookModal()">Hủy</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- ADD NEW BOOK -->
                <div id="form-add-bookInfo" class="modal-edit hidden">
                    <div class="modal-content">
                        <h3>Add New Book</h3>
                        <form id="addBookForm" method="POST" action="/booknest_website/AdminController/addNewBookAdmin" enctype="multipart/form-data">
                            <input type="hidden" id="bookId" name="book_id">

                            <!-- Add input for image upload -->
                            <label for="imageBook">Upload Image:</label>
                            <input type="file" id="imageBook" name="image" accept="image/*" required>

                            <label for="titleBook">Title:</label>
                            <input type="text" id="titleBook" name="title_book" required>

                            <label for="authorBook">Author:</label>
                            <input type="text" id="authorBook" name="author_book" required>

                            <label for="priceBook">Price:</label>
                            <input type="text" id="priceBook" name="price_book" required>

                            <label for="descriptionBook">Description:</label>
                            <input type="text" id="descriptionBook" name="description_book" required>

                            <div class="select-category">
                                <label for="categoryBook">Category:</label>
                                <select name="category" id="categoryBook" class="category-book" >
                                    <option value="Literature books">Literature books</option>
                                    <option value="Economics books">Economics books</option>
                                    <option value="Life skills books">Life skills books</option>
                                    <option value="Health & Lifestyle">Health & Lifestyle</option>
                                    <option value="Children books">Children books</option>
                                    <option value="Horror books">Horror books</option>
                                    <option value="Newly released books">Newly released books</option>
                                </select>
                            </div>
                           
                            <label for="stockBook">Stock:</label>
                            <input type="number" id="stockBook" name="stock_book" required>

                            <div class="form-actions">
                                <button type="submit" class="btn-save-product">Lưu</button>
                                <button type="button" class="btn-cancel-addproduct" onclick="closeAddBookModal()">Hủy</button>
                            </div>
                        </form>
                    </div>
                </div> 
            </div>
        </main>
    </div>
<script src="../public/js/admin.js?v=<?php echo time(); ?>"></script>
<script>
    // EDIT BOOK
function openEditBookModal(book) {
//   console.log(book);
  const editBookmodal = document.querySelector('#form-edit-bookInfo');
  editBookmodal.classList.add('show');
  document.getElementById('bookId').value = book.id;
  document.getElementById('titleBook').value = book.title;
  document.getElementById('authorBook').value = book.author;
  document.getElementById('priceBook').value = book.price;
  document.getElementById('descriptionBook').value = book.description;
  document.getElementById('categoryBook').value = book.category;
  document.getElementById('stockBook').value = book.stock;

}

function closeEditBookModal() {
  const editBookmodal = document.querySelector('#form-edit-bookInfo');
  editBookmodal.classList.remove('show');
}

const editBookmodal = document.querySelector('#form-edit-bookInfo');
editBookmodal.addEventListener('click', (event) => {
  if (event.target === editBookmodal) {
    editBookmodal.classList.remove('show');
  }
});

function deleteBook(book_id) {
  if (confirm(`Bạn có chắc chắn muốn xóa sách với ID: ${book_id}?`)) {
      window.location.href = `/booknest_website/AdminController/deleteBookAdmin?book_id=${book_id}`;
  }
}
// ADD NEW BOOK
function openAddBookModal() {
  const addBookmodal = document.querySelector('#form-add-bookInfo');
  addBookmodal.classList.add('show');
}

function closeAddBookModal() {
  const addBookmodal = document.querySelector('#form-add-bookInfo');
  addBookmodal.classList.remove('show');
}

const addBookmodal = document.querySelector('#form-add-bookInfo');
addBookmodal.addEventListener('click', (event) => {
  if (event.target === addBookmodal) {
    addBookmodal.classList.remove('show');
  }
});
</script>

</body>
</html>