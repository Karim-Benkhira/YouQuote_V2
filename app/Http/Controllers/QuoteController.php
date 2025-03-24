<?php

namespace App\Http\Controllers;

use App\Models\quote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class QuoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $quotes = Quote::with(['tags', 'categories'])->get();
        return response()->json($quotes);
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
                'author' => 'required',
                'quote' => 'required',
                'tags' => 'nullable|array|exists:tags,id',
                'categories' => 'required|array|exists:categories,id',
            ]);
    
            $validatedData['user_id'] = Auth::id();
            $quote = quote::create($validatedData);

            if(request()->has('tags')){
                $quote->tags()->sync($request->tags);
            }
            if(request()->has('categories')){
                $quote->categories()->sync($request->categories);
            }

            return response()->json(
                [
                    'message' => 'Quote created successfully',
                    'quote' => $quote
                ],
                201
            );
    }

    /**
     * Display the specified resource.
     */
    public function show(quote $quote)
    {
        $quote = quote::find($quote->id);
        $quote->vue++;
        $quote->save();
        return response()->json($quote);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(quote $quote)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, quote $quote)
    {
        if(Gate::Allows('CheckPermission', $quote)){
            $validatedData = $request->validate([
                'author' => 'required',
                'quote' => 'required',
            ]);
    
            $quote->author = $validatedData['author'];
            $quote->quote = $validatedData['quote'];
            $quote->save();
    
            return response()->json(
                [
                    'message' => 'Quote updated successfully',
                    'quote' => $quote
                ],
                200
            );
        }else{
            return response()->json(['message' => 'You are not allowed to update a quote'], 403);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(quote $quote)
    {
        if(Gate::Allows('CheckPermission', $quote)){
            $quote->delete();
            return response()->json(
                [
                    'message' => 'Quote deleted successfully'
                ],
                200
            );
        }else{
            return response()->json(['message' => 'You are not allowed to delete a quote'], 403);
        }
    }



    public function getByLength($length)
    {
        $quotes = quote::all()->filter(function ($quote) use ($length) {
            return str_word_count($quote->quote) <= $length;
        });

        return response()->json($quotes);
    }

    
    public function getPopular($nb){
        $quotes = quote::orderBy('vue', 'desc')->limit($nb)->get();
        return response()->json($quotes);
    }


    public function getRandom($nb){
        $quote = quote::inRandomOrder()->limit($nb)->get();
        return response()->json($quote);
    }

    public function LikeQuote(Request $request){
        $quote = quote::find($request->id);
        $quote->like++;
        $quote->save();
        return response()->json($quote);
    }

    public function DislikeQuote(Request $request){
        $quote = quote::find($request->id);
        $quote->like--;
        $quote->save();
        return response()->json($quote);
    }

}
