import axios from "axios";
import { showToast } from '../utils/toast.js';

document.addEventListener('DOMContentLoaded', () => {
    const removeButtons = document.querySelectorAll('[id^="remove-btn-"]');
    const cartContent = document.getElementById('cart-content');
    const emptyCartMessage = document.getElementById('empty-cart-message');

    const remainingRows = document.querySelectorAll('#cart-content tbody tr').length;
    if (remainingRows === 0) {
        cartContent.style.display = 'none';
        emptyCartMessage.style.display = 'block';
    } else {
        cartContent.style.display = 'block';
        emptyCartMessage.style.display = 'none';
    }

    removeButtons.forEach(button => {
        button.addEventListener('click', () => {
            const itemId = button.id.replace('remove-btn-', '');
            confirmRemove(itemId);
        });
    });
});

function confirmRemove(itemId) {
    if (confirm('Are you sure you want to remove this item?')) {
        const csrfToken = document.querySelector(`#remove-cart-item-${itemId} input[name="_token"]`).value;
        const url = document.querySelector(`#remove-cart-item-${itemId}`).action;

        axios.delete(url, {
            headers: {
                'X-CSRF-TOKEN': csrfToken
            }
        })
        .then(response => {
            if (response.data.success) {
                showToast(response.data.message);

                const row = document.querySelector(`#remove-cart-item-${itemId}`).closest('tr');
                row.remove();

                const remainingRows = document.querySelectorAll('#cart-content tbody tr').length;
               
                if (remainingRows === 0) {
                    document.getElementById('cart-content').style.display = 'none';
                    document.getElementById('empty-cart-message').style.display = 'block';
                }
            } else {
                showToast("Failed to remove item.");
            }
        })
        .catch(error => {
            showToast("Error occurred while removing item.");
            console.error("Error:", error);
        });
    }
}