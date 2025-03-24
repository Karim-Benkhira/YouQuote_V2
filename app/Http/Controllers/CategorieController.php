<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Categorie::all();
        return response()->json($categories); 
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
    
            $categorie = Categorie::create($validateData);
            return response()->json([
                'message' => 'Categorie created successfully',
                'categorie' => $categorie
            ]);
        }else{
            return response()->json(['message' => 'You are not allowed to create a categorie'], 403);
        }
       
    }

    /**
     * Display the specified resource.
     */
    public function show(Categorie $category)
    {
        dd($category);
        $categorie = Categorie::findOrFail($id);
        return response()->json($categorie);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Categorie $categorie)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Categorie $categorie, int $id)
    {
        if(Gate::Allows('CheckAdmin')){
            $validateData = $request->validate([
                'name'=>'required|string'
            ]);
    
            $categorie = Categorie::find($id);
            $categorie->update($validateData);
            return response()->json([
                'message' => 'Categorie updated successfully',
                'categorie' => $categorie
            ]);
        }else{
            return response()->json(['message' => 'You are not allowed to update a categorie'], 403);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categorie $categorie, int $id)
    {
        if(Gate::Allows('CheckAdmin')){
            $categorie = Categorie::find($id);
            $categorie->delete();
            return response()->json([
                'message' => 'Categorie deleted successfully'
            ]);
        }else{
            return response()->json(['message' => 'You are not allowed to delete a categorie'], 403);
        }
        
    }
}
