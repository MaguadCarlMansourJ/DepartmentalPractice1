@extends('layouts.app')

@section('title', 'Order Details')
@section('header', 'Order Details')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card mb-3">
            <div class="card-header">
                <h5>Order #{{ $order->order_number }}</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Customer:</strong> {{ $order->user->name }}<br>
                        <strong>Date:</strong> {{ $order->created_at->format('F j, Y H:i:s') }}<br>
                        <strong>Status:</strong> 
                        <span class="badge bg-{{ $order->status == 'completed' ? 'success' : 'warning' }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                    <div class="col-md-6">
                        <strong>Payment Status:</strong><br>
                        @if($order->payment && $order->payment->status == 'paid')
                            <span class="badge bg-success">Paid</span><br>
                            <strong>Payment Date:</strong> {{ $order->payment->payment_date->format('Y-m-d H:i:s') }}
                        @else
                            <span class="badge bg-danger">Unpaid</span>
                        @endif
                    </div>
                </div>
                
                <h6>Order Items</h6>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Rice Product</th>
                                <th>Quantity (kg)</th>
                                <th>Price/kg</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->orderItems as $item)
                            <tr>
                                <td>{{ $item->riceItem->name }}</td>
                                <td>{{ number_format($item->quantity, 2) }}</td>
                                <td>₱{{ number_format($item->price, 2) }}</td>
                                <td>₱{{ number_format($item->subtotal, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="table-active">
                                <th colspan="3" class="text-end">Total Amount:</th>
                                <th>₱{{ number_format($order->total_amount, 2) }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        @if(!$order->payment || $order->payment->status != 'paid')
            <div class="card bg-warning">
                <div class="card-body text-center">
                    <h5>Pending Payment</h5>
                    <p>Amount Due: ₱{{ number_format($order->total_amount, 2) }}</p>
                    <a href="{{ route('payments.create', $order) }}" class="btn btn-success">
                        <i class="fas fa-credit-card"></i> Process Payment
                    </a>
                </div>
            </div>
        @else
            <div class="card bg-success text-white">
                <div class="card-body text-center">
                    <i class="fas fa-check-circle fa-3x mb-2"></i>
                    <h5>Payment Completed</h5>
                    <p>Paid: ₱{{ number_format($order->payment->amount, 2) }}</p>
                    <a href="{{ route('payments.receipt', $order->payment) }}" class="btn btn-light">
                        <i class="fas fa-print"></i> View Receipt
                    </a>
                </div>
            </div>
        @endif
        
        @if($order->status == 'pending')
            <div class="card mt-3">
                <div class="card-body text-center">
                    <form action="{{ route('orders.destroy', $order) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Cancel this order?')">
                            <i class="fas fa-times"></i> Cancel Order
                        </button>
                    </form>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection