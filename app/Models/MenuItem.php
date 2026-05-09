<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    protected $fillable = ['category_id', 'name', 'description', 'price', 'image_url', 'is_available'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function customizationGroups()
    {
        return $this->hasMany(CustomizationGroup::class);
    }
}