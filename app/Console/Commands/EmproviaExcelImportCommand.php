<?php

namespace App\Console\Commands;

use App\Imports\EmproviaImport;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class EmproviaExcelImportCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'excel:import
                            {--from= : The path to the Excel file}
                            {--sheets= : Sheets to import, separated by commas}
                            {--to= : Corresponding import classes, separated by commas}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import data from an Excel file to specified tables';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $fromPath = $this->option('from');
        $sheets = explode(',', $this->option('sheets'));
        $to = explode(',', $this->option('to'));

        if (count($sheets) !== count($to)) {
            $this->error('The number of sheets and to classes must match.');

            return self::FAILURE;
        }

        $sheetToClassMap = array_map(function ($class) {
            $class = 'App\\Imports\\' . $class;
            if (!class_exists($class)) {
                $this->error("Class $class does not exist.");

                return $class;
            }

            return new $class();

        }, array_combine($sheets, $to));

        Log::info('========== STARTING EXCEL IMPORT PROCESS ==========');

        Excel::import(new EmproviaImport($sheetToClassMap), $fromPath);

        Log::info('============ END EXCEL IMPORT PROCESS =============');

        return self::SUCCESS;

    }
}
