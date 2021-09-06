<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entity extends Model
{
    use HasFactory;

    public $table="entity";
    
    public $fillable = [
        'entitytype_id',
        'created_at',
        'updated_at',
    ];
}
