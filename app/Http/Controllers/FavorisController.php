<?php

namespace App\Http\Controllers;

use App\Models\Favoris;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class FavorisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(Gate::allows('CheckPermission', auth()->user())){
            $favoris = Favoris::with(['user', 'quote'])->where('user_id', auth()->id())->get();
            if ($favoris->isEmpty()) {
                return response()->json(['message' => 'No favoris found'], 404);
            }
            return response()->json($favoris);
        }else{
            return response()->json(['message' => 'No favoris found'], 403);
        }
       
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
        $validatedData = $request->validate([
            'quote_id' => 'required|exists:quotes,id',
        ]);

        $validatedData['user_id'] = $request->user()->id;
        $favoris = Favoris::create($validatedData);

        return response()->json([
            'message' => 'Favoris created successfully',
            'favoris' => $favoris
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Favoris $favoris)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Favoris $favoris)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Favoris $favoris)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if(Gate::allows('CheckPermission', auth()->user())){
            $favoris = Favoris::find($id);
            $favoris->delete();
            return response()->json([
                'message' => 'deleted from Favoris successfully',
            ], 200);
        }else{
            return response()->json(['message' => 'You are not allowed to delete a favoris'], 403);
        }
    }
}
