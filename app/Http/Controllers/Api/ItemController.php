<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
   

    public function index(Request $request)
{

    $query = Item::query();

    if ($request->has('user_id')) {
        $query->where('user_id', $request->input('user_id'));
    }

    if ($request->has('name')) {
        $query->where('name', 'like', '%' . $request->input('name') . '%');
    }

    if ($request->has('description')) {
        $query->where('description', 'like', '%' . $request->input('description') . '%');
    }


    $items = $query->get();
    return response()->json($items);

}


    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Create the item and associate it with the authenticated user
        $item = Item::create([
            'name' => $request->name,
            'description' => $request->description,
            'user_id' => Auth::id(), // Associate the item with the logged-in user
        ]);

        return response()->json($item, 201);
    }


    public function show(Item $item)
    {
        return $item;
    }


    public function update(Request $request, Item $item)
    {
        // Only the owner can update the item
        if ($item->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $item->update($request->all());

        return response()->json($item);
    }

    
    public function destroy(Item $item)
    {
        // Only the owner can delete the item
        if ($item->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $item->delete();

        return response()->json(null, 204);
    }
}
