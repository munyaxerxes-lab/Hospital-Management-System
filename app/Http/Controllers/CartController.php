<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\cart;
use App\Models\Medicine;
use App\Models\User;
use App\Models\Patient;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
	private function getUserId(): int
	{
		if (auth()->check()) {
			return auth()->id();
		}

		$user = User::firstOrCreate(
			['email' => 'guest@example.com'],
			['name' => 'Guest User', 'password' => bcrypt('password')]
		);

		return $user->id;
	}

	public function __construct()
	{
		// allow cart access via fallback user when auth is not present
	}

	public function index()
	{
		$userId = $this->getUserId();
		$carts = cart::with('medicine')->where('user_id', $userId)->get();
		$cartCount = $carts->sum('quantity');
		$totalPrice = $carts->sum(function ($item) {
			return ($item->medicine->price ?? 0) * $item->quantity;
		});
		return view('account.patient.cart', compact('carts', 'cartCount', 'totalPrice'));
	}

	public function add($id)
	{
		$medicine = Medicine::findOrFail($id);
		$userId = $this->getUserId();
		$cart = cart::where('user_id', $userId)->where('medicine_id', $medicine->id)->first();
		$currentQty = $cart->quantity ?? 0;
		if ($medicine->stock <= $currentQty) {
			if (request()->wantsJson()) {
				return response()->json([
					'success' => false,
					'message' => 'Not enough stock available for this medicine.'
				], 422);
			}
			return back()->with('error', 'Not enough stock available');
		}

		if ($cart) {
			$cart->quantity = $currentQty + 1;
			$cart->save();
		} else {
			cart::create([
				'user_id' => $userId,
				'medicine_id' => $medicine->id,
				'quantity' => 1,
			]);
		}

		$totalCount = cart::where('user_id', $userId)->sum('quantity');

		if (request()->wantsJson()) {
			return response()->json([
				'success' => true,
				'message' => "{$medicine->name} added to cart successfully!",
				'medicineName' => $medicine->name,
				'cartCount' => $totalCount,
			]);
		}

		return back()->with('success', "{$medicine->name} added to cart!");
	}

	public function store(Request $request)
	{
		$request->validate([
			'medicine_id' => 'required|exists:medicine,id',
			'quantity' => 'nullable|integer|min:1',
		]);

		$medicine = Medicine::findOrFail($request->medicine_id);
		$userId = $this->getUserId();
		$cart = cart::where('user_id', $userId)->where('medicine_id', $medicine->id)->first();
		$qty = (int)($request->quantity ?? 1);
		$currentQty = $cart->quantity ?? 0;
		if ($medicine->stock < ($currentQty + $qty)) {
			if ($request->wantsJson()) {
				return response()->json([
					'success' => false,
					'message' => "Requested quantity exceeds available stock ({$medicine->stock} left)."
				], 422);
			}
			return back()->with('error', 'Requested quantity exceeds available stock');
		}

		if ($cart) {
			$cart->quantity = $currentQty + $qty;
			$cart->save();
		} else {
			cart::create([
				'user_id' => $userId,
				'medicine_id' => $medicine->id,
				'quantity' => $qty,
			]);
		}

		$totalCount = cart::where('user_id', $userId)->sum('quantity');

		if ($request->wantsJson()) {
			return response()->json([
				'success' => true,
				'message' => "{$qty}x {$medicine->name} added to cart!",
				'medicineName' => $medicine->name,
				'cartCount' => $totalCount,
			]);
		}

		return back()->with('success', 'Added to cart');
	}

	public function update(Request $request, $id)
	{
		$request->validate(['quantity' => 'required|integer|min:1']);
		$userId = $this->getUserId();
		$cart = cart::findOrFail($id);
		if ($cart->user_id !== $userId) {
			abort(403);
		}
		$medicine = Medicine::find($cart->medicine_id);
		if ($medicine && $request->quantity > $medicine->stock) {
			if ($request->wantsJson()) {
				return response()->json([
					'success' => false,
					'message' => "Requested quantity exceeds available stock ({$medicine->stock} left)."
				], 422);
			}
			return back()->with('error', 'Quantity exceeds available stock');
		}
		$cart->quantity = (int)$request->quantity;
		$cart->save();

		if ($request->wantsJson()) {
			$userCarts = cart::with('medicine')->where('user_id', $userId)->get();
			$totalAmount = $userCarts->sum(function ($c) {
				return ($c->medicine->price ?? 0) * $c->quantity;
			});
			$totalQty = $userCarts->sum('quantity');
			$lineTotal = ($medicine->price ?? 0) * $cart->quantity;

			return response()->json([
				'success' => true,
				'message' => 'Cart updated successfully.',
				'cartCount' => $totalQty,
				'lineTotal' => number_format($lineTotal, 0, '.', ' ') . ' FCFA',
				'totalAmount' => number_format($totalAmount, 0, '.', ' ') . ' FCFA',
				'totalQty' => $totalQty,
			]);
		}

		return back()->with('success', 'Cart updated successfully.');
	}

	public function destroy($id)
	{
		$userId = $this->getUserId();
		$cart = cart::findOrFail($id);
		if ($cart->user_id !== $userId) {
			abort(403);
		}
		$cart->delete();

		if (request()->wantsJson()) {
			$userCarts = cart::with('medicine')->where('user_id', $userId)->get();
			$totalAmount = $userCarts->sum(function ($c) {
				return ($c->medicine->price ?? 0) * $c->quantity;
			});
			$totalQty = $userCarts->sum('quantity');

			return response()->json([
				'success' => true,
				'message' => 'Item removed from cart.',
				'cartCount' => $totalQty,
				'totalAmount' => number_format($totalAmount, 0, '.', ' ') . ' FCFA',
				'isEmpty' => $userCarts->isEmpty(),
			]);
		}

		return back()->with('success', 'Item removed from cart.');
	}

	public function checkout(Request $request)
	{
		$userId = $this->getUserId();
		$cartItems = cart::with('medicine')->where('user_id', $userId)->get();

		if ($cartItems->isEmpty()) {
			return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
		}

		// Verify stock for all items
		foreach ($cartItems as $item) {
			if (!$item->medicine) {
				return redirect()->route('cart.index')->with('error', 'One or more items in your cart are invalid.');
			}
			if ($item->medicine->stock < $item->quantity) {
				return redirect()->route('cart.index')->with('error', "Not enough stock for {$item->medicine->name}. Available: {$item->medicine->stock}");
			}
		}

		$order = DB::transaction(function () use ($userId, $cartItems, $request) {
			$totalAmount = 0;
			foreach ($cartItems as $item) {
				$price = $item->medicine->price ?? 0;
				$totalAmount += ($price * $item->quantity);
			}

			// Get or create patient record for user
			$patient = Patient::firstOrCreate(['user_id' => $userId]);

			// Generate clean order number
			$orderNumber = 'ORD-' . date('Ymd') . '-' . strtoupper(Str::random(4));

			$order = Order::create([
				'order_number' => $orderNumber,
				'user_id' => $userId,
				'patient_id' => $patient->id,
				'total_amount' => $totalAmount,
				'status' => 'pending',
				'payment_status' => 'pending',
				'payment_method' => $request->input('payment_method', 'cash_on_delivery'),
				'shipping_address' => $request->input('shipping_address', 'Hospital Clinic / Patient Address'),
				'notes' => $request->input('notes'),
			]);

			foreach ($cartItems as $item) {
				$unitPrice = $item->medicine->price ?? 0;
				$itemTotal = $unitPrice * $item->quantity;

				OrderItem::create([
					'order_id' => $order->id,
					'medicine_id' => $item->medicine_id,
					'quantity' => $item->quantity,
					'unit_price' => $unitPrice,
					'total_price' => $itemTotal,
				]);

				// Decrement medicine stock
				$item->medicine->decrement('stock', $item->quantity);
			}

			// Clear user's cart
			cart::where('user_id', $userId)->delete();

			return $order;
		});

		return redirect()->route('cart.index')->with('success', "Order #{$order->order_number} placed successfully! Status: Pending dispatch.");
	}
}
