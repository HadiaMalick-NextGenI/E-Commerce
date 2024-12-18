<table class="table table-bordered">
    <thead>
        <tr>
            <th>Order ID</th>
            <th>Reference ID</th>
            <th>User</th>
            <th>Total Amount</th>
            <th>Status</th>
            <th>Order Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->reference_id }}</td>
                <td>{{ $order->user->name }}</td>
                <td>{{ $order->total_amount }}</td>
                <td>
                    @include('partials.status_form', ['order' => $order])
                </td>
                <td>{{ $order->order_date }}</td>
                <td>
                    <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-info btn-sm">Details</a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center">No orders found.</td>
            </tr>
        @endforelse
    </tbody>
</table>