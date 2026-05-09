<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomizationGroup extends Model
{
    protected $fillable = ['menu_item_id', 'name', 'required', 'max_selections'];

    public function menuItem()
    {
        return $this->belongsTo(MenuItem::class);
    }

    public function options()
    {
        return $this->hasMany(CustomizationOption::class);
    }
}