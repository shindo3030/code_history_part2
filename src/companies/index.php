<?php
require_once __DIR__ . '/lib/mysqli.php';
require_once __DIR__ . '/lib/escape.php';

function listCompanies($link)
{
  $companies = [];
  $sql = 'SELECT name,establishment_date, founder FROM companies';
  $results = mysqli_query($link, $sql);
  //mysqli_fetch_assoc　で　$resultの内容を見てデータ本体を取得し、$company変数に代入ご、配列へ格納　
  //変数 ⇨ 配列へ格納
  while ($company = mysqli_fetch_assoc($results)) {
    $companies[] = $company;
  }
  mysqli_free_result($results);
  return $companies;
}

$link = dbConnect();
$companies = listCompanies($link);

$title = '会社情報の一覧';
$content = __DIR__ . '/views/index.php';
include __DIR__ . '/views/layout.php';
