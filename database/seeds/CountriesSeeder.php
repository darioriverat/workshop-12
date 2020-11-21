<?php

use App\Country;
use Illuminate\Database\Seeder;
use League\Csv\Reader;

class CountriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countries = $this->importFile();
        $this->persistCountries($countries);

        $shouldEnable = [
            'COL', 'ECU', 'PER', 'CHL', 'ARG', 'BRA', 'MEX', 'USA', 'CAN',
            'ESP',
        ];

        Country::whereIn('alpha_3_code', $shouldEnable)->update(['enabled_at' => now()]);
    }

    public function importFile()
    {
        $countries = collect();

        // this file is taken from https://datahub.io/core/country-codes
        $csv = Reader::createFromPath(base_path('resources/docs/country-codes.csv'), 'r');
        $csv->setHeaderOffset(0);
        foreach ($csv->getRecords() as $record) {
            $countries->push(collect([
                'alpha_2_code' => $record['ISO3166-1-Alpha-2'],
                'name' => $record['official_name_es'] ? $record['official_name_es'] : $record['CLDR display name'],
                'dial_codes' => explode(',', $record['Dial']),
                'numeric_code' => str_pad($record['ISO3166-1-numeric'], 3, '0', STR_PAD_LEFT),
                'alpha_3_code' => $record['ISO3166-1-Alpha-3'],
            ]));
        }

        return $countries;
    }

    public function persistCountries($countries)
    {
        $countries->each(function ($country) {

            Country::firstOrcreate($country->toArray());
        });
    }
}
