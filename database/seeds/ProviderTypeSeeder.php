<?php

use Illuminate\Database\Seeder;

class ProviderTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            [
                'name' => 'Broadband Provider',
            ],
            [
                'name' => 'Energy Provider',
            ]
        ];
        //
        DB::table('provider_type')->insert($types);
    }
}
