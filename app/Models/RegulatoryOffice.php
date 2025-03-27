<?php

namespace App\Models;

use App\Models\Departments;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RegulatoryOffice extends Model
{
    use HasFactory;
    protected $table = 'regulatoryofficer';
    protected $fillable = ['firstname', 'lastname', 'middlename', 'contact', 'status', 'image', 'position', 'address', 'age', 'gender','user_id'];

    // public function departments()
    // {
    //     return $this->belongsTo(Departments::class, 'department_id');
    // }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
