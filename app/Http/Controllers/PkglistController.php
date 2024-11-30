<?php

namespace App\Http\Controllers;

use App\Exports\ExportPakingList;
use Maatwebsite\Excel\Facades\Excel;
use Orchid\Support\Facades\Toast;

class PkglistController extends Controller
{
    public function export_excel()
    {
        // Guardar el mensaje de éxito en la sesión antes de la descarga
        session()->flash('success', 'Exportación completada correctamente');

        // Realizar la descarga
        return Excel::download(new ExportPakingList, 'packinglist.xls');
    }
}
