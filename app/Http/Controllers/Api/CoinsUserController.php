<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ApiResponser;
use App\Models\CoinsUser;
use Illuminate\Support\Facades\Auth;


class CoinsUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        $symbol         = $request->symbol;
        $investment     = $request->investment;
        $price_purchase = $request->price_purchase;
        // dd(Auth::user()->id);
        

    //    if(!isset($symbol) || !isset($investment) || !isset($price_purchase)){
    //     return $this->error('Por favor preencha todos os campos', 400);
    //    }

    
    
    


       CoinsUser::create([
           'user_id' => Auth::user()->id,
           'symbol' => $symbol,
           'investment' => $investment,
           'price_purchase' => $price_purchase
       ]);



       return response()->json([
        'status' => 'Success',
        
    ], 200);


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
    public function destroy($id)
    {
        //
    }
}
