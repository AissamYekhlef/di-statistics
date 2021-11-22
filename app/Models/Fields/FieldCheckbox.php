<?php

namespace App\Models\Fields;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FieldCheckbox extends Model
{
    use HasFactory;

    public $table = "boolean_value";

}
