<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $table = 'clients';
    protected $fillable = ['firstname', 'lastname', 'middlename', 'contact', 'password', 'email','image', 'address', 'gender'];
}
