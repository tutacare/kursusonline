<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Concerns\HasEncryptedId;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory, HasEncryptedId;

    protected $fillable = [
        'module_id',
        'title',
        'type',
        'order',
        'file_path',
        'text_content',
    ];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }
}
