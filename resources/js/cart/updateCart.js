import axios from "axios";

import { showToast } from '../utils/toast.js'; 

document.addEventListener('DOMContentLoaded', () => {
    const increaseButtons = document.querySelectorAll('[id^="increase-"]');
    const decreaseButtons = document.querySelectorAll('[id^="decrease-"]');

    increaseButtons.forEach(button => {
        button.addEventListener('click', function () {
            const itemId = this.id.split('-')[1]; 
            const quantityInput = document.querySelector(`#quantity-${itemId}`);
            const currentQuantity = parseInt(quantityInput.value);

            const newQuantity = currentQuantity + 1;
            quantityInput.value = newQuantity;  

            updateCartQuantity(itemId, newQuantity);
        });
    });

    decreaseButtons.forEach(button => {
        button.addEventListener('click', function () {
            const itemId = this.id.split('-')[1]; 
            const quantityInput = document.querySelector(`#quantity-${itemId}`);
            const currentQuantity = parseInt(quantityInput.value);

            const newQuantity = currentQuantity - 1;
            quantityInput.value = newQuantity;

            updateCartQuantity(itemId, newQuantity);
        });
    });

    function updateCartQuantity(itemId, newQuantity) {
        const url = `/cart/${itemId}`; 

        axios.put(url, {
            quantity: newQuantity
        }).then(response => {
            if (response.data.success) {
                showToast(response.data.message); 
            } else {
                showToast("Something went wrong: " + response.data.message);
            }
        }).catch(error => {
            showToast("Unexpected error occurred.");
            console.error("Error:", error);
        });
    }
});