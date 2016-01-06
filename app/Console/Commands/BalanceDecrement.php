<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Balance;
use DB;

class BalanceDecrement extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'balance:decreament';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Decrement all users Balance by time to time';

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
    {//Scheduler work - which is set up by every 30 min in Kernel.php
        //Decreament balance of every user by 10 unit
        $users_having_money = DB::table('users')
                ->join('payments', 'users.id', '=', 'payments.user_id')
                ->select(
                            'users.id as user_id',
                            DB::raw('sum(payments.money_amount) as total')
                        )
                ->groupBy('users.id')
                ->get();
        foreach ($users_having_money as $key => $value)
        {
            $balance = new Balance;
            if($value->total>10)        //If current balance>10, decreament by 10
            {
                $balance->money_amount = -10;
            }
            else if($value->total!==0)  //If current 0<balance<10, decreament by current value
            {
                $balance->money_amount = -$value->total;
            }
            $balance->transection_by = 'system';
            $balance->user_id = $value->user_id;
            $balance->save();
        }
    }
}
