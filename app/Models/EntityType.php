<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntityType extends Model
{
    use HasFactory;

    public $table ="EntityType";

    public function _fields()
    {
        return $this->belongsToMany(Field::class, 'fieldentitytype', 'entitytype_id', 'field_id')->withTimestamps();
    }


    public function _entities()
    {
        return $this->hasMany(Entity::class, 'entitytype_id');
    }
}
