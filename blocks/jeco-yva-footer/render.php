<?php
$data = get_field('data');
$blockID = $block['id'];
?>
<style>
  #<?= $blockID ?> {
    background-color: <?= $data['background_color'] ?>;
  }
</style>
<div class="jeco-yva-footer" id="<?= $blockID ?>">
  <div class="wrapper-full">
    <div class="left">
      <div class="column1"><?= $data['column_1'] ?></div>
      <div class="column2"><?= $data['column_2'] ?></div>
      <div class="text"><?= $data['text'] ?></div>
    </div>
    <div class="logo"><img src="<?= $data['logo']['url'] ?>" alt="<?= $data['logo']['alt'] ?>"></div>
  </div>
</div>