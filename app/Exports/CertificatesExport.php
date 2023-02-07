<?php

namespace App\Exports;

use App\Models\Certificate;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CertificatesExport implements FromCollection, WithMapping, WithHeadings
{
    public Collection $certificates;

    public function __construct(Collection $certificates)
    {
        $this->certificates = $certificates;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->certificates;
    }

    public function headings(): array
    {
        return [
            'Код Бизнес-зала',
            'Наименование Бизнес-зала',
            'Номер сертификата',
            'ФИО',
            'Дата',
            'Время',
            'Статус сертификата',

        ];
    }

    public function map($row): array
    {
        $date = null;
        $time = null;
        if ($row->start_time) {
            $row->start_time = Carbon::parse($row->start_time);
            $date = $row->start_time->format('d.m.Y');
            $time = $row->start_time->format('H:i');
        }

        $names = json_decode($row->user_name);
        if ($names) {
            $row->user_name = implode(', ', $names);
        }

        return [
            strtoupper($row->halls->prefix),
            $row->halls->name,
            $row->id,
            $row->user_name ?? 'Без имени',
            $date,
            $time,
            Certificate::statusMsg($row->status)
        ];
    }
}
