@extends('layouts.app')

@section('title', 'Edit Rice Product')
@section('header', 'Edit Rice Product')

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('rice-items.update', $riceItem) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">Rice Name *</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                       id="name" name="name" value="{{ old('name', $riceItem->name) }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="price_per_kg" class="form-label">Price per Kilogram (₱) *</label>
                    <input type="number" step="0.01" class="form-control @error('price_per_kg') is-invalid @enderror" 
                           id="price_per_kg" name="price_per_kg" value="{{ old('price_per_kg', $riceItem->price_per_kg) }}" required>
                    @error('price_per_kg')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="stock_quantity" class="form-label">Stock Quantity (kg) *</label>
                    <input type="number" step="0.01" class="form-control @error('stock_quantity') is-invalid @enderror" 
                           id="stock_quantity" name="stock_quantity" value="{{ old('stock_quantity', $riceItem->stock_quantity) }}" required>
                    @error('stock_quantity')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control @error('description') is-invalid @enderror" 
                          id="description" name="description" rows="3">{{ old('description', $riceItem->description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <button type="submit" class="btn btn-primary">Update Rice Product</button>
            <a href="{{ route('rice-items.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection