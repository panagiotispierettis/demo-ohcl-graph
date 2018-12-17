<?php

namespace App\Library\Services;
use Illuminate\Support\Facades\DB;
use App\Stock;
use App\Price;


class PopulateDbService
{

  public function stocks(){

    $baseStockSymbol = 'STOCK';
    $baseStockName = 'Stock Name ';

    $records = [];
    for ($i=1; $i < 20; $i++) {
      $records[] = [
        'symbol' => $baseStockSymbol.$i,
        'name' => $baseStockName.$i
      ];
    }

    Stock::insert($records);

  }

  public function prices(){

    $stocks = Stock::take(20)->get();

    foreach ($stocks as $stock) {
      $pricesRecord=[];
      for ($i=1; $i <30 ; $i++) {
        $timestamp = strtotime("-${i} day");
        $date = date('Y-m-d',$timestamp);
        $prices = $this->ohcl();
        $pricesRecord[]=[
          'stock_id' => $stock->id,
          'date' => $date,
          'open' => $prices['open'],
          'high' => $prices['high'],
          'close' => $prices['close'],
          'low' => $prices['low']
        ];
      }
        Price::insert($pricesRecord);
    }
  }

  public function truncate()
  {
    DB::statement('truncate prices;');
  }

  private function ohcl(){

    $prices = [];

    $prices['low'] = rand(1,100);
    $prices['high'] = $prices['low'] + rand(1,10);
    $prices['open'] = rand($prices['low'],$prices['high']);
    $prices['close'] = rand($prices['low'],$prices['high']);

    return $prices;

  }


}
