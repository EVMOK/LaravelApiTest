<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mails extends Model
{
    use HasFactory;

    /** @var bool */
    public $timestamps = false;
    /** @var array */
    protected $fillable = [
        'id',
        'domain_id',
        'subject',
        'unisender_send_date_at',
        'created_at'
    ];
}
