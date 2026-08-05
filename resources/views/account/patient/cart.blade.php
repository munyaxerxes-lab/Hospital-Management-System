@extends('layout.index')
@section('content')
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
                            <img src="{{ $item->medicine->image ?? '/image/pharma.png' }}" alt="medicine">
                            <p>{{ $item->medicine->name ?? 'Medicine' }}</p>
                            </div>
                        </td>
                        <td>{{ number_format($price, 2) }} FCFA</td>
                        <td>
                            <form action="{{ route('cart.update', $item->id) }}" method="POST">
                              @csrf
                              @method('PUT')
                              <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" style="width:60px" />
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
                    <tr><td colspan="5">Your cart is empty.</td></tr>
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
           <button class="checkout-btn">
    <i class="fa-solid fa-credit-card"></i>
    Checkout
</button>
@endsection