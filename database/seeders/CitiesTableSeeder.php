<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Console\Helper\ProgressBar;
use Illuminate\Support\LazyCollection;
use Illuminate\Support\Facades\DB;

class CitiesTableSeeder extends Seeder
{
    public function run(): void
    {
        // Correct path to the CSV file
        $path = storage_path('app/cities.xlsx');

        if (! file_exists($path)) {
            $this->error("File not found at: {$path}");
            return;
        }

        // Open the file for reading
        $stream = fopen($path, 'r');
        if (!$stream) {
            $this->error("Unable to open file: {$path}");
            return;
        }

        // Skip the header row if it exists
        fgetcsv($stream);

        $rows = $this->csvRows($stream);
        $progress = $this->initProgressBar($path);

        // Seed the cities
        $this->seedCities($rows, $progress);

        fclose($stream);
    }

    protected function csvRows($stream): LazyCollection
    {
        return LazyCollection::make(function () use ($stream) {
            while (($row = fgetcsv($stream)) !== false) {
                yield $row;
            }
        });
    }

    protected function initProgressBar(string $filePath): ProgressBar
    {
        // Count lines in the CSV and initialize the progress bar
        $total = max(0, $this->countLines($filePath) - 1); // Exclude the header row
        $bar = $this->command->getOutput()->createProgressBar($total);
        $bar->start();

        return $bar;
    }

    protected function seedCities(LazyCollection $rows, ProgressBar $bar): void
    {
        $batch = [];
        $batchSize = 1000;
        $total = 0;

        // Loop through each row and insert the data
        foreach ($rows as $row) {
            $bar->advance();

            // Skip rows that have fewer than 3 columns
            if (count($row) < 3) {
                $this->error("Skipping invalid row: " . json_encode($row));
                continue;
            }

            // Safely extract the values from the row
            [$id, $name, $stateId] = $row;

            // Validate state_id
            if (!DB::table('states')->where('id', $stateId)->exists()) {
                $this->error("Invalid state_id '{$stateId}' for city '{$name}' - Skipping this row.");
                continue;
            }

            // Prepare the data for insertion
            $batch[] = [
                'id' => (int) trim($id),
                'name' => trim($name),
                'state_id' => (int) $stateId,
            ];

            // Insert in batches of 1000
            if (count($batch) === $batchSize) {
                $total += $this->insertBatch($batch);
                $batch = [];
            }
        }

        // Insert any remaining rows that haven't been inserted yet
        if (!empty($batch)) {
            $total += $this->insertBatch($batch);
        }

        $bar->finish();
        $this->info("\nSeeded {$total} cities successfully.");
    }

    protected function insertBatch(array $batch): int
    {
        try {
            // Insert the batch of cities
            City::insert($batch);
            return count($batch);
        } catch (\Exception $e) {
            // If something fails, log the error
            $this->error('Failed to insert batch: ' . $e->getMessage());
            return 0;
        }
    }

    protected function countLines(string $filePath): int
    {
        // Count the number of lines in the CSV file
        $handle = fopen($filePath, 'rb');
        $lines = 0;

        while (!feof($handle)) {
            $lines += substr_count(fread($handle, 8192), "\n");
        }

        fclose($handle);

        return $lines;
    }

    protected function error(string $message): void
    {
        $this->command->error("❌ {$message}");
    }

    protected function info(string $message): void
    {
        $this->command->info("✅ {$message}");
    }
}
