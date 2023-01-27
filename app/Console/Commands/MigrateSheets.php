<?php

namespace App\Console\Commands;

use App\Models\Part;
use App\Models\Sequence;
use App\Models\Sheet;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class MigrateSheets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sheets:migrate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate old sheets';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $sheets = $this->getSheets();
        Sheet::truncate();
        Part::truncate();
        Sequence::truncate();

        foreach ($sheets as $sheet) {
            $this->importSheet($sheet);
        }


        return Command::SUCCESS;
    }

    private function importSheet(array $oldSheet)
    {
        $sheet = new Sheet();
        $sheet->title = $oldSheet['title'];
        $sheet->artist = $oldSheet['artist'];
        $sheet->key = $oldSheet['key'];
        $sheet->description = str_replace('<br />', '', $oldSheet['additional_information'] ?? '');
        $sheet->duration = $this->durationToSeconds($oldSheet['duration']);
        $sheet->tempo = $oldSheet['tempo'];

        $date = $oldSheet['updated'] ? Carbon::parse($oldSheet['updated']) : Carbon::now();
        $sheet->created_at = $date;
        $sheet->updated_at = $date;

        $sheet->save();

        $user = User::where('name', $oldSheet['author'])->first();

        if ($user) {
            $sheet->user()->associate($user)->save();
        }


        foreach ($oldSheet['parts'] ?? [] as $key => $oldPart) {
            $oldPart['description'] = str_replace('<br />', '', $oldPart['description']);
            $oldPart['lyrics'] = str_replace('<br />', '', $oldPart['lyrics']);

            $advancedChordDescriptions = [];
            while (($lastChordDescriptionPosition = strrpos($oldPart['description'], '. Akkordfolge')) !== false) {
                $sequenceNumber = ((int) substr($oldPart['description'], $lastChordDescriptionPosition - 1, 1));
                $sequenceDescription = trim(str_replace(
                    '. Akkordfolge:',
                    '',
                    substr($oldPart['description'], $lastChordDescriptionPosition)
                ));

                $advancedChordDescriptions[$sequenceNumber] = $sequenceDescription;
                $oldPart['description'] = trim(substr($oldPart['description'], 0, $lastChordDescriptionPosition - 1));
            }

            $part = new Part();
            $part->name = $oldPart['name'];
            $part->position = $key;
            $part->description = $oldPart['description'];
            $part->lyrics = $oldPart['lyrics'];


            $sheet->parts()->save($part);

            foreach ($oldPart['patterns'] ?? [] as $key => $pattern) {
                $sequence = new Sequence();
                $sequence->position = $key;
                $sequence->quantity = $pattern['number'] ?: 1;
                $sequence->description = $advancedChordDescriptions[$key + 1] ?? null;
                $sequence->measures = array_map(function($measure) {
                    return [
                        'chords' => $measure,
                        'time_signature' => '4/4'
                    ];
                }, explode(' ', trim($pattern['chords'])));

                $part->sequences()->save($sequence);
            }
        }

        $this->line('Imported sheet ' . $sheet['title']);
    }


    private function getSheets(): array
    {
        $sheets = $this->getCsvData('sheets.csv');
        $parts = $this->getCsvData('parts.csv');
        $patterns = $this->getCsvData('patterns.csv');

        foreach ($patterns as $pattern) {
            $parts[$pattern['part_id']]['patterns'][] = $pattern;
        }
        foreach ($parts as $part) {
            $sheets[$part['sheet_id']]['parts'][] = $part;
        }

        return $sheets;
    }

    private function getCsvData(string $fileName): array
    {
        $fileName = storage_path('app/' . $fileName);
        $file = fopen($fileName, "r");
        $entries = [];
        $headers = [];

        while (($data = fgetcsv($file, 200)) !== false) {
            if (empty($headers)) {
                $headers = $data;
            } else {
//                if (count($headers) !== count($data)) {
//                    echo '<pre>';
//                    var_dump($data);
//                    die();
//                }
                $data = $this->extendArray($headers, $data);
                $data = array_combine($headers, $data);
                $entries[$data['id']] = $data;
            }
        }

        return $entries;
    }

    /**
     * Made by OpenAI
     */
    private function extendArray($array1, $array2)
    {
        $count1 = count($array1);
        $count2 = count($array2);
        if ($count2 < $count1) {
            $difference = $count1 - $count2;

            for ($i = 0; $i < $difference; $i++) {
                $array2[] = 0;
            }
        }

        return $array2;
    }

    /**
     * Made by OpenAI
     */
    private function durationToSeconds($duration): ?int
    {
        $durationArray = explode(':',$duration);

        if (!isset($durationArray[0]) || !isset($durationArray[1])) {
            return null;
        }

        $minutes = (int) $durationArray[0];
        $seconds = (int) $durationArray[1];
        return ($minutes * 60) + $seconds;
    }
}
