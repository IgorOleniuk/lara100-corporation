<?php

namespace Corp;

use Illuminate\Database\Eloquent\Model;

class Filter extends Model
{
    protected $guarded = [];
    protected $table = 'filters';

    public function portfolio() {
      return $this->hasMany('\Corp\Portfolio');
    }
}
