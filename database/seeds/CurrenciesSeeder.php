<?php

use App\Currency;
use Illuminate\Database\Seeder;
use League\Csv\Reader;

class CurrenciesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $currencies = $this->importFile();
        $this->persistCurrencies($currencies);

        $shouldEnable = ['COP', 'USD', 'EUR', 'BRL'];
        Currency::whereIn('id', $shouldEnable)->update(['enabled_at' => now()]);
    }

    public function importFile()
    {
        $currencies = collect();

        // this file is taken from https://datahub.io/core/currency-codes
        $csv = Reader::createFromPath(base_path('resources/docs/currency-codes.csv'), 'r');
        $csv->setHeaderOffset(0);
        foreach ($csv->getRecords() as $record) {
            $currencies->push(collect([
                'entity' => $record['Entity'],
                'currency' => $record['Currency'],
                'alphabetic_code' => $record['AlphabeticCode'],
                'numeric_code' => str_pad($record['NumericCode'], 3, '0', STR_PAD_LEFT),
                'minor_unit' => preg_match('/^\d+$/', $record['MinorUnit']) ? $record['MinorUnit'] : null,
            ]));
        }

        return $currencies;
    }

    public function persistCurrencies($currencies)
    {
        $currencies
            ->filter(function ($currency) {
                return (bool)$currency->get('currency')
                    && (bool)$currency->get('alphabetic_code')
                    && (bool)$currency->get('numeric_code');
            })
            ->unique('numeric_code')
            ->each(function ($currency) {
                Currency::firstOrcreate([
                    'alpha_code' => $currency->get('alphabetic_code'),
                    'currency' => $currency->get('currency'),
                    'numeric_code' => $currency->get('numeric_code'),
                    'minor_unit' => $currency->get('minor_unit'),
                ]);
            });

        return true;
    }
}
