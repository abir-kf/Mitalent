<?php

namespace Database\Seeders;
use DB;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        
        DB::table('categories')->insert([
            'categorie' => 'Comédien'

        ]);

         
        DB::table('categories')->insert([
            'categorie' => 'Chanteur'

        ]);

         
        DB::table('categories')->insert([
            'categorie' => 'Danceur'

        ]);

         
        DB::table('categories')->insert([
            'categorie' => 'Dj'

        ]);

         
        DB::table('categories')->insert([
            'categorie' => 'Hote/Hottesse'

        ]);

         
        DB::table('categories')->insert([
            'categorie' => 'Influenceur'

        ]);

         
        DB::table('categories')->insert([
            'categorie' => 'Mannequin'

        ]);

        DB::table('statut')->insert([
            'statut' => 'Attente'

        ]);
        DB::table('statut')->insert([
            'statut' => 'Validé'

        ]);
        DB::table('statut')->insert([
            'statut' => 'Refusé'

        ]);
    }
}
