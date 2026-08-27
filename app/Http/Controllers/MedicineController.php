<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MedicineController extends Controller
{
    /**
     * Display medicine catalog, orders list, and live statistical metrics.
     */
    public function index(Request $request)
    {
        // 1. Medicine Inventory Query & Filters
        $medQuery = Medicine::latest();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $medQuery->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('type', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('type') && $request->type !== 'all') {
            $medQuery->where('type', $request->type);
        }

        if ($request->filled('stock_status') && $request->stock_status !== 'all') {
            if ($request->stock_status === 'in_stock') {
                $medQuery->where('stock', '>', 0);
            } elseif ($request->stock_status === 'out_of_stock') {
                $medQuery->where('stock', '<=', 0);
            } elseif ($request->stock_status === 'low_stock') {
                $medQuery->where('stock', '>', 0)->where('stock', '<=', 5);
            }
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $medQuery->where('status', $request->status === 'active' || $request->status === '1');
        }

        $medicines = $medQuery->get();

        // 2. Orders Query & Filters
        $orderQuery = Order::with(['user', 'patient.user', 'items.medicine'])->latest();

        if ($request->filled('order_search')) {
            $orderSearch = $request->input('order_search');
            $orderQuery->where(function ($q) use ($orderSearch) {
                $q->where('order_number', 'like', "%{$orderSearch}%")
                  ->orWhere('shipping_address', 'like', "%{$orderSearch}%")
                  ->orWhereHas('user', function ($uQ) use ($orderSearch) {
                      $uQ->where('name', 'like', "%{$orderSearch}%")
                         ->orWhere('email', 'like', "%{$orderSearch}%");
                  })
                  ->orWhereHas('items.medicine', function ($mQ) use ($orderSearch) {
                      $mQ->where('name', 'like', "%{$orderSearch}%");
                  });
            });
        }

        if ($request->filled('order_status') && $request->order_status !== 'all') {
            $orderQuery->where('status', $request->order_status);
        }

        $orders = $orderQuery->get();

        // 3. Computed Statistics
        $stats = [
            'total_medicines' => Medicine::count(),
            'active_medicines' => Medicine::where('status', true)->count(),
            'low_stock'       => Medicine::where('stock', '<=', 5)->count(),
            'total_ordered'   => Order::count(),
            'delivered'       => Order::where('status', 'delivered')->count(),
            'pending'         => Order::where('status', 'pending')->count(),
            'processing'      => Order::where('status', 'processing')->count(),
            'total_items_sold'=> OrderItem::sum('quantity'),
            'total_revenue'   => Order::where('status', 'delivered')->sum('total_amount'),
        ];

        $activeTab = $request->input('tab', 'inventory');

        return view('account.admin.medicine_orders', compact('medicines', 'orders', 'stats', 'activeTab'));
    }

    /**
     * Store a newly created medicine in inventory.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'type'        => 'required|string|in:Capsules,Tablets,Syrup,Powder,Band,Injection,Cotton,Drips',
            'stock'       => 'required|integer|min:0',
            'expiry_date' => 'required|date',
            'price'       => 'required|numeric|min:0',
            'description' => 'nullable|string|max:1000',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('medicines', 'public');
            $validated['image'] = $path;
        }

        $validated['status'] = true;

        Medicine::create($validated);

        return redirect()
            ->route('admin.medicines.index', ['tab' => 'inventory'])
            ->with('success', 'Medicine added to pharmacy inventory successfully.');
    }

    /**
     * Show the form for editing the specified medicine.
     */
    public function edit(Medicine $medicine)
    {
        return view('account.admin.edit_medicine', compact('medicine'));
    }

    /**
     * Update medicine details.
     */
    public function update(Request $request, Medicine $medicine)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'type'        => 'required|string|in:Capsules,Tablets,Syrup,Powder,Band,Injection,Cotton,Drips',
            'stock'       => 'required|integer|min:0',
            'expiry_date' => 'required|date',
            'price'       => 'required|numeric|min:0',
            'description' => 'nullable|string|max:1000',
            'status'      => 'required|boolean',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($medicine->image && Storage::disk('public')->exists($medicine->image)) {
                Storage::disk('public')->delete($medicine->image);
            }
            $path = $request->file('image')->store('medicines', 'public');
            $validated['image'] = $path;
        }

        $medicine->update($validated);

        return redirect()
            ->route('admin.medicines.index', ['tab' => 'inventory'])
            ->with('success', 'Medicine details updated successfully.');
    }

    /**
     * Remove medicine from inventory.
     */
    public function destroy(Medicine $medicine)
    {
        if ($medicine->image && Storage::disk('public')->exists($medicine->image)) {
            Storage::disk('public')->delete($medicine->image);
        }

        $medicine->delete();

        return redirect()
            ->route('admin.medicines.index', ['tab' => 'inventory'])
            ->with('success', 'Medicine removed from pharmacy catalog.');
    }

    /**
     * Toggle medicine availability status.
     */
    public function toggleStatus($id)
    {
        $medicine = Medicine::findOrFail($id);
        $medicine->status = !$medicine->status;
        $medicine->save();

        $statusText = $medicine->status ? 'activated' : 'deactivated';

        return redirect()
            ->route('admin.medicines.index', ['tab' => 'inventory'])
            ->with('success', "Medicine {$statusText} successfully.");
    }

    /**
     * Update order fulfillment status (Pending, Delivered, Processing, Cancelled).
     */
    public function updateOrderStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,delivered,processing,cancelled',
        ]);

        $order = Order::findOrFail($id);
        $order->status = $request->status;

        if ($request->status === 'delivered') {
            $order->delivered_at = now();
            $order->payment_status = 'paid';
        } elseif ($request->status === 'pending') {
            $order->delivered_at = null;
        }

        $order->save();

        return redirect()
            ->route('admin.medicines.index', ['tab' => 'orders'])
            ->with('success', "Order #{$order->order_number} marked as {$request->status}.");
    }

    /**
     * Delete an order and its items.
     */
    public function deleteOrder($id)
    {
        $order = Order::findOrFail($id);
        $orderNum = $order->order_number;
        $order->items()->delete();
        $order->delete();

        return redirect()
            ->route('admin.medicines.index', ['tab' => 'orders'])
            ->with('success', "Order #{$orderNum} deleted successfully.");
    }
}
