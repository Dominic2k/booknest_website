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
</head>
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
                    <li class="active"><a href="#" id="orderListBtn"><i class="fa-solid fa-cart-shopping"></i>Orders</a></li>
                    <li><a href="#" id="customerListBtn"><i class="fa-solid fa-user"></i>Users</a></li>
                    <li><a href="#" id="productListBtn"><i class="fa-solid fa-book"></i>Books</a></li>
                </ul>
            </nav>
        </aside>
        <main class="main-content">  
            <div id="order-list" class="profile-section">
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
<script>
    function openModal(element) {
    const orderId = element.getAttribute('data-order-id');
    const modal = document.getElementById('orderDetailModal');
    const modalTableBody = document.getElementById('modalTableBody');

    modalTableBody.innerHTML = '<tr><td colspan="3">Đang tải...</td></tr>';

    fetch('/booknest_website/OrderController/getOrderDetails', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ order_id: orderId }),
    })
        .then(response => response.json())
        .then(data => {
            console.log('Dữ liệu từ server:', data);
            if (data.success) {
                modalTableBody.innerHTML = '';

                data.orderDetails.forEach(item => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${item.product_name}</td>
                        <td>${item.quantity}</td>
                        <td>${item.price.toLocaleString('vi-VN')}đ</td>
                    `;
                    modalTableBody.appendChild(row);
                });
            } else {
                modalTableBody.innerHTML = '<tr><td colspan="3">Không thể tải dữ liệu đơn hàng.</td></tr>';
            }
        })
        .catch(error => {
            console.error('Lỗi:', error);
            modalTableBody.innerHTML = '<tr><td colspan="3">Đã xảy ra lỗi khi tải dữ liệu.</td></tr>';
        });

    // Hiển thị modal
    modal.style.display = 'block';
}

function closeModal() {
    const modal = document.getElementById('orderDetailModal');
    modal.style.display = 'none';
}

window.onclick = function(event) {
    const modal = document.getElementById('orderDetailModal');
    if (event.target === modal) {
        modal.style.display = 'none';
    }
};
</script>
<script src="../public/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>