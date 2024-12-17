import axios from "axios";
import { showToast } from '../utils/toast.js';

document.addEventListener('DOMContentLoaded', () => {
    const removeButtons = document.querySelectorAll('[id^="remove-btn-"]');
    
    removeButtons.forEach(button => {
        button.addEventListener('click', (event) => {
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
                document.querySelector(`#remove-cart-item-${itemId}`).closest('tr').remove();
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