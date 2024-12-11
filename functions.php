<?php
/**
 * astra-child Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package astra-child
 * @since 1.0.0
 */

/**
 * Define Constants
 */
define( 'CHILD_THEME_ASTRA_CHILD_VERSION', '1.0.0' );

/**
 * Enqueue styles
 */
function child_enqueue_styles() {

	wp_enqueue_style( 'astra-child-theme-css', get_stylesheet_directory_uri() . '/style.css', array('astra-theme-css'), CHILD_THEME_ASTRA_CHILD_VERSION, 'all' );

}

add_action( 'wp_enqueue_scripts', 'child_enqueue_styles', 15 );



//Added Custom Funciton to Add FAQ on Course Pages
require get_stylesheet_directory() . '/custom-function.php';
function enqueue_sortable_script() {
    wp_enqueue_script('sortable-js', 'https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js', [], null, true);
}
add_action('admin_enqueue_scripts', 'enqueue_sortable_script');

//Custom function for Tabbed Courses on Home page
require get_stylesheet_directory() . '/tab-course-template.php';








function enqueue_load_more_courses_script() {
    // Enqueue the script for loading more courses
    wp_enqueue_script('load-more-courses', get_stylesheet_directory_uri() . '/js/load-more-courses.js', array('jquery'), null, true);

    // Localize the script with Ajax URL
    wp_localize_script('load-more-courses', 'ajaxurl', admin_url('admin-ajax.php'));
}
add_action('wp_enqueue_scripts', 'enqueue_load_more_courses_script');

function load_more_courses_ajax_handler() {
    // Get the category ID and current page number
    $category_id = isset($_POST['category_id']) ? intval($_POST['category_id']) : 0;
    $paged = isset($_POST['paged']) ? intval($_POST['paged']) : 1;

    // Define the query arguments for courses
    $args = array(
        'post_type' => 'courses',
        'posts_per_page' => 6,
        'paged' => $paged,
        'tax_query' => array(
            array(
                'taxonomy' => 'course-category',
                'field'    => 'term_id',
                'terms'    => $category_id,
            ),
        ),
    );

    // Run the query
    $query = new WP_Query($args);
    $courses = [];

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $courses[] = array(
                'title' => get_the_title(),
                'image' => get_the_post_thumbnail_url() ?: 'https://leadwithtech.in/wp-content/uploads/2024/11/311996.jpg',
                'duration' => '16 Hrs', // Adjust this field as needed
                'enrolled' => '144689', // Adjust this field as needed
                'price' => '14,499', // Adjust this field as needed
            );
        }

        // Get the total number of pages
        $max_pages = $query->max_num_pages;

        wp_reset_postdata();

        // Send the courses data as JSON response
        wp_send_json_success(array(
            'courses' => $courses,
            'max_pages' => $max_pages,
        ));
    } else {
        wp_send_json_error('No more courses.');
    }
}
add_action('wp_ajax_load_more_courses', 'load_more_courses_ajax_handler');
add_action('wp_ajax_nopriv_load_more_courses', 'load_more_courses_ajax_handler');