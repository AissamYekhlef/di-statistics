<?php

namespace App\Models\Fields;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FieldFixedChoice extends Model
{
    use HasFactory;

    public $table = "fixed_choice_value";

    static function getValues($entitytype_id, $field_id){
        
        return self::where('entitytype_id', $entitytype_id)
            // ->andWhere('entity_id', $entity_id)
            ->where('field_id', $field_id)
            ->get()
        ;
    }

}
