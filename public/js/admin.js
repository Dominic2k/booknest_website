document.getElementById("homeBtn").addEventListener("click", function () {
    document.getElementById("dashboard").style.display = "block";
    document.getElementById("order-list").style.display = "none";
});
document.getElementById("orderListBtn").addEventListener("click", function () {
    document.getElementById("dashboard").style.display = "none";
    document.getElementById("order-list").style.display = "block";
});

const menuItems = document.querySelectorAll('.sidebar .menu ul li a');
menuItems.forEach(item => {
    item.addEventListener('click', () => {
        menuItems.forEach(i => i.parentElement.classList.remove('active'));
        item.parentElement.classList.add('active');
    });
});
