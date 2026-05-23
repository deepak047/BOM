<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MaterialAllocation;

class MaterialAllocationController extends Controller
{
    public function index(Request $request)
    {
        $allocations = MaterialAllocation::all();
        
        if ($request->wantsJson()) {
			return response()->json([
            'success' => true,
            'data'    => $allocations
        ], 200);
		}

        return view('allocation.index', compact('allocations'));
    }
}
