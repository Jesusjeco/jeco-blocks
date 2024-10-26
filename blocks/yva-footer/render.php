<?php
$data = get_field('data');
$blockID = $block['id'];
//This classes are coming from the advance options in every block
$advanceClasses = isset($block['className']) ? $block['className'] : '';
?>

<div class="yva-footer <?= esc_attr($advanceClasses); ?>" id="<?= esc_attr($blockID); ?>">
  <div class="data">
    <div class="left">
      <?= $data['content_1'] ?>
    </div>
    <div class="right">
      <div class="icons">
        <?php
        $icons = isset($data['icons']) ? $data['icons'] : null;
        if ($icons) {
          foreach ($icons as $key => $icon) { ?>
            <div class="icon">
              <a target="_blank" href="<?= $icon['url'] ?>">
                <img src="<?= $icon['image']['url'] ?>" alt="<?= $icon['image']['alt'] ?>">
              </a>
            </div>
        <?php
          }
        }
        ?>
      </div>
      <?= $data['content_2'] ?>
    </div>
  </div>
  <div class="logo">
    <img loading="lazy" src="<?= $data['logo']['url'] ?>" alt="<?= $data['logo']['alt'] ?>">
  </div>
</div>