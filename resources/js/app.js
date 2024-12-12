import './bootstrap';

import axios from 'axios';

document.addEventListener('DOMContentLoaded', () => {
    const removeButtons = document.querySelectorAll('.remove-wishlist-item');

    removeButtons.forEach(form => {
        form.addEventListener('submit', function (event) {
            event.preventDefault();
            const url = this.action;

            const csrfToken = this.querySelector('input[name="_token"]').value;

            axios.delete(url, {
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then(response => {
                this.closest('.col-md-4').remove();

                const productsContainer = document.querySelector('.row');
                if (!productsContainer.children.length) {
                    document.querySelector('.container.py-4').innerHTML = `
                        <div class="text-center">
                            <p class="text-muted">Your wishlist is empty.</p>
                            <a href="{{ route('products.index') }}" class="btn btn-primary">
                                Browse Products
                            </a>
                        </div>
                    `;
                }
            })
            .catch(error => {
                console.error('Error removing item:', error);
                alert('Could not remove item. Please try again.');
            });
        });
    });
});