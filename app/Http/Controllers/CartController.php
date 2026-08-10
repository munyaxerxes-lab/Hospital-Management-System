<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\cart;
use App\Models\medicine;
use App\Models\User;

// class CartController extends Controller
// {
//     private function getUserId(): int
//     {
//         if (auth()->check()) {
//             return auth()->id();
//         }

//          $user = User::firstOrCreate(
//         //     ['email' => 'default@example.com'],
//         //     ['name' => 'Default User', 'password' => bcrypt('secret')]
//         // );

//         return $user->id;
//     }

//     public function __construct()
//     {
//         // allow cart access via fallback user when auth is not present
//     }

//     public function index()
//     {
//         $userId = $this->getUserId();
//         $carts = cart::with('medicine')->where('user_id', $userId)->get();
//         return view('account.patient.cart', compact('carts'));
//     }

//     public function add($id)
//     {
//         $medicine = medicine::findOrFail($id);
//         $userId = $this->getUserId();
//         $cart = cart::where('user_id', $userId)->where('medicine_id', $medicine->id)->first();
//         $currentQty = $cart->quantity ?? 0;
//         if ($medicine->stock <= $currentQty) {
//             return back()->with('error', 'Not enough stock available');
//         }

//         if ($cart) {
//             $cart->quantity = $currentQty + 1;
//             $cart->save();
//         } else {
//             cart::create([
//                 'user_id' => $userId,
//                 'medicine_id' => $medicine->id,
//                 'quantity' => 1,
//             ]);
//         }

//         if (request()->wantsJson()) {
//             return response()->json([
//                 'success' => true,
//                 'message' => 'Added to cart',
//                 'cartCount' => cart::where('user_id', $userId)->sum('quantity'),
//             ]);
//         }

//         return back()->with('success', 'Added to cart');
//     }

//     public function store(Request $request)
//     {
//         $request->validate([
//             'medicine_id' => 'required|exists:medicines,id',
//             'quantity' => 'nullable|integer|min:1',
//         ]);

//         $medicine = medicine::findOrFail($request->medicine_id);
//         $userId = $this->getUserId();
//         $cart = cart::where('user_id', $userId)->where('medicine_id', $medicine->id)->first();
//         $qty = $request->quantity ?? 1;
//         $currentQty = $cart->quantity ?? 0;
//         if ($medicine->stock < ($currentQty + $qty)) {
//             return back()->with('error', 'Requested quantity exceeds available stock');
//         }

//         if ($cart) {
//             $cart->quantity = $currentQty + $qty;
//             $cart->save();
//         } else {
//             cart::create([
//                 'user_id' => $userId,
//                 'medicine_id' => $medicine->id,
//                 'quantity' => $qty,
//             ]);
//         }

//         return back()->with('success', 'Added to cart');
//     }

//     public function update(Request $request, $id)
//     {
//         $request->validate(['quantity' => 'required|integer|min:1']);
//         $userId = $this->getUserId();
//         $cart = cart::findOrFail($id);
//         if ($cart->user_id !== $userId) {
//             abort(403);
//         }
//         $medicine = medicine::find($cart->medicine_id);
//         if ($medicine && $request->quantity > $medicine->stock) {
//             return back()->with('error', 'Quantity exceeds available stock');
//         }
//         $cart->quantity = $request->quantity;
//         $cart->save();
//         return back();
//     }

//     public function destroy($id)
//     {
//         $userId = $this->getUserId();
//         $cart = cart::findOrFail($id);
//         if ($cart->user_id !== $userId) {
//             abort(403);
//         }
//         $cart->delete();
//         return back();
//     }
// }
