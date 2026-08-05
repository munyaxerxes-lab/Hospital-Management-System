<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class cartcontroller extends Controller
{
    public function add($id)
    {
      $cart = cart::where ('medicine_id, $id')->first();
      if($cart){
        $cart->quantity++;
        $cart->save;
      } else{
        cart::create([
            'medicine' => $id,
            'quantity' => 1
        ]);
      }
       return redirect ('/cart');
    }
}
