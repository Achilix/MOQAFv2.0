<?php

namespace App\Console\Commands;

use App\Models\City;
use App\Models\Country;
use Illuminate\Console\Command;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ImportCitiesFromExcel extends Command
{
    protected $signature = 'import:cities {file : Path to the Excel file}';
    protected $description = 'Import cities and countries from an Excel file (Column A = City, Column E = Country)';

    public function handle(): int
    {
        $filePath = $this->argument('file');

        if (!file_exists($filePath)) {
            $this->error("File not found: $filePath");
            return 1;
        }

        try {
            $spreadsheet = IOFactory::load($filePath);
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray();

            // Skip header row
            $dataRows = array_slice($rows, 1);

            foreach ($dataRows as $row) {
                // Column A is index 0, Column E is index 4
                if (empty($row[0]) || empty($row[4])) {
                    continue;
                }

                $cityName = trim($row[0]);
                $countryName = trim($row[4]);

                // Create or get country
                $country = Country::firstOrCreate(
                    ['name' => $countryName],
                    ['name' => $countryName]
                );

                // Create city if it doesn't exist
                City::firstOrCreate(
                    ['name' => $cityName, 'country_id' => $country->id],
                    ['name' => $cityName, 'country_id' => $country->id]
                );
            }

            $this->info('Cities and countries imported successfully!');
            return 0;
        } catch (\Exception $e) {
            $this->error('Error importing file: ' . $e->getMessage());
            return 1;
        }
    }
}
