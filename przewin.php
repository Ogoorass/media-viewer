<?php

$currentFile = $_GET["currentFile"];
$mode = $_GET["mode"];

$cep = exec("bash plikiZRozszerzeniem.sh");
$arr = explode(",", $cep);




if ($currentFile == null) {
    echo $arr[0];
    exit;
}


$currentFile = str_replace("&#346;", "Ś", $currentFile);


foreach ($arr as $k => $v) {
    if ($v == $currentFile) {
        if ($mode == "1") {
            echo $arr[$k + 1];
            exit;
        } elseif ($mode == "0") {
            echo $arr[$k - 1];
            exit;
        }
    }
}
echo "error 404 - ni ma";
