<?php

namespace App\Exports;

use App\Models\CategoryProductModel;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExcelExportsCateProduct implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return CategoryProductModel::all();
    }
}
