<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChoiceCategory extends Model
{
    use HasFactory;
    public $table = "choicecategory";

    public function _fixedChoiceFielf()
    {
        return $this->hasMany(Entity::class, 'entitytype_id');    
    }

    public function _choices()
    {
        return $this->hasMany(Choice::class, 'choicecategory_id');  
    }
}
