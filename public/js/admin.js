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
      window.location.href = `/booknest_website/adminController/deleteUserAdmin?user_id=${userId}`;
  }
}

// ------------------------------
// Product Management
// const editmodal = document.querySelector('#form-edit-bookInfo');
// const addmodal = document.querySelector('#form-add-bookInfo');

// const editbookButtons = document.querySelectorAll('.btn-edit-product');
// const addbookButtons = document.querySelectorAll('.btn-add-product');

// const cancelEditButton = document.querySelector('.btn-cancel-editproduct');
// const cancelAddButton = document.querySelector('.btn-cancel-addproduct');

// editbookButtons.forEach((button) => {
//   button.addEventListener('click', () => {
//     editmodal.classList.add('visible');
//   });
// });

// addbookButtons.forEach((button) => {
//     button.addEventListener('click', () => {
//       addmodal.classList.add('visible');
//     });
//   });

// cancelEditButton.addEventListener('click', () => {
//   editmodal.classList.remove('visible');
// });

// cancelAddButton.addEventListener('click', () => {
//     addmodal.classList.remove('visible'); 
//   });
  
// editmodal.addEventListener('click', (event) => {
//   if (event.target === editmodal) {
//     editmodal.classList.remove('visible');
//   }
// });

// addmodal.addEventListener('click', (event) => {
//     if (event.target === addmodal) {
//       addmodal.classList.remove('visible');
//     }
//   });

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
      window.location.href = `/booknest_website/adminController/deleteBookAdmin?book_id=${book_id}`;
  }
}

