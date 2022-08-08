<?php
$inp = readline("Type a string you want to encrypt: ");

$inp_arr = str_split($inp);
foreach ($inp_arr as $i) {
  $i++;
  echo $i;
}
