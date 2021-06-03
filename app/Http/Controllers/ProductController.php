<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        return response($products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        try {
            $product = Product::create([
                'name' => $request->name,
                'sku' => $request->sku
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => "Problemas ao criar o registro", "data" => $e], 400);
        }

        $returnProduct = Product::find($product->id);
        return response()->json(['success' => true, 'data' => $returnProduct], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = Product::find($request->id);

        if (empty($product)) return response()->json(['success' => false, 'error' => "Codigo do produto inexistente"], 400);

        try {
            $product->name = $request->name;
            $product->sku = $request->sku;
            $product->save();
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => "Problemas ao salvar o registro", "data" => $e->getCode()], 400);
        }

        return response()->json(['success' => true, 'data' => $product], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        try {
            $product->delete();
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => "Problemas ao excluir o registro", "data" => $e], 400);
        }

        return response()->json(['success' => true, 'data' => $product], 200);
    }
}
