document.addEventListener("DOMContentLoaded", function () {
    const searchOptElement = document.getElementById("search-options");
    const searchInput = document.getElementById("search-input");
    const searchBtn = document.getElementById("search-btn");

    function performSearch() {
        const searchTerm = searchInput.value.toLowerCase();
        const searchOption = searchOptElement.value;
        const url = `/booknest_website/bookController/showSearch?q=${searchTerm}&searchOpt=${searchOption}`;
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
