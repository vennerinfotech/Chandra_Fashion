<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;

class ProductImportFormatExport implements FromArray
{
    public function array(): array
    {
        return [
            [
                'NAME',
                'DESCRIPTION',
                'SHORT_DESCRIPTION',
                'CARE_INSTRUCTIONS',
                'MATERIALS',
                'PRICE',
                'CATEGORY',
                'SUBCATEGORY',
                'PRODUCT_CODE',
                'IMAGES',
                'MOQ',
                'GSM',
                'DAI',
                'CHADTI',
                'STATUS'
            ]
        ];
    }
}
