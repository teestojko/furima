<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'reported_product_id',
        'reported_user_id',
        'reporter_user_id',
        'reason',
        'comment',
    ];

    public function reportedProduct()
    {
        return $this->belongsTo(Product::class, 'reported_product_id');
    }

    public function reportedUser()
    {
        return $this->belongsTo(User::class, 'reported_user_id');
    }

    public function reporter()
    {
        return $this->belongsTo(User::class, 'reporter_user_id');
    }
}


