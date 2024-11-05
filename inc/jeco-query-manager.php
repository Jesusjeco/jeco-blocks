<?php

class Jeco_Query_Manager {

    /**
     * Generate a custom WP_Query based on provided arguments.
     *
     * @param array $args Optional. Array of query arguments.
     * @return WP_Query The generated WP_Query instance.
     *
     * Usage: You can create an instance or use the class directly and store the query in a variable.
     * For example: $jeco_custom_query = Jeco_Query_Manager::get_custom_query($args); 
     */
    public static function get_custom_query($args = []) {
        $defaults = [
            'post_types'       => 'post',
            'post_categories'  => null,
            'posts_per_page'   => 3,
            'orderby'          => 'date',
            'order'            => 'DESC',
            'exclude_current'  => true,
            'offset'           => 0,
            'meta_query'       => [],
            'tax_query'        => [],
            'date_query'       => [],
        ];

        // Merge user arguments with defaults
        $args = wp_parse_args($args, $defaults);

        // Sanitize inputs
        $post_type = sanitize_text_field($args['post_types']);
        $categories = is_array($args['post_categories']) ? array_map('intval', $args['post_categories']) : (array) $args['post_categories'];
        $posts_per_page = intval($args['posts_per_page']) > 0 ? intval($args['posts_per_page']) : -1;
        $orderby = sanitize_text_field($args['orderby']);
        $order = strtoupper($args['order']) === 'ASC' ? 'ASC' : 'DESC';

        // Base query arguments
        $query_args = [
            'post_type'      => $post_type,
            'posts_per_page' => $posts_per_page,
            'category__in'   => $categories,  // Using category__in for multiple categories
            'offset'         => intval($args['offset']),
            'post_status'    => 'publish',
            'orderby'        => $orderby,
            'order'          => $order,
            'meta_query'     => $args['meta_query'],
            'tax_query'      => $args['tax_query'],
            'date_query'     => $args['date_query'],
        ];

        // Optionally exclude the current post if on a single post view
        if (!empty($args['exclude_current']) && is_single()) {
            $query_args['post__not_in'] = [get_the_ID()];
        }

        return new WP_Query($query_args);
    }
}