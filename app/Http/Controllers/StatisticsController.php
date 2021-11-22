<?php

namespace App\Http\Controllers;

use App\Models\Entity;
use App\Models\EntityType;
use App\Models\Field;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    public function field_statistics(Request $request){

        $date_from = $request->date_from;
        $date_to = $request->date_to;
        $period = $request->period;
        $field_id = $request->field_id;
        $enable_group = $request->enable_group;
        $entitytype_id = $request->entitytype_id;

        $entitytype = EntityType::find($entitytype_id);
        $count = $entitytype->_fields->count();
        $count_of_entitytypes_with_field_id = DB::table('fieldentitytype')->where('field_id', $field_id)->count();
        $count_of_entities = $entitytype->_entities->count();
        $field_statistics = null;

        if($enable_group == "enable"){
            $field_statistics = Field::getStatistics($entitytype_id, $field_id);
        }

        $series = Entity::getSeries($entitytype_id, $period, $date_from, $date_to);

        return [
            "date_from" => $request->date_from,
            "date_to" => $request->date_to,
            "period" => $request->period,
            "entitytype_id" => $request->entitytype_id,
            "field_id" => $request->field,
            "enable_group" => $request->enable_group,
            "all_fields_count" => $count, 
            "count_of_entitytypes_with_field_id" => $count_of_entitytypes_with_field_id,
            "count_of_entities" => $count_of_entities,
            "field_statistics" => $field_statistics,
            "series" => $series,
        ];

    }

}
