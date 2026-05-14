<?php
namespace App\Http\Controllers\Api\V1;

use App\Events\OrderStatusUpdated;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\MenuItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderItemCustomization;
use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $v = Validator::make($request->all(), [
            'table_id'                           => 'required|string',
            'items'                              => 'required|array|min:1',
            'items.*.menu_item_id'               => 'required|integer|exists:menu_items,id',
            'items.*.quantity'                   => 'required|integer|min:1',
            'items.*.customizations'             => 'nullable|array',
            'items.*.customizations.*.option_id' => 'required|integer|exists:customization_options,id',
            'items.*.customizations.*.quantity'  => 'required|integer|min:1',
            'customer_note'                      => 'nullable|string|max:500',
        ]);

        if ($v->fails()) {
            return response()->json(['errors' => $v->errors()], 422);
        }

        $table = Table::where('table_code', $request->table_id)->first();
        if (!$table) {
            return response()->json(['message' => 'Table not found'], 404);
        }

        $order = Order::create([
            'table_id'      => $table->id,
            'status'        => 'pending',
            'customer_note' => $request->customer_note,
        ]);

        foreach ($request->items as $item) {
            $menuItem = MenuItem::find($item['menu_item_id']);

            $orderItem = OrderItem::create([
                'order_id'     => $order->id,
                'menu_item_id' => $item['menu_item_id'],
                'quantity'     => $item['quantity'],
                'unit_price'   => $menuItem->price,
            ]);

            foreach ($item['customizations'] ?? [] as $custom) {
                OrderItemCustomization::create([
                    'order_item_id'           => $orderItem->id,
                    'customization_option_id' => $custom['option_id'],
                    'quantity'                => $custom['quantity'],
                ]);
            }
        }

        // try {
        //     broadcast(new OrderStatusUpdated($order->id, 'pending'));
        // } catch (\Exception $e) {
        //     Log::warning('Broadcast failed: ' . $e->getMessage());
        // }

        return response()->json([
            'message' => 'Order placed successfully',
            'orderId' => $order->id,
            'status'  => 'pending',
        ], 201);
    }

    public function show(int $id)
    {
        $order = Order::with([
            'table',
            'items.menuItem',
            'items.customizations.option',
        ])->find($id);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        return new OrderResource($order);
    }

    public function updateStatus(Request $request, int $id)
    {
        $order = Order::find($id);
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $v = Validator::make($request->all(), [
            'status'         => 'required|in:pending,confirmed,preparing,ready,served',
            'estimated_time' => 'nullable|integer|min:1',
        ]);

        if ($v->fails()) {
            return response()->json(['errors' => $v->errors()], 422);
        }

        $order->update([
            'status'         => $request->status,
            'estimated_time' => $request->estimated_time,
        ]);

        // broadcast(new OrderStatusUpdated($order->id, $request->status, $request->estimated_time));

        return response()->json([
            'message' => 'Status updated',
            'status'  => $request->status,
        ]);
    }
}