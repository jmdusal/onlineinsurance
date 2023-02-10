<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Salesrep extends Model
{
    protected $fillable = ['salesrep_name', 'salesrep_num', 'commission_percent', 'tax_rate', 'bonus'];
    protected $table = 'salesrep';
    protected $primaryKey = 'salesrep_id';
    public $timestamps = true;
}
