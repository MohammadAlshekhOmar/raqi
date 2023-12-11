<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // START ARTICLES
        Permission::create([
            'name' => 'VIEW_ARTICLES',
            'name_ar' => 'عرض المقالات',
            'group' => 'المقالات',
            'guard_name' => 'editor',
        ]);
        Permission::create([
            'name' => 'CREATE_ARTICLES',
            'name_ar' => 'إضافة مقال',
            'group' => 'المقالات',
            'guard_name' => 'editor',
        ]);
        Permission::create([
            'name' => 'UPDATE_ARTICLES',
            'name_ar' => 'تعديل مقال',
            'group' => 'المقالات',
            'guard_name' => 'editor',
        ]);
        Permission::create([
            'name' => 'DELETE_ARTICLES',
            'name_ar' => 'حذف مقال',
            'group' => 'المقالات',
            'guard_name' => 'editor',
        ]);
        // END ARTICLES
    }
}
