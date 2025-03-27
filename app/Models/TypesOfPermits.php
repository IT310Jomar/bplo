<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypesOfPermits extends Model
{
    use HasFactory;

    protected $table='types_of_permits';
    protected $fillable = ['name','department_id'];

    public function department() {
        return $this->belongsTo(Departments::class, 'department_id');
    }
}
