<?php
  include 'data.php';
  $result = download_csv("");
  if ($result[1]) {
    $process_result = read_and_process_csv("");
    if ($process_result[1]) {
      // returns new timestamp
      save_timestamp($result[0]);
      echo("Andmed värskendatud!");
    } else {
      echo($process_result[0]);
    }
  } else {
    echo($result[0]);
  }
?>
