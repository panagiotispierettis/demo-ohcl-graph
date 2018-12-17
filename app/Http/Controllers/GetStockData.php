<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Stock;

class GetStockData extends Controller
{

  const MAX_MONTHS_INTERVAL = 6;

  public function info(Request $request)
  {

    $validRequestParms = $request->validate([
      'stockSymbol' => 'bail|required|max:10|alpha_num'
    ]);

    $stockInfo = [];

    $stock = Stock::where('symbol',$validRequestParms['stockSymbol'])->first();

    if(empty($stock)){
      return response()->json($stockInfo);
    }

    $stockInfo['name'] = $stock->name;
    $stockInfo['symbol'] = $stock->symbol;

    return response()->json($stockInfo);

  }

  public function prices(Request $request)
  {

    $validRequestParms = $request->validate([
      'stockSymbol' => 'bail|required|max:10|alpha_num',
      'dateFrom' => 'nullable|date_format:Y-m-d',
      'dateTo' => 'nullable|date_format:Y-m-d'
    ]);

    $stockPrices = [];

    $now = date('Y-m-d');

    $intervalFilter = [
      'to' => $now
    ];

    $intervalFilter['from'] = date('Y-m-d',strtotime("-1 month"));

    $reqInterval = $intervalFilter;

    if( !empty($validRequestParms['dateFrom']) ){
      $reqInterval['from'] = $validRequestParms['dateFrom'];
    }

    if( !empty($validRequestParms['dateTo']) ){
      $reqInterval['to'] = $validRequestParms['dateTo'];
    }

    if( $this->dateIntervalValidate($reqInterval['from'],$reqInterval['to']) ){
      $intervalFilter = $reqInterval;
    }

    $stock = Stock::where('symbol',$validRequestParms['stockSymbol'])->first();

    if(empty($stock)){
      return response()->json($stockPrices);
    }

    if( !empty($stock->prices) ){
      $stockPricesResult = $stock->prices()
      ->whereBetween('date',[$intervalFilter['from'],$intervalFilter['to']])
      ->orderBy('date','asc')
      ->get();

      $stockPrices = $this->formatStockPices($stockPricesResult->toArray());

    }

    return response()->json($stockPrices);

  }

  private function formatStockPices($stockPrices){

    $formattedStockPrices = [];

    if( empty($stockPrices) || !is_array($stockPrices) ){

      return $formattedStockPrices;

    }

    $formattedStockPrices['cols'] = [
        ['type' => 'date'],
        ['type' => 'number'],
        ['type' => 'number'],
        ['type' => 'number'],
        ['type' => 'number']
    ];

    $formattedStockPrices['rows']=[];


    foreach ($stockPrices as $pricesRow) {
      $validator = Validator::make($pricesRow,[
        'date' => 'bail|required|date_format:Y-m-d',
        'open' => 'bail|required|numeric',
        'high' => 'bail|required|numeric',
        'close' => 'bail|required|numeric',
        'low' => 'required|numeric'
      ]);

      if(!$validator->fails()){
        $date = $this->formatDate($pricesRow['date']);
        $formattedStockPrices['rows'][]['c'] = [
          ['v' => $date],
          ['v' => $pricesRow['low']],
          ['v' => $pricesRow['open']],
          ['v' => $pricesRow['close']],
          ['v' => $pricesRow['high']]
        ];
      }
    }

    return $formattedStockPrices;

  }

  private function dateIntervalValidate($from,$to){

    $dateFrom  = new \DateTime($from);
    $dateTo  = new \DateTime($to);

    if($dateFrom <= $dateTo){
      $interval = $dateTo->diff($dateFrom);
      $monthInterval =  $interval->format('%m');
      if(is_numeric($monthInterval) && $monthInterval<=self::MAX_MONTHS_INTERVAL){
        return true;
      }
    }

    return false;

  }

  private function formatDate($date){

    $timestamp = strtotime($date);
    $year = date('Y',$timestamp);
    $month = date('n',$timestamp);
    $month = $month - 1;
    $day = date('j',$timestamp);
    $formattedDate = $year.', '.$month.', '.$day;
    $formattedDate = 'Date('.$formattedDate.')';

    return  $formattedDate;
  }

}
