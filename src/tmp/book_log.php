<?php
require __DIR__ . '/../vendor/autoload.php';

function validate($review)
{
  $errors = [];

  //書籍名が正しく入力されているかチェック
  if (!strlen($review['title'])) {
    $errors['title'] = '書籍名を入力してください';
  } else if (strlen($review['title']) > 255) {
    $errors['title'] = '書籍名は255文字以内で入力してください';
  }
  //著者名の文字列が文字数制限内に収まっているかチェック
  if (!strlen($review['author'])) {
    $errors['author'] = '著者名を入力してください';
  } elseif (strlen($review['author']) > 255) {
    $errors['author'] = '著者名は255文字以内で入力してください';
  }
  //読書状況(未読、読んでいる、読了)の３択の内いずれかが入っているかチェック
  if (!in_array($review['status'], ['未読', '読んでいる', '読了'], true)) {
    $errors['status'] = '読書状況は(未読、読んでいる、読了)のいずれかで入力してください';
  }

  //評価が正しく入力されているかチェック 条件式が否定になるので注意
  if ($review['score'] < 1 || $review['score'] > 5) {
    $errors['score'] = '評価は1〜5の整数を入力してください';
  }
  //感想の文字列が文字数制限内に収まっているかチェック
  if (!strlen($review['summary'])) {
    $errors['summary'] = '感想を入力してください';
  } elseif ($review['summary'] > 1500) {
    $errors['summary'] = '感想は1500文字以内で入力してください';
  }

  return $errors;
}


function dbConnect()
{

  // dbHost = DB_HOST;
  // dbUsername = DB_USERNAME;
  // dbPassword = DB_PASSWORD;
  // dbDatabase = DB_DATABASE;

  $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
  $dotenv->load();

  $dbHost  = $_ENV['DB_HOST'];
  $dbUsername  = $_ENV['DB_USERNAME'];
  $dbPassword  = $_ENV['DB_PASSWORD'];
  $dbDatabase  = $_ENV['DB_DATABASE'];

  $link = mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbDatabase);
  if (!$link) {
    echo 'Error: データベースに接続できませんでした' . PHP_EOL;
    echo 'Debugging error: ' . mysqli_connect_error() . PHP_EOL;
    exit;
  }

  echo 'データベースに接続しました' . PHP_EOL;
  return $link;
}


function createReview($link)
{
  $review = [];

  echo '読書ログを登録してください' . PHP_EOL;
  echo '書籍名：';
  $review['title'] = trim(fgets(STDIN));
  echo '著者名：';
  $review['author'] = trim(fgets(STDIN));

  echo '読書状況 (未読,読んでいる,読了)：';
  $review['status'] = trim(fgets(STDIN));

  echo '評価(１〜５点満点の整数)：';
  $review['score'] = (int)trim(fgets(STDIN));

  echo '感想：';
  $review['summary'] = trim(fgets(STDIN));

  $validated = validate($review);
  if (count($validated) > 0) {
    foreach ($validated as $error) {
      echo $error . PHP_EOL;
    }
    //エラーすべて表示後、インサート前に処理を終わらせておく
    return;
  }

  $sql = <<<EOT
  INSERT INTO reviews (
    title,
    author,
    status,
    score,
    summary
    ) VALUES (
    "{$review['title']}",
    "{$review['author']}",
    "{$review['status']}",
    "{$review['score']}",
    "{$review['summary']}"
    )
EOT;

  $result = mysqli_query($link, $sql);
  if ($result) {
    echo 'データベースにデータが登録されました' . PHP_EOL;
  } else {
    echo 'データベースにデータが登録できませんでした' . PHP_EOL;
    echo 'DebuggingError: ' . mysqli_error($link) . PHP_EOL . PHP_EOL;
  }
}


function displayReview($link)
{
  echo '登録されている読書ログを表示します' . PHP_EOL;

  $sql = 'SELECT id, title, author, status, score, summary FROM reviews';
  $results = mysqli_query($link, $sql);

  while ($review = mysqli_fetch_assoc($results)) {
    echo '書籍名:' . $review['title'] . PHP_EOL;
    echo  '著者名:' . $review['author'] . PHP_EOL;
    echo '読書状況:' . $review['status'] . PHP_EOL;
    echo '評価:' . $review['score'] . PHP_EOL;
    echo '感想:' . $review['summary'] . PHP_EOL;
    echo '-------------' . PHP_EOL;
  }
  mysqli_free_result($results);

  // foreach ($reviews as $review) {
  // }
}


$reviews = [];
//実行後に戻り値を使用するため$linkへ入れる
$link = dbConnect();

while (true) {
  echo '1:読書ログの登録' . PHP_EOL;
  echo '2:読書ログの表示' . PHP_EOL;
  echo '9:アプリケーションの終了' . PHP_EOL;
  echo '番号を選択してください(1,2,9):';
  $num = trim(fgets(STDIN));


  if ($num === '1') {
    createReview($link);
  } elseif ($num === '2') {
    displayReview($link);
  } elseif ($num === '9') {
    // アプリケーションの終了
    //接続時のここで$linkを使用する
    mysqli_close($link);
    echo 'データベースとの接続を切断しました' . PHP_EOL;
    break;
  }
}
