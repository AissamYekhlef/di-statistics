<?php

namespace App\Http\Controllers;

use App\Models\Field;
use Illuminate\Http\Request;

class FieldController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fields = [];
        if(request('entitytype')){
            $fields = Field::where('entitytype_id', '=', request('entitytype'))->get();
        }else { 
            $fields = Field::all();
        }
        return $fields;
        // return 'Fields List';
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Field  $field
     * @return \Illuminate\Http\Response
     */
    public function show(Field $field)
    {
        //
    }

    public function fieldsByFieldType($fieldtype)
    {
        return Field::where('fieldtype', $fieldtype)->get();
    }

    public function fieldsByFieldTypeId($fieldtype_id)
    {
        return Field::where('fieldtype_id', $fieldtype_id)->get();
    }

}
