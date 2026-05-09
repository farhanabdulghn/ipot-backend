<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Restaurant
        $restaurantId = DB::table('restaurants')->insertGetId([
            'name' => 'Sushi Zen',
            'slug' => 'sushi-zen',
            'created_at' => now(), 'updated_at' => now(),
        ]);

        // Table
        $tableId = DB::table('tables')->insertGetId([
            'restaurant_id' => $restaurantId,
            'table_code' => 'T001',
            'status' => 'available',
            'created_at' => now(), 'updated_at' => now(),
        ]);

        // Categories
        $catAppetizer = DB::table('categories')->insertGetId([
            'restaurant_id' => $restaurantId, 'name' => 'Appetizers', 'sort_order' => 1,
            'created_at' => now(), 'updated_at' => now(),
        ]);
        $catMain = DB::table('categories')->insertGetId([
            'restaurant_id' => $restaurantId, 'name' => 'Main Course', 'sort_order' => 2,
            'created_at' => now(), 'updated_at' => now(),
        ]);
        $catDrinks = DB::table('categories')->insertGetId([
            'restaurant_id' => $restaurantId, 'name' => 'Drinks', 'sort_order' => 3,
            'created_at' => now(), 'updated_at' => now(),
        ]);

        // Menu Items
        $edamame = DB::table('menu_items')->insertGetId([
            'category_id' => $catAppetizer, 'name' => 'Edamame',
            'description' => 'Steamed soybeans with sea salt', 'price' => 5.99,
            'created_at' => now(), 'updated_at' => now(),
        ]);
        $salmon = DB::table('menu_items')->insertGetId([
            'category_id' => $catMain, 'name' => 'Salmon Sashimi',
            'description' => 'Fresh Norwegian salmon, 8 pieces', 'price' => 16.99,
            'created_at' => now(), 'updated_at' => now(),
        ]);
        $tea = DB::table('menu_items')->insertGetId([
            'category_id' => $catDrinks, 'name' => 'Green Tea',
            'description' => 'Hot Japanese green tea', 'price' => 3.50,
            'created_at' => now(), 'updated_at' => now(),
        ]);
        $ramen = DB::table('menu_items')->insertGetId([
            'category_id' => $catMain, 'name' => 'Chicken Ramen',
            'description' => 'Rich chicken broth with chashu, egg, and noodles', 'price' => 14.99,
            'created_at' => now(), 'updated_at' => now(),
        ]);

        // Customization Groups & Options
        // Edamame - Seasoning
        $seasoning = DB::table('customization_groups')->insertGetId([
            'menu_item_id' => $edamame, 'name' => 'Seasoning',
            'required' => false, 'max_selections' => 2,
            'created_at' => now(), 'updated_at' => now(),
        ]);
        foreach ([
            ['Sea Salt', 0], ['Truffle Salt', 1.50], ['Chili Flakes', 0.50]
        ] as $opt) {
            DB::table('customization_options')->insert([
                'customization_group_id' => $seasoning, 'name' => $opt[0], 'price_modifier' => $opt[1],
                'created_at' => now(), 'updated_at' => now(),
            ]);
        }

        // Salmon - Size
        $size = DB::table('customization_groups')->insertGetId([
            'menu_item_id' => $salmon, 'name' => 'Size',
            'required' => true, 'max_selections' => 1,
            'created_at' => now(), 'updated_at' => now(),
        ]);
        foreach ([['Regular (8pc)', 0], ['Large (12pc)', 8.00]] as $opt) {
            DB::table('customization_options')->insert([
                'customization_group_id' => $size, 'name' => $opt[0], 'price_modifier' => $opt[1],
                'created_at' => now(), 'updated_at' => now(),
            ]);
        }

        // Ramen - Spice Level
        $spice = DB::table('customization_groups')->insertGetId([
            'menu_item_id' => $ramen, 'name' => 'Spice Level',
            'required' => true, 'max_selections' => 1,
            'created_at' => now(), 'updated_at' => now(),
        ]);
        foreach ([['Mild',0],['Medium',0],['Spicy',0],['Extra Spicy',1.00]] as $opt) {
            DB::table('customization_options')->insert([
                'customization_group_id' => $spice, 'name' => $opt[0], 'price_modifier' => $opt[1],
                'created_at' => now(), 'updated_at' => now(),
            ]);
        }

        // Ramen - Add-ons
        $addons = DB::table('customization_groups')->insertGetId([
            'menu_item_id' => $ramen, 'name' => 'Add-ons',
            'required' => false, 'max_selections' => 3,
            'created_at' => now(), 'updated_at' => now(),
        ]);
        foreach ([['Extra Egg',2.00],['Extra Chashu',4.00],['Corn',1.00]] as $opt) {
            DB::table('customization_options')->insert([
                'customization_group_id' => $addons, 'name' => $opt[0], 'price_modifier' => $opt[1],
                'created_at' => now(), 'updated_at' => now(),
            ]);
        }
    }
}