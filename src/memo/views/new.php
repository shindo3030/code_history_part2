<div class="container">
  <form action="create.php" method="POST">
    <h1 class="h3 mt-3">メモの登録</h1>
    <?php if (count($errors) > 0) : ?>
      <ul>
        <?php foreach ($errors as $error) : ?>
          <li><?php echo $error; ?></li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>

    <div class="container">
      <div class="form-group">
        <label for="title">メモのタイトル</label>
        <input type="text" class="form-control" name="title" id="title" value="<?php echo $lists['title']; ?>">
      </div>
      <div class="form-group">
        <label for="content">内容</label>
        <textarea class="form-control" name="content" id="content"><?php echo $lists['content']; ?>
      </textarea>
      </div>
      <div class="form-group">
        <label for="memo_date">日付</label>
        <input type="date" class="form-control" name="memo_date" id="memo_date" value="<?php echo $lists['memo_date']; ?>">
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-primary">登録する</button>
      </div>
    </div>
  </form>
</div>
