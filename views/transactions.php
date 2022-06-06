<!DOCTYPE html>
<html>
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
                <?php
                  foreach ($transactions as $tr){
                    $style = "";
                    if (str_starts_with($tr[3],"-")){
                      $style = '"color: red"';
                    }
                    else {
                      $style = '"color: green"';
                    }
                    $date = formatDate($tr[0]);
                    $t_data = <<<TEXT
                    <tr>
                      <td>$date</td>
                      <td>$tr[1]</td>
                      <td>$tr[2]</td>
                      <td style=$style>$tr[3]</td>
                    </tr>
                    TEXT;
                    echo $t_data;
                  }
                 ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3">Total Income:</th>
                    <td>
                      <?php echo floatToDollars($totalIncome); ?>
                    </td>
                </tr>
                <tr>
                    <th colspan="3">Total Expense:</th>
                    <td>
                      <?php echo floatToDollars($totalExpense); ?>
                    </td>
                </tr>
                <tr>
                    <th colspan="3">Net Total:</th>
                    <td>
                      <?php echo floatToDollars($netTotal); ?>
                    </td>
                </tr>
            </tfoot>
        </table>
    </body>
</html>
