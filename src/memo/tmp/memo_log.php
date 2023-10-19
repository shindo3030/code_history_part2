<?php

$lists = [];

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

  if (!strlen($lists['memo_date'])) {
    $error['memo_date'] = 'メモ日時が空欄になっています';
  }
  return $error;
}


function dbConnect()
{
  $link = mysqli_connect('db', 'book_log', 'pass', 'book_log');
  if (!$link) {
    echo 'DBとの接続に失敗しました' . PHP_EOL;
    echo 'DebuggingError: ' . mysqli_connect_error() . PHP_EOL;
    exit;
  }
  //echo 'DBとの接続に成功しました' . PHP_EOL;
  return $link;
}

function memoRegister($link)
{
  echo 'メモを登録します' . PHP_EOL . PHP_EOL;
  echo 'メモタイトル：';
  $lists['title'] = trim(fgets(STDIN));

  echo '内容：';
  $lists['content'] = trim(fgets(STDIN));

  echo '日付(yyyy-mm-dd)：';
  $lists['memo_date'] = trim(fgets(STDIN));

  //入力値バリデーション処理
  $errors = validate($lists);
  if (COUNT($errors) > 0) {
    foreach ($errors as $validated) {
      echo $validated . PHP_EOL;
    }
    //入力ミスがあった場合関数の処理から抜ける
    return;
  }

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
    echo 'メモの登録に失敗しました';
    echo 'DebuggingError: ' . mysqli_error($link) . PHP_EOL;
  } elseif ($results) {
    echo 'メモの登録が登録できました' . PHP_EOL;
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

while (true) {
  //DBとの接続
  $link = dbConnect();

  echo '1:メモの登録' . PHP_EOL;
  echo '2:メモの表示' . PHP_EOL;
  echo '9:アプリケーションの終了' . PHP_EOL;
  echo '番号を入力してください:';
  $num = trim(fgets(STDIN));

  if ($num === '1') {
    memoRegister($link);
  } elseif ($num === '2') {
    memoDisplay($link);
  } else {
    mysqli_close($link);
    //echo 'DBとの接続を切断しました' . PHP_EOL;
    break;
  }

  //DBとの接続を切断

}
