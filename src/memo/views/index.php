<div class="container">
  <div class="mt-4 pb-2">
    <a href="new.php" class="btn btn-primary">新規メモの登録</a>
  </div>

  <?php if (count($lists) > 0) : ?>
    <?php foreach ($lists as $list) : ?>
      <section class="card text-dark my-3">
        <div class="card-body">
          <h3 class="card-title text-dark"><?php echo nl2br(escape($list['title']), false) ?></h3>
          <p class="card-text text-dark"><?php echo nl2br(escape($list['content']), false) ?></p>
          <p class="card-text text-dark"><?php echo  nl2br(escape($list['memo_date']), false) ?></p>
        </div>
      </section>
    <?php endforeach; ?>
  <?php else : ?>
    <p>現在登録されているメモはありません</p>
  <?php endif; ?>
</div>
