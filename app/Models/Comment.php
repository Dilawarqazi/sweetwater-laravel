<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $table = 'sweetwater_test';
    protected $primaryKey = 'orderid';
    protected $fillable = ['comments', 'shipdate_expected'];

    // Scope to filter comments for processing
    public function scopePendingShipDate($query)
    {
        return $query->where('shipdate_expected', '0000-00-00 00:00:00')
                     ->where('comments', 'LIKE', '%expected ship date%');
    }
}
