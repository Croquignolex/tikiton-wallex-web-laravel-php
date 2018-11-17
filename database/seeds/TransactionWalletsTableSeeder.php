<?php

use App\Models\Wallet;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Database\Seeder;
use App\Models\TransactionWallet;

class TransactionWalletsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $transactions = Transaction::all();
        foreach($transactions as $transaction)
        {
            $wallet = $transaction->category->user->wallets->random();
            $type = $transaction->category->type;
            if($type === Category::INCOME || $type === Category::EXPENSE) $transaction->wallets()->save($wallet);
            else
            {
                $transaction->wallets()->save($wallet);
                $transaction->wallets()->save($transaction->category->user->wallets->random());
            }
        }
    }
}
