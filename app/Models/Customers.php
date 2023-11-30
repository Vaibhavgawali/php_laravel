<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    use HasFactory;
     
    protected $table="customers";
    protected $primaryKey="customer_id";

    protected $fillable=[
        'name',
        'email',
        'phone',
        'age',
        'gender',
        'password',
        'address',
        'country',
        'state',
        'dob'
    ];

}
