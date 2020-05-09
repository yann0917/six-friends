<?php

namespace App\Exports;

use App\Models\Columnist;
use Maatwebsite\Excel\Concerns\FromCollection;

class ColumnistExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Columnist::all();
    }

}
