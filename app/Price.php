<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{

  protected $table = "prices";
  protected $fillable = ['stock_id','open','high','close','low','date'];
  public $timestamps = false;

  public function stock()
  {

    return $this->belongsTo('App\Stock');

  }

}
