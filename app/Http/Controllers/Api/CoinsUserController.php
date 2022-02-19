<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ApiResponser;
use App\Models\CoinsUser;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;



class CoinsUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      
        $coins     = CoinsUser::where('user_id', '=' , Auth::user()->id)->get();
        $coinsData = $this->calculateCoin($coins);
        
        return response()->json([$coinsData]);
       
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
        $coin[] = CoinsUser::findOrFail($id);
        $coinData = $this->calculateCoin($coin);
        return $coinData;
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
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $coin = CoinsUser::findOrFail($id);
        $result = $coin->delete();
        if($result){

        }else{

        }
        
    }

    public function calculateCoin($coins){
        
        $cliente = new Client();
        
        $coinsResult = [];

        foreach($coins as $coin) {
            
            $symbol   = $coin->symbol;
            $response = $cliente->request('GET', 'https://api.binance.com/api/v3/avgPrice?symbol='.$symbol); 

            $currentPrice = json_decode($response->getBody()->getContents())->price; 
            $reason       = $currentPrice / $coin->price_purchase;
            $grossProfit  = $reason * $coin->investment;
            $netProfit    = $grossProfit - $coin->investment;
            $valuation    = ($reason -1 ) * 100;
            $coinResult   = [
                                'symbol'       => $symbol, 
                                'currentPrice' => $currentPrice, 
                                'grossProfit'  => $grossProfit, 
                                'netProfit'    => $netProfit, 
                                'valuation'    => $valuation
                            ]; 

            array_push($coinsResult, $coinResult);
        }
       
        return $coinsResult; 
       
    }
}
