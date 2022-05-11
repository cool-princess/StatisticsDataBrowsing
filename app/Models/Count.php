<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Count extends Model
{
    use HasFactory;
    protected $table="count";

    protected $fillable = [
        'user_id',
        'company_name',
        'address1',
        'sectors',
        'break',
        'login_count',
        'download_count'
    ];
}