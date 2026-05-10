<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\MenuItemResource;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MenuItemController extends Controller
{
    public function update(Request $request, int $id)
    {
        $menuItem = MenuItem::find($id);
        if (!$menuItem) {
            return response()->json(['message' => 'Menu item not found'], 404);
        }

        $v = Validator::make($request->all(), [
            'name'         => 'sometimes|string|max:255',
            'description'  => 'sometimes|nullable|string',
            'price'        => 'sometimes|numeric|min:0',
            'image_url'    => 'sometimes|nullable|url',
            'is_available' => 'sometimes|boolean',
        ]);

        if ($v->fails()) {
            return response()->json(['errors' => $v->errors()], 422);
        }

        $menuItem->update($request->only([
            'name', 'description', 'price', 'image_url', 'is_available'
        ]));

        return new MenuItemResource($menuItem->load('customizationGroups.options'));
    }
}