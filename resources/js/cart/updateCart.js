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
            const productPrice = parseFloat(document.querySelector(`#product-price-${itemId}`).dataset.price);

            const newQuantity = currentQuantity + 1;
            quantityInput.value = newQuantity;

            updateTotalPrice(itemId, productPrice, newQuantity);
            updateOrderSummary();
            updateCartQuantity(itemId, newQuantity);
        });
    });

    decreaseButtons.forEach(button => {
        button.addEventListener('click', function () {
            const itemId = this.id.split('-')[1];
            const quantityInput = document.querySelector(`#quantity-${itemId}`);
            const currentQuantity = parseInt(quantityInput.value);
            const productPrice = parseFloat(document.querySelector(`#product-price-${itemId}`).dataset.price);

            if (currentQuantity > 1) {
                const newQuantity = currentQuantity - 1;
                quantityInput.value = newQuantity;

                updateTotalPrice(itemId, productPrice, newQuantity);
                updateOrderSummary();
                updateCartQuantity(itemId, newQuantity);
            } else {
                showToast("Quantity cannot be less than 1.");
            }
        });
    });

    function updateTotalPrice(itemId, productPrice, quantity) {
        const totalPriceElement = document.querySelector(`#total-price-${itemId}`);
        const newTotalPrice = (productPrice * quantity).toFixed(2);

        totalPriceElement.innerText = `PKR ${newTotalPrice}`;
    }

    function updateOrderSummary() {
        let subtotal = 0;
        const taxRate = 0.05;

        document.querySelectorAll('[id^="total-price-"]').forEach(item => {
            const totalPrice = parseFloat(item.innerText.replace('PKR', '').trim());
            subtotal += totalPrice;
        });

        const taxAmount = (subtotal * taxRate).toFixed(2);
        const grandTotal = (subtotal + parseFloat(taxAmount)).toFixed(2);

        document.querySelector('#subtotal').innerText = `PKR ${subtotal.toFixed(2)}`;
        document.querySelector('#tax').innerText = `PKR ${taxAmount}`;
        document.querySelector('#grand-total').innerText = `PKR ${grandTotal}`;
    }

    function updateCartQuantity(itemId, newQuantity) {
        const url = `/cart/${itemId}`;

        axios.put(url, { quantity: newQuantity })
            .then(response => {
                if (response.data.success) {
                    showToast(response.data.message);
                } else {
                    showToast("Something went wrong: " + response.data.message);
                }
            })
            .catch(error => {
                showToast("Unexpected error occurred.");
                console.error("Error:", error);
            });
    }
});