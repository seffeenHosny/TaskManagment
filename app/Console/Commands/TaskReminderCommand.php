<?php

namespace App\Console\Commands;

use App\Mail\TaskNotificationMail;
use App\Models\Task;
use Carbon\Carbon;
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
        $date = Carbon::now()->addDay()->format('Y-m-d');
        $tasks = Task::where('status' , '!=' , 'Completed')
                    ->where('due_date' , $date)
                    ->get();
                    
        foreach($tasks as $task){
            Mail::to($task->user->email)->send(new TaskNotificationMail($task->user , 'task deadline after 24 hours' , $task));
        }
        return Command::SUCCESS;
    }
}
