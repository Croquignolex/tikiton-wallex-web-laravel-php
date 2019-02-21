<?php

namespace App\Traits;

use App\Models\User;
use App\Models\Category;
use App\Models\AdminNotification;

trait UserFactoryDataTrait
{
    /**
     * @param User $user
     */
    private function userFactoryData(User $user)
    {
        if(!$user->is_factored)
        {
            //Default settings
            $user->user_settings()->create([
                'name' => trans('dummy.novice'), 'is_current' => true,
                'description' => trans('dummy.novice_desc')
            ]);
            $user->user_settings()->create([
                'tips' => false, 'name' => trans('dummy.expert'),
                'description' => trans('dummy.expert_desc')
            ]);
            //Default currencies
            $currency = $user->currencies()->create([
                'name' => 'FCFA', 'devaluation' => 1, 'symbol' => 'XAF',
                'description' => trans('dummy.xaf_desc'), 'is_current' => true
            ]);
            $user->currencies()->create([
                'name' => 'US DOLLAR', 'devaluation' => 576.43, 'symbol' => '$',
                'description' => trans('dummy.dollar_desc')
            ]);
            $user->currencies()->create([
                'name' => 'EURO', 'devaluation' => 654.85, 'symbol' => '€',
                'description' => trans('dummy.euro_desc')
            ]);
            $user->currencies()->create([
                'name' => 'POUNDS', 'devaluation' => 729.79, 'symbol' => '£',
                'description' => trans('dummy.pounds_desc')
            ]);
            //Default wallets
            $personal_wallet = $user->wallets()->create([
                'balance' => 0, 'threshold' => 0, 'stated' => true,
                'description' => trans('dummy.wallet_desc'), 'name' => trans('dummy.wallet'),
                'color' => '#1a8cff', 'currency_id' => $currency->id
            ]);
            $current_account_wallet = $user->wallets()->create([
                'balance' => 0, 'threshold' => 0,
                'description' => trans('dummy.current_account_desc'),
                'color' => '#00c292', 'name' => trans('dummy.current_account'), 'currency_id' => $currency->id
            ]);
            $saving_account_wallet = $user->wallets()->create([
                'balance' => 0, 'threshold' => 0,
                'description' => trans('dummy.saving_account_desc'),
                'color' => '#F44336', 'name' => trans('dummy.saving_account'), 'currency_id' => $currency->id
            ]);
            //Default categories
            $income = $user->categories()->create([
                'description' => trans('dummy.salary_desc'),
                'color' => '#00c292',
                'name' => trans('dummy.salary'),
                'icon' => 'money',
                'type' => Category::INCOME
            ]);
            $transfer = $user->categories()->create([
                'description' => trans('dummy.transfer_order_desc'),
                'color' => '#2196F3',
                'name' => trans('dummy.transfer_order'),
                'icon' => 'exchange',
                'type' => Category::TRANSFER
            ]);
            $expense = $user->categories()->create([
                'description' => trans('dummy.electricity_desc'),
                'color' => '#F44336',
                'name' => trans('dummy.electricity'),
                'icon' => 'flash',
                'type' => Category::EXPENSE
            ]);
            //Default transactions
            $income_transaction = $income->transactions()->create([
                'description' => trans('dummy.income_desc'),
                'amount' => 0,
                'currency_id' => $currency->id
            ]);
            $transfer_transaction = $transfer->transactions()->create([
                'description' => trans('dummy.transfer_desc'),
                'amount' => 0,
                'currency_id' => $currency->id
            ]);
            $expense_transaction = $expense->transactions()->create([
                'description' => trans('dummy.expense_desc'),
                'amount' => 0,
                'currency_id' => $currency->id
            ]);
            $income_transaction->wallets()->save($personal_wallet);
            $transfer_transaction->wallets()->save($current_account_wallet);
            $transfer_transaction->wallets()->save($saving_account_wallet);
            $expense_transaction->wallets()->save($personal_wallet);

            $user->admin_notifications()->create([
                'type' => AdminNotification::CONFIRMED
            ]);
            $user->is_factored = true;
            $user->save();
        }
    }
}