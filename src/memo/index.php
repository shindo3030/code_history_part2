<?php

require_once __DIR__ . '/lib/mysqli.php';
require_once __DIR__ . '/lib/escape.php';

function listsMemo($link)
{
  $lists = [];
  $sql = 'SELECT title, content, memo_date FROM lists';
  $results = mysqli_query($link, $sql);
  while ($list = mysqli_fetch_assoc($results)) {
    $lists[] = $list;
  }
  mysqli_free_result($results);
  return $lists;
}

$link = dbConnect();
$lists = listsMemo($link);

$title = 'メモ一覧';
$content = __DIR__ . '/views/index.php';
include __DIR__ . '/views/layout.php';
