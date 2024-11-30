<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;

class VersionController extends Controller
{
    /**
     * Obtener la última versión desde el archivo CHANGELOG.md.
     *
     * Este método busca en el archivo CHANGELOG.md para encontrar la línea
     * que contiene la versión más reciente del proyecto. Si el archivo
     * existe y se encuentra la versión, la devuelve. Si no, devuelve 'Desconocida'.
     *
     * @return string La última versión encontrada o 'Desconocida' si no se encuentra.
     */
    public static function getLatestVersionFromChangelog(): string
    {
        $changelogPath = base_path('CHANGELOG.md');  // Ajusta el path según tu estructura de carpetas

        if (File::exists($changelogPath)) {
            $contents = File::get($changelogPath);
            // Busca la línea que contiene la versión más reciente
            preg_match('/\[\s*([0-9]+\.[0-9]+\.[0-9]+)\s*\]/', $contents, $matches);
            return $matches[1] ?? 'Desconocida';
        }

        return 'Desconocida';
    }
}
