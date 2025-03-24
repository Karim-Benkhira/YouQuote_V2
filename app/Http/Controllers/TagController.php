<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tags = Tag::all();
        return response()->json($tags);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(Gate::Allows('CheckAdmin')){
        $validateData = $request->validate([
            'name'=>'required|string'
        ]);

        $tag = Tag::create($validateData);
        return response()->json([
            'message' => 'Tag created successfully',
            'tag' => $tag
        ]);
        }else{
            return response()->json(['message' => 'You are not allowed to create a tag'], 403);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Tag $tag)
    {
        $tag = Tag::find($tag->id);
        return response()->json($tag);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tag $tag)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tag $tag)
    {
        if(Gate::Allows('CheckAdmin')){
        $validateData = $request->validate([
            'name'=>'required|string'
        ]);

        $tag = Tag::find($tag->id);
        $tag->Update($validateData);
        return response()->json([
            'message' => 'Tag updated successfully',
            'tag' => $tag
        ]);
        }else{
            return response()->json(['message' => 'You are not allowed to update a tag'], 403);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
        if(Gate::Allows('CheckAdmin')){
        $tag = Tag::find($tag->id);
        $tag->delete();
        return response()->json([
            'message' => 'Tag deleted successfully'
        ]);
        }else{
            return response()->json(['message' => 'You are not allowed to delete a tag'], 403);
        }
    }
}
