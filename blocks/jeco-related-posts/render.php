<?php
$data = get_field('data');
$blockID = $block['id'];
// These classes are coming from the advanced options in every block
$advanceClasses = isset($block['className']) ? $block['className'] : '';

// Get categories of the current post
$current_categories = get_the_category();
$category_ids = [];

if ($current_categories && !is_wp_error($current_categories)) {
  foreach ($current_categories as $category) {
    $category_ids[] = $category->term_id;
  }
}

$args = [
  'post_types' => 'post',
  'posts_per_page' => 5,
  'post_categories' => $category_ids, // Only posts in the same categories
];

$jeco_related_posts_query = Jeco_Query_Manager::get_custom_query($args);
?>

<div class="jeco-related-posts <?= esc_attr($advanceClasses); ?>" id="<?= esc_attr($blockID); ?>">
  <h1>Jeco Related Posts</h1>

  <?php if ($jeco_related_posts_query->have_posts()): ?>
    <div class="jeco-post-list">
      <?php while ($jeco_related_posts_query->have_posts()):
        $jeco_related_posts_query->the_post(); ?>
        <h3>
          <a href="<?php the_permalink(); ?>">
            <?php the_title(); ?>
          </a>
        </h3>
      <?php endwhile; ?>
    </div>
    <?php wp_reset_postdata(); ?>
  <?php else: ?>
    <p>No related posts found.</p>
  <?php endif; ?>
</div>