<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\MenuItemResource;
use App\Models\MenuItem;
use App\Models\Table;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $table = Table::with('restaurant')
            ->where('table_code', $request->query('table_id'))
            ->first();

        if (!$table) {
            return response()->json(['message' => 'Table not found'], 404);
        }

        $restaurant = $table->restaurant;

        $categories = $restaurant->categories()->orderBy('sort_order')->get();

        $items = MenuItem::with('customizationGroups.options')
            ->whereIn('category_id', $categories->pluck('id'))
            ->where('is_available', true)
            ->get();

        return response()->json([
            'restaurant' => [
                'id'      => 'R' . str_pad($restaurant->id, 3, '0', STR_PAD_LEFT),
                'name'    => $restaurant->name,
                'tableId' => $table->table_code,
            ],
            'categories' => CategoryResource::collection($categories),
            'items'      => MenuItemResource::collection($items),
        ]);
    }
}