<?php
$data = get_field('data');
$blockID = $block['id'];
$advanceClasses = isset($block['className']) ? $block['className'] : '';
?>

<div class="hello-world <?= esc_attr($advanceClasses); ?>" id="<?= esc_attr($blockID); ?>">
  <h1>Render block</h1>
  <p>This is the render block</p>
  <p><?= esc_html($data['text'] ?? ""); ?></p>
</div>
