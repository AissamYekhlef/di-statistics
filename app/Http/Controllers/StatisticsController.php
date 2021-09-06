<?php

namespace App\Http\Controllers;

use App\Models\EntityType;
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
        $entitytype_id = $request->entitytype_id;

        $entitytype = EntityType::find($entitytype_id);
        $count = $entitytype->_fields->count();
        $count_of_entitytypes_with_field_id = DB::table('fieldentitytype')->where('field_id', $field_id)->count();
        $count_of_entities = $entitytype->_entities->count();

        $group_by_list = ['year'];

        $rows = $this->getRowsFromSelectedPeriod($period);

        $series = DB::table('entity')
                ->where('entitytype_id','=', $entitytype_id)
                ->whereBetween('created_at', [$date_from, $date_to])
                ->select(
                    DB::raw('count(id) as `count`'), 
                    DB::raw($rows)
                    )
                ->groupby($group_by_list)
                ->get();

        return [
            "date_from" => $request->date_from,
            "date_to" => $request->date_to,
            "period" => $request->period,
            "field_id" => $request->field,
            "entitytype_id" => $request->entitytype,
            "all_fields_count" => $count, 
            "entitytypes_count" => $count_of_entitytypes_with_field_id,
            "count_of_entities" => $count_of_entities,
            "series" => $series
        ];

        // dd(
        //     $validtated,
        //     $date_from,
        //     $date_to,
        //     $period,
        //     $field_id,
        //     $entitytype_id
        // );

    }

    public function getRowsFromSelectedPeriod($period){
        $rows = "YEAR(created_at) year"; 
        if($period != "yearly"){
            $rows .= ", MONTH(created_at) month";
            array_push($group_by_list, 'month');
        }  

        if($period == "weekly"){
            $rows .= ", WEEK(created_at) week";
            array_push($group_by_list, 'week');
        }   

        if($period == "daily"){
            $rows .= ", DAY(created_at) day";
            array_push($group_by_list, 'day');
        }

        if($period == "hourly"){
            $rows .= ", DAY(created_at) day";
            array_push($group_by_list, 'day');

            $rows .= ", Hour(created_at) hour";
            array_push($group_by_list, 'hour');
        }

        return $rows;
    }
}
