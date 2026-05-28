<?php

namespace App\Http\Controllers;

use App\Contracts\SortInterface;
use Generator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class SortingController extends Controller
{
    public function __construct(private readonly SortInterface $sortService)
    {
    }

    public function index(Request $request)
    {
        $filePath = storage_path('data/data.txt');

        if (!file_exists($filePath)) {
            return view('sorting.index', ['missingFile' => true]);
        }

        $preview = iterator_to_array($this->readLines($filePath, 20), false);
        $fileName = basename($filePath);

        if (!$request->has('count')) {
            return view('sorting.index', ['preview' => $preview, 'fileName' => $fileName]);
        }

        $count = (int)$request->query('count');
        $count = max(1, min($count, 50000));

        $data = iterator_to_array($this->readLines($filePath, $count), false);

        $memBefore = memory_get_usage();
        $timeStart = microtime(true);

        $sorted = $this->sortService->sort($data);

        $timeMs = round((microtime(true) - $timeStart) * 1000, 2);
        $memoryBytes = memory_get_usage() - $memBefore;

        return view('sorting.index', [
            'preview' => $preview,
            'fileName' => $fileName,
            'count' => count($sorted),
            'before' => $data,
            'after' => $sorted,
            'timeMs' => $timeMs,
            'memoryBytes' => $memoryBytes,
        ]);
    }

    public function generate(Request $request): RedirectResponse
    {
        $count = (int)$request->input('count');
        $count = max(1, min($count, 1000000));

        Artisan::call(command: 'sorting:generate', parameters: ['count' => $count]);

        /** @var int $count */
        return redirect()->route('sorting.index')
            ->with('success', "Сгенерировано $count чисел.");
    }

    private function readLines(string $path, int $limit): Generator
    {
        $handle = fopen($path, 'r');
        $read = 0;

        while (!feof($handle) && $read < $limit) {
            $line = trim(fgets($handle));

            if ($line !== '') {
                yield (int)$line;
                $read++;
            }
        }

        fclose($handle);
    }
}
