<?php
declare(strict_types=1);

namespace App\Services;

abstract class TransactionService
{
    public static function getTransactions(string $fileName): array
    {
        if (! file_exists($fileName)) {
            trigger_error("File \"$fileName\" does not exist.");
        }

        $file = fopen($fileName, 'r');

        fgetcsv(stream: $file, escape: ''); // remove the first line (header)

        $transactions = [];

        while (($transaction = fgetcsv(stream: $file, escape: '')) !== false) {
                $transaction = self::extractTransaction($transaction);

            $transactions[] = $transaction;
        }

        return $transactions;
    }

    private static function extractTransaction(array $transactionRow): array
    {
        [$date, $checkNumber, $description, $amount] = $transactionRow;

        $amount = (float) str_replace(['$', ','], '', $amount);

        return [
            'date'        => $date,
            'checkNumber' => $checkNumber,
            'description' => $description,
            'amount'      => $amount,
        ];
    }

    public static function calculateTotals(array $transactions): array
    {
        $totals = ['netTotal' => 0, 'totalIncome' => 0, 'totalExpense' => 0];

        foreach ($transactions as $transaction) {
            $totals['netTotal'] += $transaction['amount'];

            if ($transaction['amount'] >= 0) {
                $totals['totalIncome'] += $transaction['amount'];
            } else {
                $totals['totalExpense'] += $transaction['amount'];
            }
        }

        return $totals;
    }

}
