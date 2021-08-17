<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\URL;

class Download extends Model
{
    use HasFactory;

    protected $table='downloads';

    protected $fillable=[
        'user_id',
        'downloadable_id',
        'downloadable_type',
        'url'
    ];

    public function signature($target){
        return URL::temporarySignedRoute('download.file',now()->addMinute(2),['file'=>ProductGallery::getFile()]);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function downloadable(): MorphTo
    {
        return $this->morphTo();
    }



}
