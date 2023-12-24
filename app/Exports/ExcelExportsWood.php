<?php

namespace App\Exports;

use App\Models\Wood;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExcelExportsWood implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Wood::all();
    }
}
