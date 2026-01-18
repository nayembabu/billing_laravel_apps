<?php

    namespace App;

    use Illuminate\Database\Eloquent\Model;

    class TaskNote extends Model
    {
        protected $table = 'task_notes';

        protected $fillable = [
            'task_id',
            'task_note_detals', // সম্ভবত task_note_details হবে
            'task_user_id',
            'created_at'
        ];

        public function task()
        {
            return $this->belongsTo(Tasks::class, 'task_id');
        }

        public function user()
        {
            return $this->belongsTo(User::class, 'task_user_id');
        }
    }
