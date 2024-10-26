<?php
$data = get_field('data');
$blockID = $block['id'];
//This classes are coming from the advance options in every block
$advanceClasses = isset($block['className']) ? $block['className'] : '';
?>

<div class="yva-footer <?= esc_attr($advanceClasses); ?>" id="<?= esc_attr($blockID); ?>">
  <h1>yva-footer</h1>
</div>
