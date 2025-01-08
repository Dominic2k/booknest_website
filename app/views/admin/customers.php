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
                    <li class="active"><a href="#" id="customerListBtn"><i class="fa-solid fa-user"></i>Users</a></li>
                    <li><a href="#" id="productListBtn"><i class="fa-solid fa-book"></i>Books</a></li>
                </ul>
            </nav>
        </aside>
        <main class="main-content">
        <div id="customer-list" class="user-section">
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
                <!-- Edit User Form Modal -->
                <div id="form-edit-userInfo" class="modal-edit hidden">
                    <div class="modal-content">
                        <h3>User Information</h3>
                        <form id="editUserForm" method="POST" action="/booknest_website/AdminController/updateUserAdmin">
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
        </main>
    </div>

<script>
    function openEditModal(user) {
        const modal = document.querySelector('#form-edit-userInfo');
        modal.classList.add('show');
        document.getElementById('userId').value = user.id;
        document.getElementById('username').value = user.username;
        document.getElementById('email').value = user.email;
        document.getElementById('phone').value = user.phone;
        document.getElementById('role').value = user.role;
        }

    function closeModal() {
        const modal = document.querySelector('#form-edit-userInfo');
        modal.classList.remove('show'); 
    }

    const modalUserInfo = document.querySelector('#form-edit-userInfo');
    modalUserInfo.addEventListener('click', (event) => {
        if (event.target === modalUserInfo) {
            modalUserInfo.classList.remove('show');
        }
    });

    function deleteUser(userId) {
        if (confirm(`Bạn có chắc chắn muốn xóa người dùng với ID: ${userId}?`)) {
            window.location.href = `/booknest_website/AdminController/deleteUserAdmin?user_id=${userId}`;
        }
    }
</script>
<script src="../public/js/admin.js?v=<?php echo time(); ?>"></script>

</body>
</html>