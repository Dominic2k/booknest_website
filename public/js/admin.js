document.getElementById("homeBtn").addEventListener("click", function () {
    document.getElementById("dashboard").style.display = "block";
    document.getElementById("order-list").style.display = "none";
    document.getElementById("customer-list").style.display = "none";
    document.getElementById("product-list").style.display = "none";
});
document.getElementById("orderListBtn").addEventListener("click", function () {
    document.getElementById("dashboard").style.display = "none";
    document.getElementById("order-list").style.display = "block";
    document.getElementById("customer-list").style.display = "none";
    document.getElementById("product-list").style.display = "none";
});
document.getElementById("customerListBtn").addEventListener("click", function () {
    document.getElementById("dashboard").style.display = "none";
    document.getElementById("order-list").style.display = "none";
    document.getElementById("customer-list").style.display = "block";
    document.getElementById("product-list").style.display = "none";
});
document.getElementById("productListBtn").addEventListener("click", function () {
    document.getElementById("dashboard").style.display = "none";
    document.getElementById("order-list").style.display = "none";
    document.getElementById("customer-list").style.display = "none";
    document.getElementById("product-list").style.display = "block";
});

const menuItems = document.querySelectorAll('.sidebar .menu ul li a');
menuItems.forEach(item => {
    item.addEventListener('click', () => {
        menuItems.forEach(i => i.parentElement.classList.remove('active'));
        item.parentElement.classList.add('active');
    });
});

// User management
// -----------------------------
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

const modal = document.querySelector('#form-edit-userInfo');
modal.addEventListener('click', (event) => {
  if (event.target === modal) {
    modal.classList.remove('show');
  }
});

function deleteUser(userId) {
  if (confirm(`Bạn có chắc chắn muốn xóa người dùng với ID: ${userId}?`)) {
      window.location.href = `/booknest_website/AdminController/deleteUserAdmin?user_id=${userId}`;
  }
}
// EDIT BOOK
function openEditBookModal(book) {
  console.log(book);
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

// Model


function openModal(element) {
    const orderId = element.getAttribute('data-order-id'); // Lấy giá trị order_id
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


// Function to close the modal
function closeModal() {
    const modal = document.getElementById('orderDetailModal');
    modal.style.display = 'none';
}

// Close modal when clicking outside of it
window.onclick = function(event) {
    const modal = document.getElementById('orderDetailModal');
    if (event.target === modal) {
        modal.style.display = 'none';
    }
};

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

