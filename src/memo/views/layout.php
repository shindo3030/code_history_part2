<!DOCTYPE html>
<html lang="ja">
<haead>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="stylesheets/css/app.css">
  <title><?php echo $title; ?></title>
</haead>

<body>
  <header class="fixed-top shadow-sm">
    <nav class="navbar bg-light">
      <a href="index.php" class="text-dark" style="text-decoration:none;">
        <h3 class="pt-1 pl-2 mt-1">メモアプリ</h3>
      </a>
    </nav>
  </header>
  <div class="pt-5 mt-4">
  </div>
  <?php include $content; ?>
  <div class="pb-3 mb-5"></div>
</body>

</html>
