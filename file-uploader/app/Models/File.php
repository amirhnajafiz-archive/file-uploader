<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class File extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Fillable fields of the model.
     *
     * @var string[]
     */
    protected $fillable = [
        'title',
        'path'
    ];
}
