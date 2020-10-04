<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'question_text',
    ];

    /**
     * Custom timestamps
     * 
     */
    const CREATED_AT = 'created_timestamp';
    const UPDATED_AT = 'updated_timestamp';

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->id = (string) \Str::uuid();
        });
    }

    /**
     * Get the user that owns the question.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the answers of the question.
     */
    public function answers()
    {
        return $this->hasMany(Answer::class, 'question_id');
    }
}
