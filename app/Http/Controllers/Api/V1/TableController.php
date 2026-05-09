<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Table;

class TableController extends Controller
{
    public function status(string $tableId)
    {
        $table = Table::where('table_code', $tableId)->first();

        if (!$table) {
            return response()->json(['message' => 'Table not found'], 404);
        }

        return response()->json([
            'tableId' => $table->table_code,
            'status'  => $table->status,
        ]);
    }
}