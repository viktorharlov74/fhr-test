<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Throwable;

class GeneratePersons extends Command
{
    /**
     * @var string
     */
    protected $signature = 'persons:generate
                            {count=500000 : Количество записей}
                            {chunk=5000  : Размер чанка вставки}';

    /**
     * @var string
     */
    protected $description = 'Генерирует тестовые записи в таблице persons';

    private array $firstNames = [
        'Александр',
        'Дмитрий',
        'Михаил',
        'Алексей',
        'Никита',
        'Андрей',
        'Павел',
        'Илья',
        'Виктор',
        'Сергей'
    ];
    private array $lastNames = [
        'Иванов',
        'Козлов',
        'Новиков',
        'Смирнов',
        'Волков',
        'Морозов',
        'Соколов',
        'Лебедев',
        'Попов',
        'Орлов'
    ];

    /**
     * @throws Throwable
     */
    public function handle(): int
    {
        $count    = (int) $this->argument('count');
        $chunk    = (int) $this->argument('chunk');
        $maxChunk = 10000;

        if ($chunk > $maxChunk) {
            $this->error("Размер чанка не может превышать $maxChunk.");
            return self::FAILURE;
        }

        $now = now();

        $this->info("Генерация $count записей чанками по $chunk...");
        $bar = $this->output->createProgressBar($count);
        $batch = [];

        DB::beginTransaction();

        try {
            for ($i = 1; $i <= $count; $i++) {
                $batch[] = [
                    'last_name' => $this->lastNames[array_rand($this->lastNames)],
                    'first_name' => $this->firstNames[array_rand($this->firstNames)],
                    'phone' => '+7' . str_pad($i, 10, '0', STR_PAD_LEFT),
                    'email' => 'user_' . $i . '@random.com',
                    'created_at' => $now,
                    'updated_at' => $now,
                ];

                if (count($batch) === $chunk) {
                    DB::table('persons')->insert($batch);
                    $bar->advance($chunk);
                    unset($batch);
                    $batch = [];
                }
            }

            if (!empty($batch)) {
                DB::table('persons')->insert($batch);
                $bar->advance(count($batch));
                unset($batch);
            }

            try {
                DB::commit();
            } catch (Throwable $e) {
                $this->error('Ошибка коммита: ' . $e->getCode());
                return self::FAILURE;
            }
        } catch (Exception $e) {
            DB::rollBack();
            $this->newLine();
            $this->error('Ошибка: ' . $e->getCode() . ' - транзакция отменена.');
            return self::FAILURE;
        }

        $bar->finish();
        $this->newLine();
        $this->info('Готово.');

        return self::SUCCESS;
    }
}
