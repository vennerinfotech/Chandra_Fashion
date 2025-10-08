<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        //  Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        //  Truncate the tables
        DB::table('cities')->truncate();
        DB::table('states')->truncate();
        DB::table('countries')->truncate();

        // Enable foreign key checks again
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        //  Re-run the SQL files
        $sqlCountries = file_get_contents(database_path('sql/countries.sql'));
        DB::unprepared($sqlCountries);

        $sqlStates = file_get_contents(database_path('sql/states.sql'));
        DB::unprepared($sqlStates);

        $sqlCities = file_get_contents(database_path('sql/cities.sql'));
        DB::unprepared($sqlCities);
    }
}
