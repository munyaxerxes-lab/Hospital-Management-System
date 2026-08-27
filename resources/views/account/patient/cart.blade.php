@extends('layout.index')
@section('content')

  @if(session('success'))
    <div style="background:#ecfdf5;border:1px solid #a7f3d0;color:#065f46;padding:14px 18px;border-radius:10px;margin-bottom:20px;display:flex;align-items:center;gap:10px;font-weight:600;">
        <i class="fa-solid fa-circle-check" style="color:#059669;font-size:18px;"></i>
        <span>{{ session('success') }}</span>
    </div>
  @endif

  @if(session('error'))
    <div style="background:#fef2f2;border:1px solid #fecaca;color:#991b1b;padding:14px 18px;border-radius:10px;margin-bottom:20px;display:flex;align-items:center;gap:10px;font-weight:600;">
        <i class="fa-solid fa-triangle-exclamation" style="color:#dc2626;font-size:18px;"></i>
        <span>{{ session('error') }}</span>
    </div>
  @endif

  <div class="cart-section">
      <div class="cart-section-table">
        <h2>My Cart</h2>
        <table>
          <thead><tr>
                      <th>Product</th>
                      <th>Price</th>
                      <th>Quantity</th>
                      <th>Total</th>
                      <th>Action</th>
                 </tr>
          </thead>
                 <tbody>
                  @php $totalPrice = 0; $totalQty = 0; @endphp
                  @if(isset($carts) && $carts->count())
                    @foreach($carts as $item)
                      @php
                        $price = $item->medicine->price ?? 0;
                        $lineTotal = $price * $item->quantity;
                        $totalPrice += $lineTotal;
                        $totalQty += $item->quantity;
                      @endphp
                      <tr>
                        <td>
                            <div class="cart-img">
                            <img src="{{ optional($item->medicine)->image_url ?? asset('image/pharma.png') }}" alt="medicine" onerror="this.onerror=null; this.src='{{ asset('image/pharma.png') }}';">
                            <p>{{ $item->medicine->name ?? 'Medicine' }}</p>
                            </div>
                        </td>
                        <td>{{ number_format($price, 2) }} FCFA</td>
                        <td>
                            <form action="{{ route('cart.update', $item->id) }}" method="POST">
                              @csrf
                              @method('PUT')
                              <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->medicine->stock ?? 999 }}" style="width:60px" />
                              <button type="submit">Update</button>
                            </form>
                        </td>
                        <td>{{ number_format($lineTotal, 2) }} FCFA</td>
                        <td>
                          <form action="{{ route('cart.destroy', $item->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Remove</button>
                          </form>
                        </td>
                      </tr>
                    @endforeach
                  @else
                    <tr><td colspan="5" style="text-align:center;padding:30px;color:#64748b;">Your cart is empty. <a href="/pharmacy" style="color:#2563eb;font-weight:600;text-decoration:underline;">Browse Pharmacy</a></td></tr>
                  @endif
                 </tbody>
        </table>
      </div>
  </div>

   <div class="totals">
    <table>
         <tbody>
             <tr>
              <td>Total Quantity</td>
              <td>{{ $totalQty ?? 0 }} Items</td>
             </tr>

             <tr>
               <td>Total Price</td>
               <td><span class="green1">{{ number_format($totalPrice, 2) }} FCFA</span></td>
             </tr>
          </tbody>  
    
    </table>             
  </div> 

  @if(isset($carts) && $carts->count() > 0)
    <form action="{{ route('cart.checkout') }}" method="POST" style="margin-top: 20px;">
        @csrf
        <button type="submit" class="checkout-btn" style="cursor:pointer;">
            <i class="fa-solid fa-credit-card"></i>
            Proceed to Checkout ({{ number_format($totalPrice, 2) }} FCFA)
        </button>
    </form>
  @else
    <button class="checkout-btn" style="opacity:0.5;cursor:not-allowed;" disabled>
        <i class="fa-solid fa-credit-card"></i>
        Checkout (Cart Empty)
    </button>
  @endif

@endsection