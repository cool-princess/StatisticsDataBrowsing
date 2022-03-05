<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;
use Illuminate\Support\Facades\DB;

class UsersImport implements ToModel, WithValidation
{
    use Importable;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $user_id = DB::table('users')->select('user_id')->get();
        $custom_id = "GD9".str_pad(rand(0, pow(10, 4)-1), 4, '0', STR_PAD_LEFT);
        loop:
        foreach ($user_id as $value) {
            if($value->user_id == $custom_id) {
                $custom_id = "GD9".str_pad(rand(0, pow(10, 4)-1), 4, '0', STR_PAD_LEFT);
                goto loop;
            }
        }
        return new User([
            'user_id'     => $custom_id,
            'password'     => bcrypt('user_001'),
            'company_name'     => mb_convert_kana($row[0], "KVC"),
            'furi_company_name'     => mb_convert_encoding($row[1], 'UTF-8', 'EUC-JP'),
            'department_name'     => mb_convert_encoding($row[2], 'UTF-8', 'EUC-JP'),
            'job_title'     => mb_convert_encoding($row[3], 'UTF-8', 'EUC-JP'),
            'name'     => mb_convert_encoding($row[4], 'UTF-8', 'EUC-JP'),
            'furi_name'     => mb_convert_encoding($row[5], 'UTF-8', 'EUC-JP'),
            'email'    => $row[6], 
            'phone'     => $row[7],
            'zipcode'     => $row[8],
            'address1'     => $row[9],
            'address2'     => $row[10],
            'address3'     => $row[11],
            'address4'     => $row[12],
            'sectors'     => $row[13],
            'break' => $row[14],
            'pwd_store' => 'user_001'
        ]);
    }

    public function rules(): array
    {
        return [
            'email' => 'email',
            'company_name'     => 'string',
            'furi_company_name'     => 'string',
            'department_name'     => 'string',
            'job_title'     => 'string',
            'name'     => 'string',
            'furi_name'     => 'string',
            'address1'     => 'string',
            'address2'     => 'string',
            'address3'     => 'string',
            'address4'     => 'string',
            'sectors'     => 'string'
        ];
    }

    public function customValidationAttributes()
    {
        return [
            'email'         => 'User Email',
        ];
    } 

    public function customValidationMessages()
    {
        return [
            'email.email' => 'Email type is error.',
        ];
    }
  
    
    public function getErrors()
    {
        return $this->errors;
    }
}
