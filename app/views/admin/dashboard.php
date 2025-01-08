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
                    <li class="active"><a href="#" id="homeBtn"><i class="fa-solid fa-house"></i>Dashboard</a></li>
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
                    <button onclick="window.location.href='<?php echo BASE_URL; ?>UserController/logout'" id="logoutBtn" class="btn-log-out">Logout</button>
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
        </main>
    </div>
<script src="../public/js/admin.js?v=<?php echo time(); ?>"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
    fetch('/booknest_website/OrderController/getDashboardStats')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const stats = data.data;
                updateDashboard(stats);
            } else {
                console.error('Lỗi khi tải dữ liệu dashboard:', data.message);
            }
        })
        .catch(error => console.error('Lỗi:', error));
});

function updateDashboard(stats) {
    const weeklyRevenue = stats.weeklyRevenue[0].weekly_revenue;
    const pendingOrders = stats.pendingOrders[0].pending_orders;
    const totalBooksSold = stats.totalBooksSold[0].total_books_sold;

    document.getElementById('weeklyRevenue').textContent = `${weeklyRevenue.toLocaleString('vi-VN')}đ`;
    document.getElementById('pendingOrders').textContent = pendingOrders;
    document.getElementById('totalBooksSold').textContent = totalBooksSold;

    const topSellingBooks = stats.topSellingBooks.map(book => ({
        title: book.title,
        total_sold: +book.total_sold
    }));
    createTopSellingBooksChart(topSellingBooks);
}

function createTopSellingBooksChart(topSellingBooks) {
    const chartWidth = 1080;
    const chartHeight = 400;
    const margin = { top: 40, right: 30, bottom: 80, left: 70 };

    // Tạo SVG
    const svg = d3.select('#topSellingBooksChart')
        .append('svg')
        .attr('width', chartWidth)
        .attr('height', chartHeight)
        .style('background', '#fff')
        .style('border-radius', '8px');

    // Thang đo
    const xScale = d3.scaleBand()
        .domain(topSellingBooks.map(book => book.title))
        .range([margin.left, chartWidth - margin.right])
        .padding(0.2);

    const yScale = d3.scaleLinear()
        .domain([0, d3.max(topSellingBooks, book => book.total_sold)])
        .nice()
        .range([chartHeight - margin.bottom, margin.top]);

    // Trục X
    svg.append('g')
        .attr('transform', `translate(0, ${chartHeight - margin.bottom})`)
        .call(d3.axisBottom(xScale))
        .selectAll('text')
        .attr('transform', 'rotate(-30)')
        .style('text-anchor', 'end')
        .style('font-size', '12px');

    // Trục Y
    svg.append('g')
        .attr('transform', `translate(${margin.left}, 0)`)
        .call(d3.axisLeft(yScale))
        .style('font-size', '12px');

    // Tiêu đề biểu đồ
    svg.append('text')
        .attr('x', chartWidth / 2)
        .attr('y', margin.top / 2)
        .attr('text-anchor', 'middle')
        .style('font-size', '20px')
        .style('font-weight', 'bold')
        .text('Top Selling Books');

    // Thanh biểu đồ
    const bars = svg.selectAll('.bar')
        .data(topSellingBooks)
        .enter()
        .append('rect')
        .attr('class', 'bar')
        .attr('x', book => xScale(book.title))
        .attr('y', book => yScale(book.total_sold))
        .attr('width', xScale.bandwidth())
        .attr('height', book => chartHeight - margin.bottom - yScale(book.total_sold))
        .attr('fill', '#D87D4A')
        .style('cursor', 'pointer');

    // Hiệu ứng hover
    bars.on('mouseover', function (event, d) {
        d3.select(this)
            .attr('fill', '#D87D4A');
        tooltip.style('opacity', 1)
            .html(`<strong>${d.title}</strong><br/>Sold: ${d.total_sold}`)
            .style('left', `${event.pageX + 10}px`)
            .style('top', `${event.pageY - 20}px`);
    })
    .on('mouseout', function () {
        d3.select(this)
            .attr('fill', '#D87D4A');
        tooltip.style('opacity', 0);
    });

    // Tooltip
    const tooltip = d3.select('body')
        .append('div')
        .style('position', 'absolute')
        .style('background', '#333')
        .style('color', '#fff')
        .style('padding', '5px 10px')
        .style('border-radius', '4px')
        .style('font-size', '12px')
        .style('opacity', 0);

    // Nhãn giá trị trên thanh
    svg.selectAll('.label')
        .data(topSellingBooks)
        .enter()
        .append('text')
        .attr('x', book => xScale(book.title) + xScale.bandwidth() / 2)
        .attr('y', book => yScale(book.total_sold) - 5)
        .attr('text-anchor', 'middle')
        .style('font-size', '12px')
        .style('fill', '#555')
        .text(book => book.total_sold);
}

</script>
</body>
</html>