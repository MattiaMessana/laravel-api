<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['title','user_id', 'category_id', 'slug', 'description', 'cover_img'];

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function technologies() {
        return $this->belongsToMany('App\Models\Technology');
    }

    public function user() {
        return $this->belongsTo(User::class);
    }    
}
