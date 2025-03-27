<?php

namespace App\Models;

use App\Models\RequestList;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GeneratedHistory extends Model
{
    use HasFactory;

    protected $table='generated_history_list';
    protected $fillable = ['request_list_id'];


    public function requestlist()
    {
        return $this->belongsTo(RequestList::class, 'request_list_id');
    }
}
