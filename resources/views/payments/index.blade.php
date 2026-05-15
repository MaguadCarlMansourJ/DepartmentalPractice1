@extends('layouts.app')

@section('title', 'Payments')
@section('header', 'Payment Management')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Payment History</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Payment ID</th>
                        <th>Order #</th>
                        <th>Amount</th>
                        <th>Method</th>
                        <th>Status</th>
                        <th>Payment Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($payments as $payment)
                    <tr>
                        <td>{{ $payment->id }}</td>
                        <td>{{ $payment->order->order_number }}</td>
                        <td>₱{{ number_format($payment->amount, 2) }}</td>
                        <td>{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</td>
                        <td>
                            <span class="badge bg-{{ $payment->status == 'paid' ? 'success' : 'danger' }}">
                                {{ ucfirst($payment->status) }}
                            </span>
                        </td>
                        <td>{{ $payment->payment_date ? $payment->payment_date->format('Y-m-d H:i:s') : '-' }}</td>
                        <td>
                            <a href="{{ route('payments.receipt', $payment) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-receipt"></i> Receipt
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $payments->links() }}
    </div>
</div>
@endsection