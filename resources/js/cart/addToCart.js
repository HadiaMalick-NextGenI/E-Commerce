import axios from "axios";

import { showToast } from '../utils/toast.js'; 

document.addEventListener('DOMContentLoaded',() => {
    const cartButtons = document.querySelectorAll('.add-to-cart');

    cartButtons.forEach(form => {
        form.addEventListener('submit', function (event) {
            event.preventDefault();

            const url = this.action;

            const csrfToken = this.querySelector('input[name="_token"]').value;

            axios.post(url, {
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            }).then(response => {
                if (response.data.success) {
                    showToast(response.data.message);
                    console.log(response.data);
                } else {
                    showToast("Something went wrong: " + response.data.message);
                }
            }).catch(error => {
                if (error.response) {
                    showToast(error.response.data.message || "Failed to add product to cart.");
                    console.error("Error:", error.response.data);
                } else {
                    showToast("An unexpected error occurred.");
                    console.error("Error:", error.message);
                }
            });
        })
    });
});