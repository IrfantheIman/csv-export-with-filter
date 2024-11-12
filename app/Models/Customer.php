<?php

// app/Models/Customer.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    // Add any fields that should be mass-assignable here
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'created_at',
    ];
}
