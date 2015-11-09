<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Schema\Blueprint;
use App\Models\Policy;
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
        Schema::table('images', function(Blueprint $table)
        {   
            $table->boolean('is_default');
        });

        // $this->info("Updating User with link and expired");
        // $types                                      = ['expired_link_duration'];
        // $values                                     = ['+ 2 hours'];
        // try
        // {
        //     $i                                      = 0;
        //     foreach($types as $key => $value)
        //     {
        //         $data                               = new Policy;
        //         $data->fill([
        //             'type'                          => $value,
        //             'value'                         => $values[$key],
        //             'started_at'                    => date('Y-m-d H:i:s'),
        //         ]);

        //         if (!$data->save())
        //         {
        //             print_r($data->getError());
        //             exit;
        //         }
        //     }   
        // }
        // catch (Exception $e) 
        // {
        //     echo 'Caught exception: ',  $e->getMessage(), "\n";
        //     echo 'Caught exception: ',  $e->getFile(), "\n";
        //     echo 'Caught exception: ',  $e->getLine(), "\n";
        // }

        // $this->info("Add expired link duration");
    }
}
