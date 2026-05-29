<?php

namespace App\Http\Controllers;

use App\Contracts\ExportServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ExportController extends Controller
{
    public function __construct(private readonly ExportServiceInterface $exportService)
    {
    }

    public function index()
    {
        return view('export.index');
    }

    public function start(Request $request): JsonResponse
    {
        $requested = (int) $request->input('count');
        $fields = explode(',', $request->input('fields', ''));

        return response()->json($this->exportService->start($requested, $fields));
    }

    public function chunk(Request $request): JsonResponse
    {
        $exportId = $request->input('export_id');
        $lastId   = (int) $request->input('last_id', 0);
        $remaining = (int) $request->input('remaining');
        $fields   = explode(',', $request->input('fields', ''));

        return response()->json($this->exportService->processChunk($exportId, $lastId, $remaining, $fields));
    }

    public function download(string $exportId): BinaryFileResponse
    {
        $path = $this->exportService->getFilePath($exportId);

        return response()->download($path, 'users.csv')->deleteFileAfterSend(true);
    }
}
