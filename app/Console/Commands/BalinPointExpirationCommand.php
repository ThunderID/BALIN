<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Jobs\SendReminderEmail;
use Schema;

class BalinPointExpirationCommand extends Command
{
    use DispatchesJobs;
    
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'balin:pointexpire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Reminder Point Expiration Email.';

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
    public function fire()
    {
        $result             = $this->dispatch(new SendReminderEmail());

        if($result->getStatus()=='success')
        {
            $this->info("Sukses Mengirim Reminder Email");
        }
        else
        {
            $this->info($result->getErrorMessage());
        }
        
        return true;
    }
}
