<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;




class EvidenceController extends Controller
{
    public function show($path)
    {
        $disk = Storage::disk('s3');

        if (!$disk->exists($path)) {
            abort(404);
        }

        $stream = $disk->readStream($path);

        return response()->stream(function () use ($stream) {
            fpassthru($stream);
        }, 200, [
            "Content-Type" => $disk->mimeType($path),
            "Content-Length" => $disk->size($path),
            "Content-Disposition" => "inline; filename=\"" . basename($path) . "\"",
        ]);
    }
}
