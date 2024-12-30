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
                    <li><a href="#" id=""><i class="fa-solid fa-user"></i>Users</a></li>
                    <li><a href="#" id=""><i class="fa-solid fa-book"></i>Books</a></li>
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
        </main>
    </div>
<script src="../public/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
