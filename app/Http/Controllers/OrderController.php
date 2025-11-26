<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Important for database transactions
use Exception;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Eager load the customer relationship for each order
        $orders = Order::with('customer')->latest()->paginate(10);
        return view('orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // We need a list of customers and products to build the order form
        $customers = Customer::all();
        $products = Product::where('quantity_in_stock', '>', 0)->get(); // Only show products that are in stock
        return view('orders.create', compact('customers', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     * This is the most complex method. It creates an order and its items in a single, safe operation.
     */
    public function store(Request $request)
    {
        // Validate the main order data
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'order_date' => 'required|date',
            'status' => 'required|string|in:pending,processing,shipped,completed,cancelled',
            'products' => 'required|array|min:1', // Must have at least one product
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        // Use a database transaction. This ensures that if any part of the process fails,
        // the entire operation is rolled back, preventing partial or corrupt data.
        DB::beginTransaction();

        try {
            $order = Order::create([
                'customer_id' => $request->customer_id,
                'order_date' => $request->order_date,
                'status' => $request->status,
                'total_amount' => 0, // We will calculate this below
            ]);

            $totalAmount = 0;

            // Loop through each product in the order
            foreach ($request->products as $item) {
                $product = Product::findOrFail($item['id']);

                // Check if there is enough stock
                if ($product->quantity_in_stock < $item['quantity']) {
                    // If not, throw an exception to cancel the whole transaction
                    throw new Exception("Insufficient stock for product: {$product->name}. Available: {$product->quantity_in_stock}, Requested: {$item['quantity']}");
                }

                $itemTotal = $product->selling_price * $item['quantity'];
                $totalAmount += $itemTotal;

                // Create the order item
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price_at_time_of_purchase' => $product->selling_price,
                ]);

                // Decrease the product stock
                $product->decrement('quantity_in_stock', $item['quantity']);
            }

            // Update the order with the final total amount
            $order->update(['total_amount' => $totalAmount]);

            // If everything went well, commit the transaction
            DB::commit();

            return redirect()->route('orders.index')->with('success', 'Order created successfully.');
        } catch (Exception $e) {
            // If an error occurred, roll back the transaction
            DB::rollBack();

            // Redirect back with an error message and the old input
            return redirect()->back()
                ->with('error', 'Failed to create order: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        // Eager load the customer and all items for the order.
        // For each item, we also eager load its product data.
        $order->load('customer', 'items.product');
        return view('orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     * NOTE: Editing an order after it's created can be complex.
     * For this example, we will only allow editing the status and customer.
     */
    public function edit(Order $order)
    {
        $customers = Customer::all();
        return view('orders.edit', compact('order', 'customers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'status' => 'required|string|in:pending,processing,shipped,completed,cancelled',
        ]);

        $order->update($request->all());

        return redirect()->route('orders.show', $order->id)->with('success', 'Order updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        // Use a transaction to safely delete the order and restore stock
        DB::beginTransaction();
        try {
            // Loop through each item in the order to restore stock
            foreach ($order->items as $item) {
                $item->product->increment('quantity_in_stock', $item->quantity);
            }

            // Delete the order. Because we have `onDelete('cascade')` in the migration,
            // this will automatically delete all associated order_items.
            $order->delete();

            DB::commit();
            return redirect()->route('orders.index')->with('success', 'Order deleted and stock restored.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('orders.index')->with('error', 'Failed to delete order.');
        }
    }
    // ... keep all the other methods (index, create, store, etc.) above this

    /**
     * Export the specified order to a PDF invoice.
     */
    public function exportPdf(Order $order)
    {
        // Eager load the same data as the show() method
        $order->load('customer', 'items.product');

        // You will create a new view file for the PDF template
        $pdf = PDF::loadView('orders.invoice', compact('order'));

        // Stream the PDF to the browser. The user can choose to open or download it.
        // The second parameter is the filename that will be suggested to the user.
        return $pdf->stream('invoice-' . $order->id . '.pdf');
    }
}
