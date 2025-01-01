document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("search-input");
    const searchBtn = document.getElementById("search-btn");

    function performSearch() {
        const searchTerm = searchInput.value.toLowerCase();
        const url = `/booknest_website/searchController/showSearch?q=${searchTerm}`;
        window.location.replace(url);
    }

    searchBtn.addEventListener("click", function () {
        performSearch();
    });

    searchInput.addEventListener('keypress', function(event) {
        if (event.key === 'Enter') {
            performSearch();
        }
    });
   
});
