@extends('layouts.app')

@section('title', 'Create New Order')

@section('content')
<h1>Create New Order</h1>

<form action="{{ route('orders.store') }}" method="POST" id="order-form">
    @csrf

    <div class="row mb-4">
        <div class="col-md-4">
            <label for="customer_id" class="form-label">Customer</label>
            <select class="form-select @error('customer_id') is-invalid @enderror" id="customer_id" name="customer_id" required>
                <option value="">Select a Customer</option>
                @foreach($customers as $customer)
                    <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                        {{ $customer->name }}
                    </option>
                @endforeach
            </select>
            @error('customer_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-4">
            <label for="order_date" class="form-label">Order Date</label>
            <input type="date" class="form-control @error('order_date') is-invalid @enderror" id="order_date" name="order_date" value="{{ old('order_date', now()->format('Y-m-d')) }}" required>
            @error('order_date')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-4">
            <label for="status" class="form-label">Status</label>
            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                <option value="pending" {{ old('status', 'pending') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="processing" {{ old('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                <option value="shipped" {{ old('status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
                <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
            </select>
            @error('status')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <h4 class="mb-3">Order Items</h4>
    <div id="order-items" class="mb-3">
        <!-- Initial item row -->
        <div class="row item-row align-items-center mb-2">
            <div class="col-md-5">
                <select class="form-select product-select" name="products[0][id]" required>
                    <option value="">Select Product</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" data-stock="{{ $product->quantity_in_stock }}" data-price="{{ $product->selling_price }}">{{ $product->name }} (Stock: {{ $product->quantity_in_stock }})</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <input type="number" class="form-control quantity-input" name="products[0][quantity]" placeholder="Quantity" min="1" required>
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control item-total" placeholder="Item Total" readonly>
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-danger btn-sm remove-item">X</button>
            </div>
        </div>
    </div>

    <button type="button" id="add-item" class="btn btn-secondary mb-4">Add Another Item</button>

    <hr>
    <h3>Total Amount: $<span id="total-amount">0.00</span></h3>
    <input type="hidden" name="total_amount" id="total-amount-input" value="0">

    <div class="mb-3">
        <a href="{{ route('orders.index') }}" class="btn btn-secondary">Cancel</a>
        <button type="submit" class="btn btn-primary">Create Order</button>
    </div>
</form>
@endsection

@push('scripts')
<script>
    let itemCount = 1; // Start from 1 since we have one initial row

    document.getElementById('add-item').addEventListener('click', function () {
        const container = document.getElementById('order-items');
        const productOptions = document.querySelector('.product-select').innerHTML;

        const newRow = document.createElement('div');
        newRow.className = 'row item-row align-items-center mb-2';
        newRow.innerHTML = `
            <div class="col-md-5">
                <select class="form-select product-select" name="products[${itemCount}][id]" required>
                    ${productOptions}
                </select>
            </div>
            <div class="col-md-3">
                <input type="number" class="form-control quantity-input" name="products[${itemCount}][quantity]" placeholder="Quantity" min="1" required>
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control item-total" placeholder="Item Total" readonly>
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-danger btn-sm remove-item">X</button>
            </div>
        `;
        container.appendChild(newRow);
        itemCount++;
    });

    document.getElementById('order-items').addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-item')) {
            e.target.closest('.item-row').remove();
            calculateTotal();
        }
    });

    document.getElementById('order-items').addEventListener('change', function(e) {
        if (e.target.classList.contains('product-select') || e.target.classList.contains('quantity-input')) {
            const row = e.target.closest('.item-row');
            const productSelect = row.querySelector('.product-select');
            const quantityInput = row.querySelector('.quantity-input');
            const itemTotalInput = row.querySelector('.item-total');

            if (productSelect.value && quantityInput.value) {
                const price = parseFloat(productSelect.options[productSelect.selectedIndex].dataset.price);
                const quantity = parseInt(quantityInput.value);
                itemTotalInput.value = (price * quantity).toFixed(2);
            } else {
                itemTotalInput.value = '';
            }
            calculateTotal();
        }
    });

    function calculateTotal() {
        let total = 0;
        document.querySelectorAll('.item-total').forEach(input => {
            if (input.value) {
                total += parseFloat(input.value);
            }
        });
        document.getElementById('total-amount').textContent = total.toFixed(2);
        document.getElementById('total-amount-input').value = total.toFixed(2);
    }
</script>
@endpush