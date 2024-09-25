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
        return $this->points >= 2000;
    }

    public function getIsGoldMemberAttribute()
    {
        return $this->goldMember();
    }


    public function orders()
    {
        return $this->hasMany(Order::class, 'customer_id', 'customer_id');
    }
}
