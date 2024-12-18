<form id="status-form-{{ $order->id }}" data-order-id="{{ $order->id }}">
    @csrf
    @method('PATCH')
    <div class="d-flex align-items-center">
        <select name="status" class="form-select stylish-dropdown" id="status-select-{{ $order->id }}">
            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>🕒 Pending</option>
            <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>📦 Shipped</option>
            <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>✅ Delivered</option>
            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>❌ Cancelled</option>
        </select>
        <button type="button" class="btn btn-outline-primary ml-2 status-update-btn" data-order-id="{{ $order->id }}">Update</button>
    </div>
</form>