import axios from 'axios';

import { showToast } from '../utils/toast.js'; 

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
                
                showToast(response.data.message);
            })
            .catch(error => {
                console.error('Error removing item:', error);
                showToast('Could not remove item. Please try again.');
            });
        });
    });
});

document.addEventListener('DOMContentLoaded', () => {
    const submitButtons = document.querySelectorAll('.wishlist-form');

    submitButtons.forEach(form => {
        form.addEventListener('submit', function (event) {
            event.preventDefault();

            const url = this.action;

            const csrfToken = this.querySelector('input[name="_token"]').value;

            axios.post(url, {
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            }).then(response => {
                const heartIcon = this.querySelector('i');
        
                if(response.data.isInWishlist){
                    heartIcon.classList.remove('far');
                    heartIcon.classList.add('fas');
                } else {
                    heartIcon.classList.remove('fas'); 
                    heartIcon.classList.add('far');
                }

                showToast(response.data.message);
            })
            .catch(error => {
                console.error('Error updating wishlist:', error);

                showToast('Could not update wishlist. Please try again.');
            });
        });
    });
});