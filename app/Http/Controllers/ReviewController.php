<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;




class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    //use App\Models\Review; これがないと記述が長くなる

    public function store(Request $request, $id)
    {
        $posts = $request->all();

        //Review::insert([  //省略できる

        'App\Models\Review'::insert([ //これでReviewモデルにアクセスできる
            'recipe_id' => $id,
            'user_id' => $request->user()->id,
            'rating' => $posts['rating'],
            'comment' => $posts['comment'],
        ]);
        flash()->success('レビューを投稿しました');

        return redirect()->route('recipe.show', ['id' => $id]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
