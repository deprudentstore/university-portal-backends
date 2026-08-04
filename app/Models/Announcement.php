<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $fillable = ['title', 'body', 'posted_by', 'audience'];
    public function author() { return $this->belongsTo(User::class, 'posted_by'); }
}
