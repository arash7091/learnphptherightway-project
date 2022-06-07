<?php

declare(strict_types = 1);

// Your Code

function getCSVFiles($file_path){
  $files_list = array_diff(scandir($file_path), [".",".."]);
  $files_list = array_filter($files_list, fn($item) => str_ends_with($item, ".csv"));
  $files_list = array_filter($files_list, fn($item) => is_file($file_path . $item));
  return $files_list;
}

function readCSVFile($file_name, $file_path){
  $file_addr = $file_path . $file_name;
  if (!file_exists($file_addr)){
    return false;
  }
  else {
    $file = fopen($file_addr,"r");
    $result = [];
    while (($line = fgetcsv($file)) != false) {
      array_push($result,$line);
    }
    fclose($file);
    return $result;
  }
}

function checkCSVHeader($csv_data){
  $csv_header = $csv_data[0];
  if(count(array_diff($csv_header,["Date", "Check #", "Description", "Amount"])) == 0){
    return true;
  }
  else {
    return false;
  }
}

function calculateTotalAmount($transactions):array{
  $floatVals = array_map(fn($item) => str_replace(["$", ","],"",$item[3]), $transactions);
  $totalIncome = array_sum(array_filter($floatVals, fn($item) => $item >= 0));
  $totalExpense = array_sum(array_filter($floatVals, fn($item) => $item < 0));
  $netTotal = $totalIncome + $totalExpense;
  return [$totalIncome, $totalExpense, $netTotal];
}

function floatToDollars($float_val){
  if($float_val >= 0){
    return "$" . number_format($float_val, 2);
  }
  else{
    return "-$" . number_format(abs($float_val), 2);
  }
}

function formatDate($dt_string){
  return date("M j, Y", strtotime($dt_string));
}

function generateTableRows($transactions){
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
}
