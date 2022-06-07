<?php

declare(strict_types = 1);

$root = dirname(__DIR__) . DIRECTORY_SEPARATOR;

define('APP_PATH', $root . 'app' . DIRECTORY_SEPARATOR);
define('FILES_PATH', $root . 'transaction_files' . DIRECTORY_SEPARATOR);
define('VIEWS_PATH', $root . 'views' . DIRECTORY_SEPARATOR);

/* YOUR CODE (Instructions in README.md) */

include "../app/App.php";
$csv_files = getCSVFiles(FILES_PATH);
$transactions = [];
foreach($csv_files as $csv){
  $data = readCSVFile($csv, FILES_PATH);
  if ($data != -1){
    if(checkCSVHeader($data)){
      $data = array_slice($data,1);
      $transactions = array_merge($transactions, $data);
    }
  }
}
[$totalIncome, $totalExpense, $netTotal] = calculateTotalAmount($transactions);


// display
include "../views/transactions.php";
