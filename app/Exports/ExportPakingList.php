<?php

namespace App\Exports;

use App\Models\pkglist;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithProperties;

class ExportPakingList implements FromCollection, WithHeadings, WithMapping, WithProperties
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return pkglist::select('*')->get();
    }

    /**
     * Mapea cada instancia de `pkglist` a un arreglo de valores.
     *
     * @param  \App\Models\pkglist  $pkglist  Una instancia del modelo `pkglist` que representa una fila de datos.
     * @return array  Un arreglo de valores que representa una fila en el archivo exportado.
     */
    public function map($pkglist): array
    {
        return [
            $pkglist->id,
            $pkglist->no_contact,
            $pkglist->steel_grande,
            $pkglist->pkg_Standard,
            $pkglist->DIA,
            $pkglist->pkg_Lenght,
            $pkglist->pkg_Weight,
            $pkglist->pkg_Bars,
            $pkglist->pkg_Bundles,
        ];
    }

    /**
     * Define los encabezados de la primera fila en el archivo exportado.
     *
     * @return array  Un arreglo de títulos que representan los nombres de las columnas.
     */
    public function headings(): array
    {
        return [
            '#',
            'No Contacto',
            'Steel Grande',
            'Standard del Paquete',
            'DIA',
            'Longitud del Paquete',
            'Peso del Paquete',
            'Barras en el Paquete',
            'Paquetes',
        ];
    }

    public function properties(): array
    {
        return [
            'creator' => 'Fast Solutions',
        ];
    }
}
