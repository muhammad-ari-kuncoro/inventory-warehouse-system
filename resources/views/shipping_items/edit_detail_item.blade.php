@extends('layouts.dashboard-layout')
@section('container')
    <div class="card">
        <h5 class="card-header text-center">

        </h5>
        <div class="card-body">
            <form action="{{ route('shipping-items.item.ship.update', $find_id->id) }}" method="post">
                @csrf
                @method('patch')
                <div class="mb-3">
                    <label for="item_names" class="form-label">Name Item</label>
                    <input class="form-control rounded-top @error('item_names') is-invalid @enderror" type="text"
                        name="item_names" placeholder="Please Insert this field ..."
                        value="{{ old('item_names', $find_id->item_names) }}">
                    @error('item_names')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="quantity" class="form-label">Quantity</label>
                    <input class="form-control rounded-top @error('quantity') is-invalid @enderror" type="number"
                        min="1" name="quantity" placeholder="Please Insert this field ..."
                        value="{{ old('quantity', $find_id->quantity) }}">
                    @error('quantity')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>


                <div class="mb-3">
                    <label class="form-label">Type</label>
                    <select class="form-select select-2 @error('quantity_type') is-invalid @enderror" name="quantity_type"
                        data-placeholder="Choose">
                        <option value="" disabled
                            {{ old('quantity_type'), $find_id->quantity_type === null ? 'selected' : '' }}>Pilih salah satu
                        </option>
                        <option value="Pcs"
                            {{ old('quantity_type', $find_id->quantity_type) == 'Pcs' ? 'selected' : '' }}>Pcs</option>
                        <option value="Unit"
                            {{ old('quantity_type', $find_id->quantity_type) == 'Unit' ? 'selected' : '' }}>Unit</option>
                        <option value="Set"
                            {{ old('quantity_type', $find_id->quantity_type) == 'Set' ? 'selected' : '' }}>Set</option>
                        <option value="Kg"
                            {{ old('quantity_type', $find_id->quantity_type) == 'Kg' ? 'selected' : '' }}>Kg</option>
                        <option value="Lembar"
                            {{ old('quantity_type', $find_id->quantity_type) == 'Lembar' ? 'selected' : '' }}>Lembar
                        </option>
                        <option value="EA"
                            {{ old('quantity_type', $find_id->quantity_type) == 'EA' ? 'selected' : '' }}>EA</option>
                        <option value="Liter"
                            {{ old('quantity_type', $find_id->quantity_type) == 'Liter' ? 'selected' : '' }}>Liter</option>
                        <option value="Drum"
                            {{ old('quantity_type', $find_id->quantity_type) == 'Drum' ? 'selected' : '' }}>Drum</option>
                        <option value="MTR"
                            {{ old('quantity_type', $find_id->quantity_type) == 'MTR' ? 'selected' : '' }}>MTR</option>
                        <option value="BOX"
                            {{ old('quantity_type', $find_id->quantity_type) == 'BOX' ? 'selected' : '' }}>BOX</option>
                    </select>
                    @error('quantity_type')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="description_items" class="form-label">Description Items</label>
                    <textarea class="form-control rounded-top @error('description_items') is-invalid @enderror" name="description_items"
                        id="description_items" rows="4"
                        placeholder="Please Insert this field">{{ old('description_items', $find_id->description_items) }}</textarea>

                    @error('description_items')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="row mb-3">
                    <div class="col sm-4">
                        <a href="{{ route('delivery-order.edit', $find_id->id) }}" class="btn btn-secondary">Go Back</a>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>

                </div>
            </form>

        </div>
    </div>
@endsection
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const preloader = document.getElementById('preloader');
        if (preloader) {
            console.log('Preloader found. It will hide after 3 seconds...');
            setTimeout(function() {
                preloader.style.display = 'none';
                console.log('Preloader hidden.');
            }, 1500);
        } else {
            console.error('Preloader element not found!');
        }
    });
</script>
