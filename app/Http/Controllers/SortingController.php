<?php

namespace App\Http\Controllers;

use App\Contracts\SortInterface;
use App\Contracts\DataFileServiceInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class SortingController extends Controller
{
    public function __construct(
        private readonly DataFileServiceInterface $dataFileService,
        private readonly SortInterface $sortService,
    ) {
    }

    public function index(Request $request)
    {
        $filePath = storage_path('data/data.txt');

        if (!file_exists($filePath)) {
            return view('sorting.index', ['missingFile' => true]);
        }

        $previewData  = $this->dataFileService->readLines($filePath, 20);
        $fileName = basename($filePath);

        if (!$request->has('count')) {
            return view('sorting.index', ['preview' => $previewData, 'fileName' => $fileName]);
        }

        $count = max(1, min((int) $request->query('count'), 50000));
        $data  = $this->dataFileService->readLines($filePath, $count);

        $memoryBefore = memory_get_usage();
        $timeStart = microtime(true);

        $sorted = $this->sortService->sort($data);

        $timeMs      = round((microtime(true) - $timeStart) * 1000, 2);
        $memoryBytes = memory_get_usage() - $memoryBefore;

        return view('sorting.index', [
            'preview'     => $previewData,
            'fileName'    => $fileName,
            'count'       => count($sorted),
            'before'      => $data,
            'after'       => $sorted,
            'timeMs'      => $timeMs,
            'memoryBytes' => $memoryBytes,
        ]);
    }

    public function generate(Request $request): RedirectResponse
    {
        $count = max(1, min((int) $request->input('count'), 1000000));

        Artisan::call(command: 'sorting:generate', parameters: ['count' => $count]);

        return redirect()->route('sorting.index')
            ->with('success', "Сгенерировано $count чисел.");
    }
}
