<?php

namespace App\Console\Commands;

use App\Mail\TaskNotificationMail;
use App\Models\Task;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TaskReminderCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tasks:reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tasks Reminder';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $tasks = Task::where('status' , '!=' , 'complete')->get();
        foreach($tasks as $task){
            Mail::to($task->user->email)->send(new TaskNotificationMail($task->user , 'task deadline after 24 hours' , $task));
        }
        return Command::SUCCESS;
    }
}
