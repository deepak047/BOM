<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventory;

class InventoryController extends Controller
{
    
    public function index(Request $request)
    {
        $inventories = Inventory::all();
        
        if ($request->wantsJson()) {
			return response()->json([
            'success' => true,
            'data'    => $inventories
        ], 200);
		}

        return view('inventory.index', compact('inventories'));
    }
}
