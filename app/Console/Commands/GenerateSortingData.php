<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;

class GenerateSortingData extends Command
{
    /**
     * @var string
     */
    protected $signature = 'sorting:generate
                            {count=200000 : Количество чисел}
                            {min=-1000000 : Минимальное значение}
                            {max=1000000  : Максимальное значение}';

    /**
     * @var string
     */
    protected $description = 'Генерирует data.txt файл с числами для сортировки';

    public function handle(): int
    {
        $count = (int)$this->argument('count');
        $min = (int)$this->argument('min');
        $max = (int)$this->argument('max');
        $path = storage_path('data/data.txt');

        $handle = fopen($path, 'w');

        try {
            for ($i = 0; $i < $count; $i++) {
                fwrite($handle, random_int($min, $max) . PHP_EOL);
            }
        } catch (Exception $e) {
            fclose($handle);
            $this->error('Ошибка генерации: ' . $e->getMessage());
            return self::FAILURE;
        }

        fclose($handle);

        $this->info("Сгенерировано $count чисел. Они в файле $path");

        return self::SUCCESS;
    }
}
