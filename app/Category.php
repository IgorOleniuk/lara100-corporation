<?php

namespace Corp;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['category_id'];

    public function articles() {
      return $this->hasMany('Corp\Article');
    }
}
