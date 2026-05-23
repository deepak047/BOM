<?php

namespace App\Http\Controllers;

use App\Http\Requests\BomUploadRequest;
use App\Actions\UploadBomAction;
use Illuminate\Http\Request;
use App\Models\BomLineItem;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class BomUploadController extends Controller
{
	use AuthorizesRequests;

	public function uploadForm()
	{
		$this->authorize('upload-bom');
		return view('bom.upload');
	}

	public function index(Request $request)
    {
        $lineItems = BomLineItem::all();
        
        if ($request->wantsJson()) {
			return response()->json([
            'success' => true,
            'data'    => $lineItems
        ], 200);
		}

        return view('bom.index', compact('lineItems'));
    }

	public function upload(BomUploadRequest $request, UploadBomAction $uploadBom)
	{

		$bom = $uploadBom($request->file('bom_file'), $request->integer('project_id'), auth()->id());

		if ($request->wantsJson()) {
			return response()->json([
				'message' => 'BOM uploaded successfully. Checking inventory in background.',
				'data' => [
					'bom_id' => $bom->id,
					'reference' => $bom->bom_reference,
				]
        ], 201); // 201 Created
		}

     
		return redirect()
		->route('bom_line_items.index')
		->with('success', 'BOM uploaded. Checking inventory in background.');
	}

	public function details($id)
	{
   
		$bom = BomHeader::with('lineItems')->findOrFail($id);

		return view('bom.details', compact('bom'));
	}
}
