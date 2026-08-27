@extends('layout.index')
@section('content')

<div class="pharmacy-content">
    <div class="pharmacy-header">
        <div>
            <h1 class="pharmacy-title">Available Medicines</h1>
            <p>Select medicine to add to cart.</p>
        </div>
        <div class="medicine-search">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" id="pharmacySearch" placeholder="Search medicines...">
        </div>
    </div>

    <div id="pharmacyMessages"></div>
</div>

<div class="image-section" id="medicineGrid">


    @if(isset($medicines) && $medicines->count())

        @foreach($medicines as $medicine)
            @php
                $imgSrc = '/image/pharma3.png';
                if (!empty($medicine->image)) {
                    if (\Illuminate\Support\Str::startsWith($medicine->image, ['http://', 'https://', 'image/'])) {
                        $imgSrc = asset($medicine->image);
                    } else {
                        $imgSrc = asset('storage/' . $medicine->image);
                    }
                }
            @endphp
            <div class="image card">
                <img src="{{ $imgSrc }}" alt="{{ $medicine->name }}" onerror="this.src='/image/pharma3.png'">
                <div class="text">
                    <h2>{{ $medicine->name }}</h2>
                    <p>{{ \Illuminate\Support\Str::limit($medicine->description, 80) }}</p>
                    <h3><span class="green1">{{ number_format($medicine->price, 2) }} FCFA</span></h3>
                </div>
                <div class="card-footer">
                    <span class="stock-label">Stock: {{ $medicine->stock }}</span>
                    <button class="add-to-cart" data-medicine-id="{{ $medicine->id }}" {{ $medicine->stock <= 0 ? 'disabled' : '' }}>
                        {{ $medicine->stock <= 0 ? 'Out of stock' : 'Add to Cart' }}
                    </button>
                </div>
            </div>
        @endforeach


    @else
        <p>No medicines available.</p>
    @endif
</div>

@endsection

@section('scripts')
<script>
    //=============cross site request forgery==================//
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    function showMessage(message, type = 'success') {
        const messages = document.getElementById('pharmacyMessages');
        messages.innerHTML = `<div class="message ${type}">${message}</div>`;
        setTimeout(() => messages.innerHTML = '', 3000);
    }

    async function addToCart(medicineId) {
        try {
            const response = await fetch(`/cart/add/${medicineId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({})
            });

            if (!response.ok) {
                const payload = await response.json();
                throw new Error(payload.message || 'Could not add to cart');
            }

            const payload = await response.json();
            showMessage(payload.message || 'Added to cart');

            const badge = document.querySelector('.cart-badge');
            if (badge && payload.cartCount !== undefined) {
                badge.textContent = payload.cartCount;
            }
        } catch (error) {
            showMessage(error.message, 'error');
        }
    }

    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', event => {
            event.preventDefault();
            const id = button.dataset.medicineId;
            if (!id) return;
            addToCart(id);
        });
    });

    const searchInput = document.getElementById('pharmacySearch');
    searchInput?.addEventListener('input', event => {
        const query = event.target.value.toLowerCase();
        document.querySelectorAll('#medicineGrid .card').forEach(card => {
            const text = card.textContent.toLowerCase();
            card.style.display = text.includes(query) ? 'block' : 'none';
        });
    });
</script>
@endsection
