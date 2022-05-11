<?php

namespace App\Imports;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithStartRow;

class TicketImport implements ToModel, WithValidation, WithStartRow
{
    use Importable;

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $birth_date = strtotime($row[27]);
        $ticketing_date = strtotime($row[5]);
        return new Ticket([
            'order_number' => $row[0],
            'name' => $row[7],
            'sex' => $row[26],
            'birthday' => date('Y-m-d H:i:s', $birth_date),
            'adult_ticket' => $row[51],
            'young_ticket' => $row[54],
            'location' => $row[29],
            'area' => $row[15],
            'ticketing_date' => date('Y-m-d H:i:s', $ticketing_date)
        ]);
    }

    public function rules(): array
    {
        return [
            'order_number' => 'string|unique',
            'name'     => 'string',
            'sex'     => 'string',
            'birthday'     => 'string',
            'adult_ticket'     => 'string',
            'young_ticket'     => 'string',
            'location'     => 'string',
            'area'     => 'string',
            'ticketing_date'     => 'string'
        ];
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function startRow(): int
    {
        return 2;
    }
  
    public function getErrors()
    {
        return $this->errors;
    }
}
