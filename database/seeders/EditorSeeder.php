<?php

namespace Database\Seeders;

use App\Models\Editor;
use Illuminate\Database\Seeder;

class EditorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Editor::create([
            'name' => 'editor',
            'email' => 'editor@editor.com',
            'phone' => '0993571144',
            'password' => 'p@$$word',
        ]);

        Editor::factory()->count(3)->create();
    }
}
