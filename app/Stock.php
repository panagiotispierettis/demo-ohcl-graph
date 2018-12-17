<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{

  protected $table = "stocks";
  protected $fillable = ['symbol','name'];
  public $timestamps = false;

  public function prices()
  {

    return $this->hasMany('App\Price');

  }

}
