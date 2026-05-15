@extends('layouts.app')

@section('title', 'Process Payment')
@section('header', 'Process Payment for Order #' . $order->order_number)

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Order Summary</h5>
            </div>
            <div class="card-body">
                <table class="table">
                    <tr>
                        <th>Order Number:</th>
                        <td>{{ $order->order_number }}</td>
                    </tr>
                    <tr>
                        <th>Total Amount:</th>
                        <td class="h5 text-success">₱{{ number_format($order->total_amount, 2) }}</td>
                    </tr>
                    <tr>
                        <th>Order Date:</th>
                        <td>{{ $order->created_at->format('F j, Y H:i:s') }}</td>
                    </tr>
                </table>
                
                <h6>Items:</h6>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Qty</th>
                                <th>Price</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->orderItems as $item)
                            <tr>
                                <td>{{ $item->riceItem->name }}</td>
                                <td>{{ number_format($item->quantity, 2) }} kg</td>
                                <td>₱{{ number_format($item->price, 2) }}</td>
                                <td>₱{{ number_format($item->subtotal, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Payment Details</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('payments.store', $order) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="amount" class="form-label">Amount Received (₱) *</label>
                        <input type="number" step="0.01" class="form-control @error('amount') is-invalid @enderror" 
                               id="amount" name="amount" value="{{ old('amount', $order->total_amount) }}" 
                               min="{{ $order->total_amount }}" required>
                        <small class="text-muted">Minimum: ₱{{ number_format($order->total_amount, 2) }}</small>
                        @error('amount')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="payment_method" class="form-label">Payment Method *</label>
                        <select class="form-select @error('payment_method') is-invalid @enderror" 
                                id="payment_method" name="payment_method" required>
                            <option value="cash">Cash</option>
                            <option value="credit_card">Credit Card</option>
                            <option value="bank_transfer">Bank Transfer</option>
                        </select>
                        @error('payment_method')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div id="change-display" class="alert alert-info d-none"></div>
                    
                    <button type="submit" class="btn btn-success w-100">
                        <i class="fas fa-check-circle"></i> Process Payment
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let totalAmount = {{ $order->total_amount }};
    let amountInput = document.getElementById('amount');
    let changeDisplay = document.getElementById('change-display');
    
    amountInput.addEventListener('input', function() {
        let amount = parseFloat(this.value);
        if(amount > totalAmount) {
            let change = amount - totalAmount;
            changeDisplay.classList.remove('d-none');
            changeDisplay.innerHTML = `<strong>Change:</strong> ₱${change.toFixed(2)}`;
        } else {
            changeDisplay.classList.add('d-none');
        }
    });
</script>
@endpush
@endsection