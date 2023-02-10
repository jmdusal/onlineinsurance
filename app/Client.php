<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = ['client_name', 'client_email', 'client_commission', 'payroll_id'];
    protected $table = 'client';
    protected $primaryKey = 'client_id';
    public $timestamps = true;
}
