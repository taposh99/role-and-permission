<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tender;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class TenderController extends Controller
{
    public function index()
    {
        return Tender::all();
    }

    public function show($id)
    {
        return Tender::findOrFail($id);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $tender = new Tender();
        $tender->title = $request->title;
        $tender->description = $request->description;
        $tender->user_id = auth()->user()->id;
        $tender->save();

        return response()->json($tender, 201);
    }
}
