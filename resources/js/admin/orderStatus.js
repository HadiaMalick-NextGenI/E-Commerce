import axios from 'axios';

document.addEventListener('DOMContentLoaded', () => {
    
    document.querySelectorAll('.status-update-btn').forEach(button => {
        button.addEventListener('click', async (event) => {
            const orderId = button.getAttribute('data-order-id');
            const form = document.querySelector(`#status-form-${orderId}`);
            const statusSelect = form.querySelector(`#status-select-${orderId}`);
            const status = statusSelect.value;
            
            try {
                const response = await axios.patch(`/admin/orders/${orderId}/status`, {
                    status: status,
                    _token: form.querySelector('input[name="_token"]').value
                });
            
                if (response.status === 200) {
                    alert('Order status updated successfully!');
                } else {
                    alert('Failed to update order status.');
                }
            } catch (error) {
                console.error('Error updating status:', error);
                alert('An error occurred while updating the status.');
            }            
        });
    });
});