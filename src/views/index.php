  <a href="new.php" class="btn btn-primary mt-4 mb-4">読書ログを登録する</a>
  <main>
    <?php if (count($reviews) > 0) : ?>
      <?php foreach ($reviews as $review) : ?>
        <section class="card shadow-sm mb-3">
          <div class="card-body mb-3">
            <h2 class="h3 mb-3"><?php echo escape($review['title']) ?></h2>
            <div class="small text-dark mb-3"><?php echo escape($review['author']) ?>&nbsp;/&nbsp;<?php echo escape($review['status']) ?>&nbsp;/&nbsp;<?php echo escape($review['score']) ?></div>
            <p class="h5"><?php echo nl2br(escape($review['summary']), false) ?>
            </p>
          </div>
        </section>
      <?php endforeach; ?>
    <?php else : ?>
      <p class="text-dark">データが登録されていません</p>
    <?php endif; ?>



    <!-- <section>
      <h2>本のタイトル</h2>
      <div>本の作者名&nbsp;/&nbsp;読了&nbsp;/&nbsp;５点</div>
      <p>寝食を忘れ、貪るように読んでしまった。圧倒的な神本。感情を揺さぶられ、悲しみ・興奮・感動のすべてが押し寄せる。
      </p>
    </section> -->
  </main>
  </div>
