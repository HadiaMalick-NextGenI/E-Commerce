import axios from "axios";

document.addEventListener('DOMContentLoaded', function () {
    const filterForm = document.getElementById('filter-form');
    const productsContainer = document.getElementById('products-container'); 
    const searchInput = document.getElementById('search');
    const categorySelect = document.getElementById('category');
    const brandSelect = document.getElementById('brand');
    const clearFiltersBtn = document.getElementById('clear-filters');
    const applyFiltersBtn = document.getElementById('apply-filters');
    const searchBtn = document.getElementById('search-btn');

    function fetchProducts(params = {}) {
        axios.get('/products', { params })
            .then(response => {
                productsContainer.innerHTML = response.data.html;
            })
            .catch(error => {
                console.error('Error fetching products:', error);
            });
    }

    applyFiltersBtn.addEventListener('click', () => {
        const params = {
            search: searchInput.value,
            category: categorySelect.value,
            brand: brandSelect.value,
        };
        fetchProducts(params);
    });

    clearFiltersBtn.addEventListener('click', () => {
        searchInput.value = '';
        categorySelect.value = '';
        brandSelect.value = '';
        fetchProducts();
    });

    searchBtn.addEventListener('click', () => {
        fetchProducts({ search: searchInput.value });
    });
});