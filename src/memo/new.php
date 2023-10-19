<?php

$lists = [
  'title' => '',
  'content' => '',
  'memo_date' => ''
];

$errors = [];

$title = 'メモの登録';
$content = __DIR__ . '/views/new.php';
include __DIR__ . '/views/layout.php';
