<?php

$ary1 = array("ホノルル", "ロサンゼルス");
$ary2 = array("NYC" => "ニューヨーク", "CHI" => "シカゴ");


$ary3 = [];
$ary3['ハワイ'] = trim(fgets(STDIN));
$ary3['シカゴ'] = trim(fgets(STDIN));
$ary3['シカゴ'] = trim(fgets(STDIN));

$ary4[0] = 'ハワイ';
$ary4[1] = 'シカゴ';
//$ary5 = [];
$ary5 = ["NYC" => "ニューヨーク", "CHI" => "シカゴ"];
var_dump(in_array($ary3['シカゴ'], ['ニューヨーク', 'シカゴ']));
var_dump(in_array($ary4[1], ['ニューヨーク', 'シカゴ']));
var_dump(in_array($ary3['シカゴ'], $ary5));
var_export($ary3);
var_export($ary4);
var_export($ary5);
