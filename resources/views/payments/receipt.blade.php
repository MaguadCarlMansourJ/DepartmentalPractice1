@extends('layouts.app')

@section('title', 'Payment Receipt')
@section('header', 'Payment Receipt')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header text-center">
                <h4>RICE SHOP MANAGEMENT SYSTEM</h4>
                <p>Official Payment Receipt</p>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <strong>Receipt #:</strong> {{ $payment->id }}<br>
                        <strong>Date:</strong> {{ $payment->payment_date->format('F j, Y H:i:s') }}<br>
                        <strong>Order #:</strong> {{ $payment->order->order_number }}
                    </div>
                    <div class="col-md-6 text-md-end">
                        <strong>Customer:</strong> {{ $payment->order->user->name }}<br>
                        <strong>Payment Method:</strong> {{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}
                    </div>
                </div>
                
                <h6>Order Details:</h6>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Quantity (kg)</th>
                            <th>Price/kg</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($payment->order->orderItems as $item)
                        <tr>
                            <td>{{ $item->riceItem->name }}</td>
                            <td>{{ number_format($item->quantity, 2) }}</td>
                            <td>₱{{ number_format($item->price, 2) }}</td>
                            <td>₱{{ number_format($item->subtotal, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3" class="text-end">Subtotal:</th>
                            <th>₱{{ number_format($payment->order->total_amount, 2) }}</th>
                        </tr>
                        <tr>
                            <th colspan="3" class="text-end">Amount Paid:</th>
                            <th>₱{{ number_format($payment->amount, 2) }}</th>
                        </tr>
                        @if($payment->amount > $payment->order->total_amount)
                        <tr class="table-info">
                            <th colspan="3" class="text-end">Change:</th>
                            <th>₱{{ number_format($payment->amount - $payment->order->total_amount, 2) }}</th>
                        </tr>
                        @endif
                        <tr class="table-success">
                            <th colspan="3" class="text-end">Payment Status:</th>
                            <th>
                                <span class="badge bg-success">PAID</span>
                            </th>
                        </tr>
                    </tfoot>
                </table>
                
                <div class="text-center mt-4">
                    <p class="text-muted">Thank you for your purchase!</p>
                    <button onclick="window.print()" class="btn btn-primary">
                        <i class="fas fa-print"></i> Print Receipt
                    </button>
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                        <i class="fas fa-home"></i> Back to Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection