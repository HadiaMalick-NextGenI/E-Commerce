import axios from 'axios';

document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.querySelector('input[name="search"]');
    const statusFilter = document.querySelector('select[name="status"]');
    const startDateInput = document.querySelector('input[name="start_date"]');
    const endDateInput = document.querySelector('input[name="end_date"]');
    const ordersTableBody = document.querySelector('tbody');
    const paginationContainer = document.querySelector('#pagination');

    const fetchOrders = async (params = {}) => {
        const queryParams = {
            search: searchInput.value,
            status: statusFilter.value,
            start_date: startDateInput.value,
            end_date: endDateInput.value,
        };

        try {
            const response = await axios.get('/admin/orders', { params: queryParams });
            const { orders, pagination } = response.data;

            renderOrders(orders);
            renderPagination(pagination);
        } catch (error) {
            console.error('Error fetching orders:', error);
        }
    };

    const renderOrders = (orders) => {
        ordersTableBody.innerHTML = '';
        if (orders.length > 0) {
            orders.forEach((order) => {
                const row = `
                    <tr>
                        <td>${order.id}</td>
                        <td>${order.reference_id}</td>
                        <td>${order.user.name}</td>
                        <td>${order.total_amount}</td>
                        <td>
                            <select class="form-select status-dropdown stylish-dropdown" data-order-id="${order.id}">
                                <option value="pending" ${order.status === 'pending' ? 'selected' : ''}>🕒 Pending</option>
                                <option value="shipped" ${order.status === 'shipped' ? 'selected' : ''}>📦 Shipped</option>
                                <option value="delivered" ${order.status === 'delivered' ? 'selected' : ''}>✅ Delivered</option>
                                <option value="cancelled" ${order.status === 'cancelled' ? 'selected' : ''}>❌ Cancelled</option>
                            </select>
                        </td>
                        <td>${order.order_date}</td>
                        <td>
                            <a href="/admin/orders/${order.id}" class="btn btn-info btn-sm">Details</a>
                        </td>
                    </tr>
                `;
                ordersTableBody.innerHTML += row;
            });

            attachStatusUpdateListeners();
        } else {
            ordersTableBody.innerHTML = `<tr><td colspan="7" class="text-center">No orders found.</td></tr>`;
        }
    };

    const renderPagination = (pagination) => {
        paginationContainer.innerHTML = '';
        if (pagination.last_page > 1) {
            for (let page = 1; page <= pagination.last_page; page++) {
                const isActive = page === pagination.current_page ? 'active' : '';
                const pageLink = `
                    <li class="page-item ${isActive}">
                        <button class="page-link" data-page="${page}">${page}</button>
                    </li>
                `;
                paginationContainer.innerHTML += pageLink;
            }
        }
    };

    const attachStatusUpdateListeners = () => {
        document.querySelectorAll('.status-dropdown').forEach((dropdown) => {
            dropdown.addEventListener('change', async (event) => {
                const orderId = dropdown.getAttribute('data-order-id');
                const status = dropdown.value;

                try {
                    const response = await axios.patch(`/admin/orders/${orderId}/status`, {
                        status: status,
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
    };

    searchInput.addEventListener('input', fetchOrders);
    statusFilter.addEventListener('change', fetchOrders);
    startDateInput.addEventListener('change', fetchOrders);
    endDateInput.addEventListener('change', fetchOrders);

    paginationContainer.addEventListener('click', (event) => {
        if (event.target.classList.contains('page-link')) {
            const page = event.target.getAttribute('data-page');
            fetchOrders({ page });
        }
    });

    fetchOrders();
});