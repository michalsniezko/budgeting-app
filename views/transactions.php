<!DOCTYPE html>
<html lang="en">
<head>
    <title>Transactions</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
        }

        table tr th, table tr td {
            padding: 5px;
            border: 1px #eee solid;
        }

        tfoot tr th, tfoot tr td {
            font-size: 20px;
        }

        tfoot tr th {
            text-align: right;
        }
    </style>
</head>
<body>
<table>
    <thead>
    <tr>
        <th>Date</th>
        <th>Check #</th>
        <th>Description</th>
        <th>Amount</th>
    </tr>
    </thead>
    <tbody>
    <?php if (isset($transactions)): ?>
        <?php foreach ($transactions as $transaction): ?>
            <tr>
                <td><?= date_create($transaction['date'])->format('M j, Y') ?></td>
                <td><?= $transaction['check'] ?: '' ?></td>
                <td><?= $transaction['description'] ?></td>
                <td style="color: <?= $transaction['amount'] > 0 ? 'green' : 'red'?> ">
                    <?= ($transaction['amount'] > 0 ? '' : '-' ) . '$' . abs($transaction['amount']) ?>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php endif ?>
    </tbody>
    <tfoot>
    <tr>
        <th colspan="3">Total Income:</th>
        <td>$<?= number_format($totals['totalIncome'] ?? 0, 2) ?></td>
    </tr>
    <tr>
        <th colspan="3">Total Expense:</th>
        <td>-$<?= number_format(abs($totals['totalExpense'] ?? 0), 2) ?></td>
    </tr>
    <tr>
        <th colspan="3">Net Total:</th>
        <td>
            $<?= number_format($totals['netTotal'] ?? 0, 2) ?>
        </td>
    </tr>
    </tfoot>
</table>
</body>
</html>
