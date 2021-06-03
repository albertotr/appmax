<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $transactions = Transaction::all();
        return response($transactions);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $type = 'increase';
        $origin = 'I';

        if (strpos($request->url(), 'adicionar-produtos')) {
            $type = 'increase';
            $origin = 'A';
        } else if (strpos($request->url(), 'baixar-produtos')) {
            $type = 'decrease';
            $origin = 'A';
        } else if ($request->type) {
            $type = $request->type;
        }

        DB::beginTransaction();
        try {
            $product = Product::where('sku', $request->sku)->first();

            $qtd = $request->qtd;
            if ($type == 'decrease') $qtd = -1 * $qtd;

            $product->quantity += $qtd;

            $product->save();

            $transaction = Transaction::create([
                'origin' => $origin,
                'amount' => $qtd,
                'product_id' => $product->id
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'error' => "Problemas ao lançar transação", "data" => $e], 400);
        }

        DB::commit();
        return response()->json(['success' => true, 'data' => ['product' => $product, 'transaction' => $transaction]], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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
    public function destroy(Transaction $product)
    {
    }
}
