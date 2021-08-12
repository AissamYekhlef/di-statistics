<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    use HasFactory;

    public $table = 'Field';


    public $fillable = [
        'name',
        'label',
        'fieldtype_id',
        'fieldtype',
        'tooltip',
        'description',
        'hidden',
        'read_only',
        'sensitive'
    ];

    public function _entitytypes()
    {
        return $this->belongsToMany(EntityType::class, 'fieldentitytype', 'field_id', 'entitytype_id')->withPivot('position')->withTimestamps();
    }
}
