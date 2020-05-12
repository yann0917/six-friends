<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;

class SendEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'cron sed email';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $file = env('SQL_BACKUP_FILE', '/home/backup/') . 'db-sf-'.date('Ymd').'.sql';
        if (file_exists($file)) {
            Mail::raw('定时发送备份数据', function (Message $message) use ($file) {
                $message->subject('定时发送备份数据-' . date('Y-m-d'));
                $message->to(env('MAIL_TO_ADDRESS'));
                $message->attach($file);
            });
        } else {
            Mail::raw('找不到备份文件：' . $file, function (Message $message) {
                $message->subject('定时发送备份数据-' . date('Y-m-d'));
                $message->to(env('MAIL_TO_ADDRESS'));
            });
        }
    }
}
