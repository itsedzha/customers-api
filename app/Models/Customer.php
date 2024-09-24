<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = "customers";

    protected $primaryKey = "customer_id";

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'customer_id',
        'first_name',
        'last_name',
        'birth_date',
        'phone',
        'address',
        'city',
        'state',
        'points',
    ];

    public $timestamps = false;

    protected $appends = ['is_gold_member'];

    public function goldMember()
    {
        $goldMemberPointsThreshold = 2000;
        return $this->points >= $goldMemberPointsThreshold;
    }
    public function getIsGoldMemberAttribute()
    {
        return $this->goldMember();
    }
}
