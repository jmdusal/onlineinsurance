<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    protected $fillable = ['date_period', 'payroll_bonus', 'salesrep_id'];
    protected $table = 'payroll';
    protected $primaryKey = 'payroll_id';
    public $timestamps = true;
}
