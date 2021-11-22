<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Entity extends Model
{
    use HasFactory;

    public $table="entity";
    
    public $fillable = [
        'entitytype_id',
        'created_at',
        'updated_at',
    ];

    public function _fields()
    {
        return $this->belongsToMany(Field::class, 'fieldentitytype', 'entitytype_id', 'field_id', 'entitytype_id');
    }

    public static function getSeries($entitytype_id, $period, $date_from, $date_to){
        $group_by_list = ['year'];

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

        // return $group_by_list;

        $series = DB::table('entity')
                ->where('entitytype_id','=', $entitytype_id)
                ->whereBetween('created_at', [$date_from, $date_to])
                ->select(
                    DB::raw('count(id) as `count`'), 
                    DB::raw($rows)
                    )
                ->groupby($group_by_list)
                ->get();

        return $series;
    }
}
