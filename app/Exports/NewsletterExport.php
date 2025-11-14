<?php

namespace App\Exports;

use App\Models\NewsletterSubscription;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class NewsletterExport implements FromCollection, WithHeadings
{
    protected $from;
    protected $to;

    public function __construct($from, $to)
    {
        $this->from = $from;
        $this->to   = $to;
    }

    public function collection()
    {
        $q = NewsletterSubscription::orderBy('id', 'desc');

        // Date filters (FULL DAY SUPPORT)
        if ($this->from && $this->to) {
            $q->whereBetween('created_at', [
                $this->from . ' 00:00:00',
                $this->to   . ' 23:59:59'
            ]);
        } elseif ($this->from) {
            $q->where('created_at', '>=', $this->from . ' 00:00:00');
        } elseif ($this->to) {
            $q->where('created_at', '<=', $this->to . ' 23:59:59');
        }

        return $q->get()->map(function ($s) {
            return [
                'ID'      => $s->id,
                'Mobile'  => $s->mobile,
                'Created' => $s->created_at->format('Y-m-d H:i:s'),
            ];
        });
    }

    public function headings(): array
    {
        return ['ID', 'Mobile', 'Created At'];
    }
}
