<?php

namespace App\Exports;

use App\Models\Inquiry;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class InquiriesExport implements FromCollection, WithHeadings
{
    protected $from;
    protected $to;
    protected $month;
    protected $year;

    public function __construct($from, $to, $month, $year)
    {
        $this->from = $from;
        $this->to = $to;
        $this->month = $month;
        $this->year = $year;
    }

public function collection()
{
    $q = Inquiry::with(['product','country'])->orderBy('id','desc');

    if ($this->from && $this->to) {
        $q->whereBetween('created_at', [$this->from, $this->to]);
    }

    if (!empty($this->month)) {
        $q->whereMonth('created_at', $this->month);
    }

    if (!empty($this->year)) {
        $q->whereYear('created_at', $this->year);
    }

    return $q->get()->map(function($i){
        return [
            'ID'       => $i->id,
            'Product'  => $i->product->name ?? 'N/A',
            'Name'     => $i->name,
            'Email'    => $i->email,
            'Phone'    => $i->phone,
            'Country'  => $i->country->name ?? 'N/A',
            'Qty'      => $i->quantity,
            'Date'     => $i->created_at->format('Y-m-d H:i:s'),
        ];
    });
}


    public function headings(): array
    {
        return ['ID','Product','Name','Email','Phone','Country','Quantity','Date'];
    }
}
