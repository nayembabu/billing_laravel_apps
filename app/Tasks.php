<?php

    namespace App;

    use Illuminate\Database\Eloquent\Model;

    class Tasks extends Model
    {
        protected $table = 'tasks';
        protected $fillable =[
            "user_id", "title", "note", "status", "priority", "start_date", "due_date", "tags", "is_billable", "created_at", "updated_at", "short_title", "task_desc"
        ];

        public function user()
        {
            return $this->belongsTo('App\User');
        }

        public function notes()
        {
            return $this->hasMany(TaskNote::class, 'task_id')
                        ->with('user')
                        ->orderBy('created_at', 'desc');
        }

        public function attachments()
        {
            return $this->hasMany(TaskAttach::class, 'task_id')
                        ->with('user')
                        ->orderBy('created_at', 'desc');
        }

    }
