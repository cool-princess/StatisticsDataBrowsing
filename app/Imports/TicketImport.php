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
        $date = strtotime($row[27]);
        return new Ticket([
            'order_number' => $row[0],
            'name' => $row[7],
            'sex' => $row[26],
            'birthday' => date('Y-m-d H:i:s', $date),
            'adult_ticket' => $row[51],
            'young_ticket' => $row[54],
            'location' =>$row[29],
        ]);
    }

    public function rules(): array
    {
        return [
            'order_number' => 'string',
            'name'     => 'string',
            'sex'     => 'string',
            'birthday'     => 'string',
            'adult_ticket'     => 'string',
            'young_ticket'     => 'string',
            'location'     => 'string'
        ];
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
