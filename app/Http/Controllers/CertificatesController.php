<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class CertificatesController extends Controller
{
    /**
     * Serve certificate PDF by normalized key.
     */
    public function show(string $key)
    {
        // Ensure request is signed if middleware was bypassed somehow
        if (!request()->hasValidSignature()) {
            abort(403);
        }

        // Prefer private storage first, then fallback to public legacy folder
        $storageDisk = 'local'; // storage/app
        $storageDir = 'certificates';
        $publicDir = public_path('images/certificates');

        $matchPath = null;
        $downloadName = 'document.pdf';

        $normalize = function (string $base) {
            $clean = preg_replace('/([_\-\s])*page([_\-\s])*\d+$/i', '', $base);
            $norm = strtolower(preg_replace('/[^a-z0-9]+/i', '-', trim($clean)));
            return trim($norm, '-');
        };

        // 1) Look in storage/app/certificates (non-public)
        if (Storage::disk($storageDisk)->exists($storageDir)) {
            $files = Storage::disk($storageDisk)->files($storageDir);
            foreach ($files as $path) {
                if (strtolower(pathinfo($path, PATHINFO_EXTENSION)) !== 'pdf') {
                    continue;
                }
                $base = pathinfo($path, PATHINFO_FILENAME);
                if ($normalize($base) === strtolower($key)) {
                    $matchPath = Storage::disk($storageDisk)->path($path);
                    $downloadName = basename($path);
                    break;
                }
            }
        }

        // 2) Fallback: public/images/certificates
        if (!$matchPath && File::exists($publicDir)) {
            foreach (File::files($publicDir) as $f) {
                if (strtolower($f->getExtension()) !== 'pdf') {
                    continue;
                }
                $name = pathinfo($f->getFilename(), PATHINFO_FILENAME);
                if ($normalize($name) === strtolower($key)) {
                    $matchPath = $f->getPathname();
                    $downloadName = $f->getFilename();
                    break;
                }
            }
        }

        if (!$matchPath) {
            abort(404);
        }

        return response()->file($matchPath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . ($downloadName ?? 'document.pdf') . '"',
            'X-Content-Type-Options' => 'nosniff',
            'Cache-Control' => 'public, max-age=86400',
        ]);
    }
}
