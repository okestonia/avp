<?php
$csv_url = "https://docs.google.com/spreadsheets/d/e/2PACX-1vTnQyepuNi3iyKjDrTPlG9Gwdx_rh_dL9Oo7pu69qNfDIftHl5ut_cTmRNmYc5Q0frSNJj1W3fkb5ys/pub?gid=243294232&single=true&output=csv";
?>

<?php
$allowed_duplicate_columns = array('Roll', 'Asutuse nimi', 'Kontakt (nimi)',
                                   'Kontakt (e-post)');
$csv_file_name = "data.ignore";
$csv_temp_file_name = "datatemp.ignore";
$json_file_name = "dataprocessed.ignore";
$empty_json_file_name = "dataprocesseddummy.json";
$timestamp_file_name = "datatimestamp.ignore";
$date_format = "d.m.y H:i, e";

function download_csv($append = "") {
  global $csv_file_name;
  global $csv_temp_file_name;
  global $date_format;
  global $csv_url;
  $url = $csv_url;

  if (file_exists($append . $csv_temp_file_name)) {
    unlink($append . $csv_temp_file_name);
  }


  if (!file_exists($append . $csv_file_name)) {
    get_file($url, $append, $csv_file_name);
    return array(date($date_format), true);
  }

  // data.ignore exists, create datatemp.ignore

  get_file($url, $append, $csv_temp_file_name);
  $are_same = are_files_same($append, $csv_file_name, $csv_temp_file_name);
  if ($are_same) {
    unlink($append . $csv_temp_file_name);
    return array("Muudatused puuduvad. Proovige hiljem uuesti.", false);
  }

  // data.ignore and datatemp.ignore are different
  unlink($append . $csv_file_name);
  rename($append . $csv_temp_file_name, $append . $csv_file_name);
  return array(date($date_format), true);
}

function are_files_same($append, $csv_file_name, $csv_temp_file_name) {
  if(filesize($append . $csv_file_name) !== filesize($append . $csv_temp_file_name))
      return false;

  $a = fopen($append . $csv_file_name, 'rb');
  $b = fopen($append . $csv_temp_file_name, 'rb');

  $result = true;
  while(!feof($a)) {
    if(fread($a, 8192) != fread($b, 8192)) {
      $result = false;
      break;
    }
  }
  fclose($a);
  fclose($b);
  return $result;
}

function save_timestamp($ts, $append="") {
  global $timestamp_file_name;
  $f = @fopen($append . $timestamp_file_name, "wr+");
  if ($f !== false) {
      ftruncate($f, 0);
  }
  fwrite($f, $ts);
  fclose($f);
}

function get_timestamp($append = "") {
  global $timestamp_file_name;
  if (!file_exists($append . $timestamp_file_name)) {
    return "";
  }
  else {
    return file_get_contents($append . $timestamp_file_name);
  }
}

function get_file($file, $local_path, $newfilename) {
    $certificate = realpath($local_path . "cacert.pem");
    $err_msg = '';
    $out = fopen($local_path.$newfilename,"wb");
    if ($out == FALSE){
      exit;
    }

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_FILE, $out);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_URL, $file);
    curl_setopt($ch, CURLOPT_CAINFO, $certificate);
    curl_setopt($ch, CURLOPT_CAPATH, $certificate);

    curl_exec($ch);
    curl_close($ch);
}

function save_processed_data($array, $append) {
  global $json_file_name;
  if (file_exists($append . $json_file_name)) {
    unlink($append . $json_file_name);
  }
  $serialized = serialize($array);
  file_put_contents($append . $json_file_name, $serialized);
}

function load_processed_data($append="") {
  global $json_file_name;
  global $csv_file_name;
  global $empty_json_file_name;
  global $date_format;

  if (!file_exists($append . $json_file_name)) {
    if (!file_exists($append . $csv_file_name)) {
      $result = download_csv($append);
      if (!$result[1]) {
        $fileContents = file_get_contents($append . $empty_json_file_name);
        return unserialize($fileContents);
      }
    }
    $process_result = read_and_process_csv($append);
    if (!$process_result[1]) {
      $fileContents = file_get_contents($append . $empty_json_file_name);
      return unserialize($fileContents);
    }
    save_timestamp(date($date_format), $append);
  }
  $fileContents = file_get_contents($append . $json_file_name);
  $array = unserialize($fileContents);
  return $array;
}

function get_next_row_by_required_size($req_size, $arr, $i) {
  $row = $arr[$i];
  $row_size = sizeof($row);
  $next_i = $i + 1;
  if ($row_size < $req_size) {
    $val = get_next_row_by_required_size($req_size - $row_size + 1,
                                         $arr, $i + 1);
    $next_i = $val[1];
    $next_row = $val[0];
    $row[$row_size - 1] = $row[$row_size - 1] . "\n" . $next_row[0];
    $row = array_merge($row, array_slice($next_row, 1, sizeof($next_row) - 1));
  }

  $a = "";
  foreach ($row as $key => $value) {
    if (ctype_space($value)) {
      $row[$key] = "";
    }
    $a .= $row[$key];
  }
  if (strlen($a == 0)) {
    return array($row, $next_i, false);
  }
  return array($row, $next_i, true);
}

function merge_or_error($array, $headers) {
  global $allowed_duplicate_columns;
  $merged = array("-");
  for ($i=1; $i < sizeof($headers); $i++) {
   $value = "";
   for ($j=0; $j < sizeof($array); $j++) {
     if (!empty($array[$j][$i])) {
        if (!empty($value)
            and !in_array($headers[$i], $allowed_duplicate_columns)){
          // Note: This will not work if a single tick button field like "1.1.
          //  Läbipaistvat ja kaasavat poliitikakujundamist toetav
          //  infotehnoloogia (vastutaja: Riigikantselei)" is allowed to be
          //  filled through multiple requests
          return array("Mitu välja tulbas: " . $headers[$i] . ".\n" .
              "Leiti \"" . $value . "\" ja  \"" . $array[$j][$i] . "\".", false);
        }
        $value = $array[$j][$i];
     }
   }
   array_push($merged, $value);
  }
  return array($merged, true);
}

function read_and_process_csv($append="") {
  global $csv_file_name;
  $csv = array_map('str_getcsv', file($append . $csv_file_name));
  $row_count = sizeof($csv);
  $size = sizeof($csv[0]);
  $i = 1;
  $unmerged_array = array();
  while ($i < $row_count) {
    $val = get_next_row_by_required_size($size, $csv, $i);
    if ($val[2]) {
      if (sizeof($val[0]) != $size) {
        return array("Vale tulpade arv reas " . $i . ". Vajalik tulpade arv on: "
            . $size . " Oli: " . sizeof($val[0]), false);
      }
      array_push($unmerged_array, $val[0]);
    }
    $i = $val[1];
  }
  $m = merge_or_error($unmerged_array, $csv[0]);
  if (!$m[1]) {
    return $m;
  }
  $merged_array = $m[0];
  $fileContents = file_get_contents($append . 'datafields.json');

  $obj = json_decode($fileContents,true);

  $proc_array = $obj["processes"];
  $ind_array = $obj["slice indices"];
  $value_array = array();

  for ($i=0; $i < sizeof($proc_array); $i++) {
    $value_array[$i] = array();
    for ($j=0; $j < sizeof($proc_array[$i]); $j++) {
      $value_array[$i][$j] = array("progress" => array(), "links" => "",
                                   "reasoning" => "");
      $indices = $ind_array[$i][$j];
      $procs = $proc_array[$i][$j];
      $results = array_slice($merged_array, $indices["start"],
                           $indices["end"] - $indices["start"]);
      for ($k=0; $k < sizeof($procs); $k++) {
        $value_array[$i][$j]["progress"][$k] = -1;
        $proc = $procs[$k];
        for ($l=0; $l < sizeof($results); $l++) {
          if (strpos($results[$l], $proc) !== false) {
            $value_array[$i][$j]["progress"][$k] = $l;
          }
        }
      }
      $value_array[$i][$j]["links"] = $merged_array[$indices["end"]];
      $value_array[$i][$j]["reasoning"] = $merged_array[$indices["end"] + 1];
    }
  }
  save_processed_data($value_array, $append);
  return array("", true);
}


function get_progress_style($val) {
  if ($val <= 0) {
    return "pb-in-progress";
  } elseif ($val <= 50) {
    return "pb-in-progress";
  } elseif ($val < 100) {
    return "pb-almost-finished";
  } else {
    return "pb-finished";
  }
}

function get_progresses($data) {
  $progresses = array("epic" => array("val" => array(), "style" => array()),
                      "sub"  => array("val" => array(), "style" => array()));
  for ($i=0; $i < sizeof($data); $i++) {
    $epic = $data[$i];
    $progresses["epic"]["val"][$i] = array();
    $progresses["epic"]["style"][$i] = array();
    $progresses["sub"]["val"][$i] = array();
    $progresses["sub"]["style"][$i] = array();
    $epic_progress_sum = 0;
    for ($j=0; $j < sizeof($epic); $j++) {
      $sub = $data[$i][$j]["progress"];
      $sub_progress_sum = 0;
      foreach ($sub as $key => $state) {
        if ($state == 0) {
          $sub_progress_sum += 0;
        } elseif ($state == 1) {
          $sub_progress_sum += 50;
        } elseif ($state == 2) {
          $sub_progress_sum += 75;
        } elseif ($state == 3) {
          $sub_progress_sum += 100;
        } else {
          $sub_progress_sum += 0;
        }
      }
      $avg_sub_progress = min(round($sub_progress_sum/sizeof($sub)), 100);
      $progresses["sub"]["val"][$i][$j] = $avg_sub_progress;
      $progresses["sub"]["style"][$i][$j] = get_progress_style($avg_sub_progress);
      $epic_progress_sum += $avg_sub_progress;
    }
    $avg_progress = min(round($epic_progress_sum/sizeof($epic)), 100);
    $progresses["epic"]["val"][$i] = $avg_progress;
    $progresses["epic"]["style"][$i] = get_progress_style($avg_progress);
  }
  return $progresses;
}

?>
