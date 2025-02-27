<?php namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'youtube_embed_code', 'event_date'];

    public function getFormattedEmbedCodeAttribute()
{
    $code = $this->youtube_embed_code;
    
    // Remove any existing width and height attributes
    $code = preg_replace('/width="\d+"/', '', $code);
    $code = preg_replace('/height="\d+"/', '', $code);

    // Wrap it in a responsive container
    return '<div class="video-container">' . $code . '</div>';
}



}
