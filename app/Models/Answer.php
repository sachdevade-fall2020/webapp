<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
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
        'user_id', 'answer_text',
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
     * Get the user that owns the answer.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the question that belongs to answer.
     */
    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }

    /**
     * Get the attachments of the answer.
     */
    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }
}
