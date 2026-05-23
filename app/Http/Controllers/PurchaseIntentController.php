<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PurchaseIntent;

class PurchaseIntentController extends Controller
{
    public function index(Request $request)
    {
        $intents = PurchaseIntent::all();
        
        if ($request->wantsJson()) {
			return response()->json([
            'success' => true,
            'data'    => $intents
        ], 200);
		}

        return view('purchase.index', compact('intents'));
    }
}
