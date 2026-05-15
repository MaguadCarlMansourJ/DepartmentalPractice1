@extends('layouts.app')

@section('title', 'Create Order')
@section('header', 'Create New Order')

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h5>Select Rice Products</h5>
                <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Select</th>
                                <th>Rice</th>
                                <th>Price/kg</th>
                                <th>Available</th>
                                <th>Quantity (kg)</th>
                            </tr>
                        </thead>
                        <tbody id="rice-items-list">
                            @foreach($riceItems as $item)
                            <tr>
                                <td>
                                    <input type="checkbox" class="rice-checkbox" data-id="{{ $item->id }}" 
                                           data-name="{{ $item->name }}" data-price="{{ $item->price_per_kg }}" 
                                           data-max="{{ $item->stock_quantity }}">
                                </td>
                                <td>{{ $item->name }}</td>
                                <td>₱{{ number_format($item->price_per_kg, 2) }}</td>
                                <td>{{ number_format($item->stock_quantity, 2) }} kg</td>
                                <td>
                                    <input type="number" class="form-control form-control-sm quantity-input" 
                                           data-id="{{ $item->id }}" disabled step="0.1" min="0.1">
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-6">
                <h5>Order Summary</h5>
                <div class="table-responsive">
                    <table class="table table-sm" id="order-summary">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Qty (kg)</th>
                                <th>Price</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody id="summary-items">
                            <tr>
                                <td colspan="4" class="text-center">No items selected</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr class="table-active">
                                <th colspan="3">Total Amount:</th>
                                <th id="total-amount">₱0.00</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <button type="button" id="submit-order" class="btn btn-success w-100">
                    <i class="fas fa-check"></i> Place Order
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    let selectedItems = [];
    
    $('.rice-checkbox').change(function() {
        let id = $(this).data('id');
        let quantityInput = $(`.quantity-input[data-id="${id}"]`);
        
        if($(this).is(':checked')) {
            quantityInput.prop('disabled', false);
            quantityInput.val(0.1);
            addToSummary(id);
        } else {
            quantityInput.prop('disabled', true);
            quantityInput.val('');
            removeFromSummary(id);
        }
    });
    
    $('.quantity-input').on('input', function() {
        let id = $(this).data('id');
        let max = $(`.rice-checkbox[data-id="${id}"]`).data('max');
        let value = parseFloat($(this).val());
        
        if(value > max) {
            alert(`Maximum available stock is ${max} kg`);
            $(this).val(max);
            value = max;
        }
        if(value < 0.1) {
            $(this).val(0.1);
            value = 0.1;
        }
        
        updateSummary(id, value);
    });
    
    function addToSummary(id) {
        let name = $(`.rice-checkbox[data-id="${id}"]`).data('name');
        let price = $(`.rice-checkbox[data-id="${id}"]`).data('price');
        selectedItems.push({id, name, price, quantity: 0.1});
        updateSummaryTable();
    }
    
    function removeFromSummary(id) {
        selectedItems = selectedItems.filter(item => item.id != id);
        updateSummaryTable();
    }
    
    function updateSummary(id, quantity) {
        let item = selectedItems.find(i => i.id == id);
        if(item) {
            item.quantity = quantity;
            updateSummaryTable();
        }
    }
    
    function updateSummaryTable() {
        let tbody = $('#summary-items');
        tbody.empty();
        let total = 0;
        
        if(selectedItems.length === 0) {
            tbody.html('<tr><td colspan="4" class="text-center">No items selected</td></tr>');
            $('#total-amount').text('₱0.00');
            return;
        }
        
        selectedItems.forEach(item => {
            let subtotal = item.price * item.quantity;
            total += subtotal;
            tbody.append(`
                <tr>
                    <td>${item.name}</td>
                    <td>${item.quantity.toFixed(2)} kg</td>
                    <td>₱${item.price.toFixed(2)}</td>
                    <td>₱${subtotal.toFixed(2)}</td>
                </tr>
            `);
        });
        
        $('#total-amount').text(`₱${total.toFixed(2)}`);
    }
    
    $('#submit-order').click(function() {
        if(selectedItems.length === 0) {
            alert('Please select at least one rice item');
            return;
        }
        
        let items = selectedItems.map(item => ({
            rice_item_id: item.id,
            quantity: item.quantity
        }));
        
        $.ajax({
            url: '{{ route("orders.store") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                items: items
            },
            success: function(response) {
                alert(response.message);
                window.location.href = '/orders/' + response.order_id;
            },
            error: function(xhr) {
                alert(xhr.responseJSON?.error || 'Error creating order');
            }
        });
    });
});
</script>
@endpush
@endsection