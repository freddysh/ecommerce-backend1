<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductCollectionImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */

    use Importable;
    public function collection(Collection $collection)
    {
        //
        return $collection;
    }
}
