<?php

namespace App\Models;

use App\Models\Client;
use App\Models\BfpStatus;
use App\Models\BucoStatus;
use App\Models\RequestStatus;
use App\Models\PermitCategory;
use App\Models\TypesOfPermits;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RequestList extends Model
{
    use HasFactory;

    protected $table='request_lists';
    protected $fillable = ['id','client_id','permit_id','request_status_id','category_id','bfp_status','buco_status','health_status','cleanro_status','generated_status','requirements'];

    // public function users() {
    //     return $this->belongsTo(User::class, 'user_id');
    // }
    public function client() {
        return $this->belongsTo(Client::class, 'client_id');
    }
    public function permit() {
        return $this->belongsTo(TypesOfPermits::class, 'permit_id');
    }
    public function status() {
        return $this->belongsTo(RequestStatus::class, 'request_status_id');
    }
    public function category() {
        return $this->belongsTo(PermitCategory::class, 'category_id');
    }

    // public function bfpstatus() {
    //     return $this->belongsTo(BfpStatus::class, 'bfp_id');
    // }

    // public function bucostatus() {
    //     return $this->belongsTo(BucoStatus::class, 'buco_id');
    // }

    // public function cleanrostatus() {
    //     return $this->belongsTo(CleanroStatus::class, 'cleanro_id');
    // }
}
