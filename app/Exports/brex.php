<?php

namespace App\Exports;

use App\Models\brands;
use Maatwebsite\Excel\Concerns\FromCollection;

class brex implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return brands::all();
    }
}
