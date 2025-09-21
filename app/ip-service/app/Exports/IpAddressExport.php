<?php

namespace App\Exports;

use App\Models\IpAddress;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;

class IpAddressExport implements FromCollection, WithHeadings, WithColumnWidths
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return IpAddress::all()->map(function ($ip) {
            return [
                $ip->id,
                $ip->ip,
                $ip->country,
                $ip->city,
                $ip->created_at->format('Y-m-d H:i:s'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'IP Address',
            'Country',
            'City',
            'Created Date',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5, //IP Address
            'B' => 20, //IP Address
            'C' => 30, //Country
            'D' => 25, //City
            'E' => 25, //Created Date
        ];
    }
}
