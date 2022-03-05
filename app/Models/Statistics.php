<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statistics extends Model
{
    use HasFactory;
    protected $table="statistics";

    protected $fillable = [
        'category',
        'reporter',
        'display_name',
        'file_path'
    ];
}