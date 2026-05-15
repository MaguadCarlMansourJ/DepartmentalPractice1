@extends('layouts.app')

@section('title', 'Rice Products')
@section('header', 'Rice Products Management')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">All Rice Products</h5>
        <a href="{{ route('rice-items.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Add New Rice Product
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Rice Name</th>
                        <th>Price/Kg</th>
                        <th>Stock (kg)</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($riceItems as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->name }}</td>
                        <td>₱{{ number_format($item->price_per_kg, 2) }}</td>
                        <td>
                            {{ number_format($item->stock_quantity, 2) }}
                            @if($item->stock_quantity < 50)
                                <span class="badge bg-warning">Low Stock</span>
                            @endif
                        </td>
                        <td>{{ Str::limit($item->description, 50) }}</td>
                        <td>
                            <a href="{{ route('rice-items.edit', $item) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('rice-items.destroy', $item) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $riceItems->links() }}
    </div>
</div>
@endsection