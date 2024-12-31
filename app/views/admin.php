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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.tiny.cloud/1/swqgfqe5l90l69fjhsx5hywhqrqvo5n5djj34ve5in5yflqu/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
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
                    <li><a href="#" id="productListBtn"><i class="fa-solid fa-book"></i>Books</a></li>
                </ul>
            </nav>
        </aside>
        <main class="main-content">
            <div id="dashboard" class="order-section">
                <div class="header">
                    <h1>Dashboard</h1>
                    <button id="logoutBtn" class="btn-log-out">Logout</button>
                </div>
            </div>
            <div id="order-list" class="profile-section" style="display: none;">
                <div class="order-header">
                    <h2>Order management</h2>
                </div>
                <table class="order-table">
                    <thead>
                        <tr>
                            <th>OrderId</th>
                            <th>Status</th>
                            <th>Date of purchase</th>
                            <th>Total price</th>
                            <th>Buyer</th>
                            <th>Detail</th>
                            <th>Disable</th>
                        </tr>
                    </thead>
                    <tbody>

                    <?php 
                        // foreach($listAllOrder as $key => $value) {
                        //     $statusClass = ($value['status'] === 'pending') ? 'pending' : 'completed';
                        //     $status;
                        //     switch ($value['status']) {
                        //         case 'pending':
                        //             $status = 'pending';
                        //           break;
                        //         case 'completed':
                        //             $status = 'completed';
                        //           break;
                        //         default:
                        //             $status = 'inCart';
                        //     }
                    ?>

                        <tr>
                            <td class="">1</td>
                            <td><span class="badge pending">Pending</span></td>
                            <td>22/12/2025</td>
                            <td>345.000đ</td>
                            <td><span class="">Dat Pham</span></td>
                            <td class="show-detail-order"><a href="#!"><i class="fa-solid fa-circle-info"></i></a></td>
                            <td class="delete-order"><a href="#!"><i class="fa-solid fa-eye-slash"></i></a></td>
                        </tr>

                    <?php
                        // }
                    ?>

                    </tbody>
                </table>
            </div>
            <!-- User Management -->
            <div id="customer-list" class="user-section" style="display: none;">
                <div id="view-customers">
                    <h2 class="title-section">User Management</h2>
                    <div class="user-table">
                        <table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Role</th>
                                    <th>Start Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach($allUser as $key => $value){
                                ?>
                                <tr>
                                    <td><?php echo $value['user_id']?></td>
                                    <td><?php echo $value['username']?></td>
                                    <td><?php echo $value['email']?></td>
                                    <td><?php echo $value['phone']?></td>
                                    <td><?php echo $value['role']?></td>
                                    <td><?php echo $value['created_at']?></td>
                                    <td>
                                    <button class="edit-btn" onclick="openEditModal({
                                        id: <?php echo $value['user_id']; ?>,
                                        username: '<?php echo $value['username']; ?>',
                                        email: '<?php echo $value['email']; ?>',
                                        phone: '<?php echo $value['phone']; ?>',
                                        role: '<?php echo $value['role']; ?>'
                                    })">Chỉnh Sửa</button>
                                    
                                    <button class="delete-btn" onclick="deleteUser(<?php echo $value['user_id']; ?>)">Xóa</button>
                                    </td>
                                </tr>
                                <?php
                                    } 
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Edit User Form Modal -->
                <div id="form-edit-userInfo" class="modal hidden">
                    <div class="modal-content">
                        <h3>User Information</h3>
                        <form id="editUserForm" method="POST" action="/booknest_website/adminController/updateUserAdmin">
                            <input type="hidden" id="userId" name="userId">

                            <label for="username">Name:</label>
                            <input type="text" id="username" name="userName" required>

                            <label for="email">Email:</label>
                            <input type="text" id="email" name="userEmail" required>

                            <label for="phone">Phone:</label>
                            <input type="text" id="phone" name="userPhone" required>

                            <label for="role">Role:</label>
                            <input type="text" id="role" name="userRole" required>

                            <div class="form-actions">
                                <button type="submit" class="save-btn">Lưu</button>
                                <button type="button" class="cancel-btn" onclick="closeModal()">Hủy</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Book Management -->
            <div id="product-list" class="product-section">
                <div id="view-customers">
                    <h2 class="title-section">Product Management</h2>
                    <button id="btn-add-product" class="btn-add-product">Add New Book</button>
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
                    </div>
                </div>

                <!-- Edit Product Form Modal -->
                <div id="form-edit-bookInfo" class="modal hidden">
                    <div class="modal-content">
                        <h3>Edit Book Information</h3>
                        <form id="editBookForm" method="POST" action="/booknest_website/adminController/updateBookAdmin">
                            <input type="hidden" id="bookId" name="book_id">

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
                <!-- <div id="form-add-bookInfo" class="modal hidden">
                    <div class="modal-content">
                        <h3>Add New Book</h3>
                        <form id="addBookForm" method="POST" action="/booknest_website/adminController/addNewBookAdmin">
                            <input type="hidden" id="bookId">

                            <label for="titleBook">Title:</label>
                            <input type="text" id="titleName" required>

                            <label for="authorBook">Author:</label>
                            <input type="text" id="authorBook" required>

                            <label for="priceBook">Price:</label>
                            <input type="number" id="priceBook" required>

                            <label for="descriptionBook">Description:</label>
                            <input type="text" id="descriptionBook" required>

                            <div class="select-category">
                                <label for="categoryBook">Category:</label>
                                <select name="category" id="category-book" >
                                    <option value="literature_books">1</option>
                                    <option value="economics_books">2</option>
                                    <option value="life_skills_books">3</option>
                                    <option value="health_lifestyle">4</option>
                                    <option value="children's_books">5</option>
                                    <option value="horror_books">6</option>
                                    <option value="newly_released_books">7</option>
                                </select>
                            </div>
                           
                            <label for="stockBook">Stock:</label>
                            <input type="number" id="stockBook" required>

                            <div class="form-actions">
                                <button type="button" class="btn-save-product">Lưu</button>
                                <button type="button" class="btn-cancel-addproduct" onclick="closeAddBookModal()">Hủy</button>
                            </div>
                        </form>
                    </div>
                </div> -->
            </div>
        </main>
    </div>
<script src="../public/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
