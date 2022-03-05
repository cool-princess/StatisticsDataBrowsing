<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DownloadCountExport implements FromCollection, WithHeadings
{
    function __construct($param) {
        $this->address1 = $param['address1'];
        $this->sectors = $param['sectors'];
        $this->from_date = $param['from_date'];
        $this->end_date = $param['end_date'];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $filters = [
            'address1' => $this->address1,
            'sectors' => $this->sectors,
            'from_date' => $this->from_date,
            'end_date' => $this->end_date
        ];
        $data = User::where(function ($query) use ($filters) {
            if ($filters['address1']) {
                $query->select('company_name', 'address1', 'sectors', 'break', 'login_count')->where('address1', '=', $filters['address1']);
            }
            if ($filters['sectors']) {
                $query->select('company_name', 'address1', 'sectors', 'break', 'login_count')->where('sectors', '=', $filters['sectors']);
            }
            if ($filters['from_date'] || $filters['end_date']) {
                $query->select('company_name', 'address1', 'sectors', 'break', 'login_count')->whereBetween('created_at', [$filters['from_date'], $filters['end_date']]);
            }
        })->get();
        return $data;
    }

    public function headings(): array
    {
        return [
            '企業名',
            '県',
            '業種',
            '休止',
            'ログイン回数'
        ];
    }
}
