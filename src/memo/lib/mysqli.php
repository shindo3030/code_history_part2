<?php
require __DIR__ . '/../../vendor/autoload.php';

function validate($lists)
{
  $error = [];
  //バリデーション処理
  //空欄だった場合
  if (!strlen($lists['title'])) {
    $error['title'] = 'タイトルが空欄になっています';
  } elseif ($lists['title'] > 255) {
    $error['title'] = 'タイトルは255文字以内で入力してください';
  }

  if (!strlen($lists['content'])) {
    $error['content'] = 'メモ内容が空欄になっています';
  } elseif ($lists['content'] > 2000) {
    $error['content'] =  'メモ内容は2000文字以内で入力してください';
  }

  $dates = explode('-', $lists['memo_date']);
  if (!strlen($lists['memo_date'])) {
    $error['memo_date'] = 'メモ日時が空欄になっています';
  } elseif (count($dates) !== 3) {
    $error['memo_date'] = '日時を正しい形式で入力してください';
  } elseif (!checkdate($dates[1], $dates[2], $dates[0])) {
    $error['memo_date'] = '正しい日付で入力してください';
  }

  return $error;
}


function dbConnect()
{
  $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../..');
  $dotenv->load();

  //$s3_bucket = getenv('S3_BUCKET');
  $dbHost = $_ENV['DB_HOST'];
  $dbUsername = $_ENV['DB_USERNAME'];
  $dbPassword = $_ENV['DB_PASSWORD'];
  $dbDatabase = $_ENV['DB_DATABASE'];

  $link = mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbDatabase);
  if (!$link) {
    error_log('DBとの接続に失敗しました');
    error_log('DebuggingError: mysqli_connect_error()');
    exit;
  }
  //echo 'DBとの接続に成功しました' . PHP_EOL;
  return $link;
}


function memoRegister($link, $lists)
{
  $sql = <<<EOP
  INSERT INTO lists(
    title,
    content,
    memo_date
  ) VALUE (
    "{$lists['title']}",
    "{$lists['content']}",
    "{$lists['memo_date']}"
  )
  EOP;

  $results = mysqli_query($link, $sql);
  if (!$results) {
    error_log('メモの登録に失敗しました');
    error_log('DebuggingError: ' . mysqli_error($link));
  } elseif ($results) {
    error_log('メモの登録が登録できました');
  }
}


function memoDisplay($link)
{
  echo '登録しているメモ内容を表示します' . PHP_EOL . PHP_EOL;
  $sql = <<<EOP
    SELECT id, title, content, memo_date, at_datetime FROM lists
  EOP;

  $results = mysqli_query($link, $sql);
  if (!$results) {
    echo 'データベースからの表示に失敗しました' . PHP_EOL;
    echo  'DebuggingError: ' . mysqli_error($link) . PHP_EOL;
    exit;
  } elseif ($results) {
    while ($result = mysqli_fetch_assoc($results)) {
      echo 'タイトル: ' . $result['title'] . PHP_EOL;
      echo 'メモ内容: ' . $result['content'] . PHP_EOL;
      echo '日時: ' . $result['memo_date'] . PHP_EOL;
      echo '--------------' . PHP_EOL;
    }
    mysqli_free_result($results);
  }
}
