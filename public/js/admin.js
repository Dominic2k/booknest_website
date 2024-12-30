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
const modal = document.querySelector('#form-edit-userInfo');
const editButtons = document.querySelectorAll('.edit-btn');
const cancelButton = document.querySelector('.cancel-btn');

editButtons.forEach((button) => {
  button.addEventListener('click', () => {
    modal.classList.add('visible'); 
  });
});

cancelButton.addEventListener('click', () => {
  modal.classList.remove('visible'); 
});

modal.addEventListener('click', (event) => {
  if (event.target === modal) {
    modal.classList.remove('visible');
  }
});

// Product Management
const editmodal = document.querySelector('#form-edit-bookInfo');
const addmodal = document.querySelector('#form-add-bookInfo');

const editbookButtons = document.querySelectorAll('.btn-edit-product');
const addbookButtons = document.querySelectorAll('.btn-add-product');

const cancelEditButton = document.querySelector('.btn-cancel-editproduct');
const cancelAddButton = document.querySelector('.btn-cancel-addproduct');

editbookButtons.forEach((button) => {
  button.addEventListener('click', () => {
    editmodal.classList.add('visible');
  });
});

addbookButtons.forEach((button) => {
    button.addEventListener('click', () => {
      addmodal.classList.add('visible');
    });
  });

cancelEditButton.addEventListener('click', () => {
  editmodal.classList.remove('visible');
});

cancelAddButton.addEventListener('click', () => {
    addmodal.classList.remove('visible'); 
  });
  
editmodal.addEventListener('click', (event) => {
  if (event.target === editmodal) {
    editmodal.classList.remove('visible');
  }
});

addmodal.addEventListener('click', (event) => {
    if (event.target === addmodal) {
      addmodal.classList.remove('visible');
    }
  });