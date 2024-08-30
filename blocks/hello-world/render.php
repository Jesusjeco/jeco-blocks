<?php
$data = get_field('data');
$blockID = $block['id'];
?>
<div class="hello-world" id="<?= $blockID ?>">
  <h1>Render block</h1>
  <p>This is the render block</p>
  <p><?= $data['text'] ?></p>
</div>