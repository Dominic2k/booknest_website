<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin management</title>
    <link rel="stylesheet" href="../public/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="../public/css/loading.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://d3js.org/d3.v7.min.js"></script>
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
                    <li><a href="#" id=""><i class="fa-solid fa-user"></i>Users</a></li>
                    <li><a href="#" id=""><i class="fa-solid fa-book"></i>Books</a></li>
                </ul>
            </nav>
        </aside>
        <main class="main-content">
            <div id="dashboard" class="order-section">
                <div class="header">
                    <h1>Dashboard</h1>
                    <button onclick="window.location.href='<?php echo BASE_URL; ?>userController/logout'" id="logoutBtn" class="btn-log-out">Logout</button>
                </div>
                <div class="dashboard">
                    <div class="stats">
                        <div>
                            <h3>Revenue this week</h3>
                            <p id="weeklyRevenue">0đ</p>
                        </div>
                        <div>
                            <h3>Order is pending</h3>
                            <p id="pendingOrders">0</p>
                        </div>
                        <div>
                            <h3>Number of books sold</h3>
                            <p id="totalBooksSold">0</p>
                        </div>
                    </div>
                    <div class="charts">
                        <div id="topSellingBooksChart"></div>
                    </div>
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
                            <th>Mark as Complete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        foreach($orders as $key => $value) {
                        ?>
                        <tr>
                            <td class=""><?php echo $value['order_id'] ?></td>
                            <td><span class="badge <?php echo $value['status'] ?>"><?php echo $value['status'] ?></span></td>
                            <td><?php echo $value['order_date'] ?></td>
                            <td><?php echo number_format($value['total_price'], 0, ',', '.') . 'đ'; ?></td>
                            <td><span class=""><?php echo $value['buyer_name'] ?></span></td>
                            <td class="show-detail-order" onclick="openModal(this)" data-order-id="<?php echo $value['order_id'] ?>"><i class="fa-solid fa-circle-info"></i></td>
                            <td class="delete-order"><a href="<?php echo BASE_URL; ?>OrderController/completeOrder?order_id=<?php echo $value['order_id'] ?>"><i class="fa-solid fa-repeat"></i></a></td>    
                        </tr>

                        <?php    
                        }
                        ?>
                    <?php
                        // }
                    ?>

                    </tbody>
                </table>
                <div id="orderDetailModal" class="modal">
                    <div class="modal-content">
                        <span class="close" onclick="closeModal()">&times;</span>
                        <h2>Order Details</h2>
                        <table class="table-modal">
                            <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            <tbody id="modalTableBody">
                                <!-- Nội dung sẽ được cập nhật bằng JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
<script src="../public/js/admin.js?v=<?php echo time(); ?>"></script>
<script src="../public/js/loading.js?v=<?php echo time(); ?>"></script>
</body>
</html>
