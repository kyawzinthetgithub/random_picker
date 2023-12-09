<?php

namespace App\Exports;

use App\Models\Winner;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class WinnersExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Winner::all();
    }
    public function headings(): array
    {
        return [
            'No',
            'Customer Name',
            'Customer Phone',
            'Customer Address',
            'Product Name',
            'Product Detail',
            'Created_at',
            'Updated_at',
        ];
    }

}
