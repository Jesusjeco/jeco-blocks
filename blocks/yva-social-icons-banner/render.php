<?php
$data = get_field('data');
$blockID = $block['id'];
//This classes are coming from the advance options in every block
$advanceClasses = isset($block['className']) ? $block['className'] : '';
?>

<div class="yva-social-icons-banner <?= esc_attr($advanceClasses); ?>" id="<?= esc_attr($blockID); ?>">
  <div class="left">
    <div class="title"><?= $data['title'] ?></div>
    <div class="icons">
      <?php
      $icons = isset($data['icons']) ? $data['icons'] : null;
      if ($icons) {
        foreach ($icons as $key => $icon) { ?>
          <div class="icon">
            <a target="_blank" href="<?= $icon['url'] ?>">
              <img src="<?= $icon['icon']['url'] ?>" alt="<?= $icon['icon']['alt'] ?>">
            </a>
          </div>
      <?php
        }
      }
      ?>
    </div>
  </div>
  <div class="right">
    <div class="title"><?= $data['title_2'] ?></div>
    <div class="icons">
      <?php
      $icons = isset($data['icons_2']) ? $data['icons_2'] : null;
      if ($icons) {
        foreach ($icons as $key => $icon) { ?>
          <div class="icon">
            <a target="_blank" href="<?= $icon['url'] ?>">
              <img src="<?= $icon['icon']['url'] ?>" alt="<?= $icon['icon']['alt'] ?>">
            </a>
          </div>
      <?php
        }
      }
      ?>
    </div>
  </div>
</div>