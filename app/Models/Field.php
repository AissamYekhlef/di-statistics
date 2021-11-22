<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Boolean;

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

    public static function getValuesByTableName($table_name, $entitytype_id, $field_id){



        
        $field_statistics  =  DB::table($table_name)
                                ->where('entitytype_id', '=', $entitytype_id)
                                ->where('field_id', '=', $field_id)         
                                ->select(
                                    DB::raw('count(value) as `count`,entitytype_id, field_id,  value')
                                    )
                                ->groupby(['entitytype_id', 'field_id', 'value'])
                                ->orderBy('value')           
                                ->get();
        return $field_statistics;                        
    }

    public static function getStatistics($entitytype_id, $field_id){

        $field = Field::find($field_id);

        switch ($field->fieldtype) {
            case "FIXED":
                $field_statistics = Field::getValuesByTableName('fixed_choice_value', $entitytype_id, $field_id);
                foreach ($field_statistics as $field) {
                    $field->value = Choice::find($field->value)->value;
                }
               
                break;
            case "FOREIGN":
                $field_statistics = Field::getValuesByTableName('foreign_value', $entitytype_id, $field_id);
                foreach ($field_statistics as $field) {
                    $field->value = DB::table('unique_value')
                                    ->where('entity_id', '=', $field->value)
                                    ->first()->value;                 
                }
                break;
            case "BASIC":
                if($field->fieldtype_id = 9){ //boolean
                    $field_statistics = Field::getValuesByTableName('boolean_value', $entitytype_id, $field_id);
                    foreach ($field_statistics as $field) {
                        $field->value = $field->value ? 'True' : 'False';               
                }
                }
                break;
        }

        return $field_statistics;
    }

    
}
