<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\Transaction;
use App\Services\TransactionService;
use App\View;

class TransactionController
{
    public function index(): View
    {
        $transactionModel = new Transaction();
        $transactions = $transactionModel->readAll();

        $total = array_sum(
            array_map(
                fn($value) => (float)str_replace(',', '.', $value),
                array_column($transactions, 'amount')
            )
        );

        $totals = TransactionService::calculateTotals($transactions);

        return View::make('transactions', ['transactions' => $transactions, 'totals' => $totals]);
    }

    public function upload(): void
    {
        $transactions = [];

        foreach ($_FILES as $file) {
            $transactions = array_merge(
                $transactions,
                TransactionService::getTransactions($file['tmp_name'])
            );
        }

        $transactionModel = new Transaction();
        foreach ($transactions as $transaction) {
            $transactionModel->create(date_create_from_format('d/m/Y', $transaction['date']), (int) $transaction['checkNumber'], $transaction['description'], $transaction['amount']);
        }

        header('Location: /transactions');
    }
}
