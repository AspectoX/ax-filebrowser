<?php

namespace AspectoX\AxFileBrowser;

use Illuminate\Database\Eloquent\Model;

class FileMetadata extends Model
{
    protected $table = 'file_metadata';
 
    protected $fillable = [
        'file_path',
        'original_name',
        'folder',
        'type',
        'is_external',
        'fecha_archivo',
        'autor',
        'credito_url',
        'epigrafe',
        'tags',
    ];
 
    protected $casts = [
        'fecha_archivo' => 'date',
        'is_external'   => 'boolean',
    ];
}
