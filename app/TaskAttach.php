<?php

    namespace App;

    use Illuminate\Database\Eloquent\Model;

    class TaskAttach extends Model
    {
        protected $table = 'task_attatch';

        protected $fillable = [
            'task_attatch_path',
            'task_id',
            'user_id',
            'created_at',
            'is_read'
        ];

            public function task()
            {
                return $this->belongsTo(Tasks::class, 'task_id');
            }

            public function user()
            {
                return $this->belongsTo(User::class, 'user_id');
            }
    }
