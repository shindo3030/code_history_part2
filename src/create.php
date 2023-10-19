<?php

require_once __DIR__ . '/lib/mysqli.php';

function validate($review)
{
  //バリデーション処理
  $error = [];
  //本のタイトル入力チェック
  if (!strlen($review['title'])) {
    $error['title'] = 'タイトルを入力してください';
  } elseif (strlen($review['title']) > 255) {
    $error['title'] = 'タイトルは255文字以内で入力してください';
  }
  //著者名のバリデーション
  if (!strlen($review['author'])) {
    $error['author'] = '著者名を入力してください';
  } elseif (strlen($review['author']) > 150) {
    $error['author'] = '著者名は150文字以内で入力してください';
  }
  //読書状況のバリデーション
  if (!in_array($review['status'], ['未読', '読んでいる', '読了'], true)) {
    $error['status'] = '読書状況は(未読、読んでいる、読了)のいずれかで入力してください';
  }
  //評価のバリデーション
  if ($review['score'] < 1 || $review['score'] > 5) {
    $error['score'] = '評価は1〜5の整数で入力してください';
  }
  //感想のバリデーション
  if (!strlen($review['summary'])) {
    $error['summary'] = '感想を入力してください';
  } elseif (strlen($review['summary']) > 1500) {
    $error['summary'] = '感想は1500文字以内で入力するしてください';
  }

  return $error;
}

function createReview($link, $review)
{
  $sql = <<<EOT
INSERT INTO reviews(
  title,
  author,
  status,
  score,
  summary
  )VALUES(
    "{$review['title']}",
    "{$review['author']}",
    "{$review['status']}",
    "{$review['score']}",
    "{$review['summary']}"
    )
EOT;

  $result = mysqli_query($link, $sql);
  if (!$result) {
    error_log('Failed to register data to reviews table');
    error_log('Debugging Error: ' . mysqli_error($link));
  }
}

//読書状況の未入力（ラジオボタン未選択）時のエラーが出てしまう対策
//読書状況が未選択の場合は$_POST['status']にnullが入る
$status = '';
if (array_key_exists('status', $_POST)) {
  $status = $_POST['status'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  //データの受け取り
  $review = [
    'title' => $_POST['title'],
    'author' => $_POST['author'],
    'status' => $status,
    'score' => $_POST['score'],
    'summary' => $_POST['summary']
  ];



  //バリデーション処理
  $errors = validate($review);
  if (count($errors) > 0) {
  } else {
    //データベースに接続
    $link = dbConnect();
    //データベースに登録
    createReview($link, $review);
    //データベースから切断
    mysqli_close($link);
    //リダイレクト
    header("Location: index.php");
  }
}
$title = '読書ログの登録';
$content = __DIR__ . '/views/new.php';
include __DIR__ . '/views/layout.php';
