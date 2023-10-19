<?php
require_once __DIR__ . '/lib/mysqli.php';

$lists = [
  'title' => '',
  'content' => '',
  'memo_date' => ''
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $lists = [
    'title' => $_POST['title'],
    'content' => $_POST['content'],
    'memo_date' => $_POST['memo_date']
  ];

  $errors = validate($lists);
  if (!count($errors) > 0) {
    $link = dbConnect();
    memoRegister($link, $lists);
    mysqli_close($link);
    header("Location: index.php");
  }
}

$title = 'メモの登録';
$content = __DIR__ . '/views/new.php';
include __DIR__ . '/views/layout.php';
