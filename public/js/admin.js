document.getElementById("homeBtn").addEventListener("click", function () {
    window.location.assign("/booknest_website/adminController/loadDashboard")
});
document.getElementById("orderListBtn").addEventListener("click", function () {
    window.location.assign("/booknest_website/adminController/loadOrders")
});
document.getElementById("customerListBtn").addEventListener("click", function () {
    window.location.assign("/booknest_website/adminController/loadCustomers")
});
document.getElementById("productListBtn").addEventListener("click", function () {
    window.location.assign("/booknest_website/adminController/loadBooks")
});
