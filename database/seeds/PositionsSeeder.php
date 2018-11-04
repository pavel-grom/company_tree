<?php

use Illuminate\Database\Seeder;

class PositionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $positions = [
            [
                'slug' => 'cleaner',
                'name' => 'Cleaner',
            ],
            [
                'slug' => 'locksmith',
                'name' => 'Locksmith',
            ],
            [
                'slug' => 'steward',
                'name' => 'Steward',
            ],
            [
                'slug' => 'chief_steward',
                'name' => 'Chief steward',
            ],

            [
                'slug' => 'junior_developer',
                'name' => 'Junior developer',
            ],
            [
                'slug' => 'middle_developer',
                'name' => 'Middle developer',
            ],
            [
                'slug' => 'senior_developer',
                'name' => 'Senior developer',
            ],
            [
                'slug' => 'development_team_manager',
                'name' => 'Development team manager',
            ],

            [
                'slug' => 'junior_engineer',
                'name' => 'Junior engineer',
            ],
            [
                'slug' => 'middle_engineer',
                'name' => 'Middle engineer',
            ],
            [
                'slug' => 'senior_engineer',
                'name' => 'Senior engineer',
            ],
            [
                'slug' => 'engineering_team_manager',
                'name' => 'Engineering team manager',
            ],

            [
                'slug' => 'accountant',
                'name' => 'Accountant',
            ],
            [
                'slug' => 'chief_accountant',
                'name' => 'Chief accountant',
            ],

            [
                'slug' => 'middle_manager',
                'name' => 'Middle manager',
            ],

            [
                'slug' => 'senior_manager',
                'name' => 'Senior manager',
            ],

            [
                'slug' => 'technical_director',
                'name' => 'Technical director',
            ],
            [
                'slug' => 'financial_director',
                'name' => 'Financial director',
            ],
            [
                'slug' => 'general_director',
                'name' => 'General director',
            ],
        ];

        collect($positions)->map(function($position){
            \App\Models\Position::firstOrCreate($position);
        });
    }
}
