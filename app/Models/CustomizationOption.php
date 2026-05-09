<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomizationOption extends Model
{
    protected $fillable = ['customization_group_id', 'name', 'price_modifier'];

    public function group()
    {
        return $this->belongsTo(CustomizationGroup::class, 'customization_group_id');
    }
}