<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Choice extends Model
{
    use HasFactory;

    public $table = "choice";

    public function _choiceCategory()
    {
        return $this->belongsTo(ChoiceCategory::class, 'choicecategory_id');
    }
}
