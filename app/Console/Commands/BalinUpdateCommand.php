<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Schema\Blueprint;
use Schema;

class BalinUpdateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'balin:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update BALIN.';

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
        $result         = $this->update10102015();
        
        return true;
    }

    /**
     * update 1st version
     *
     * @return void
     * @author 
     **/
    public function update10102015()
    {
        Schema::table('users', function(Blueprint $table)
        {   
            $table->string('activation_link', 255);
            $table->string('reset_password_link', 255);
            $table->datetime('expired_at')->nullable();
        });

        $this->info("Updating User with link and expired");
    }
}
