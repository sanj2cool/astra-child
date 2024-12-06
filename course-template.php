<?php
/**
 * Template Name: Course Tabs with AJAX Pagination
 * Template Post Type: page
 *
 * Custom page template to display courses by category in tabs with AJAX pagination.
 */

get_header(); ?>

<div class="container">
    <h1 class="page-title"><?php the_title(); ?></h1>

    <?php
    // Fetch all terms in the 'course-category' taxonomy
    $course_categories = get_terms([
        'taxonomy' => 'course-category',
        'hide_empty' => true,
    ]);

    if (!empty($course_categories) && !is_wp_error($course_categories)): ?>
       <div class="tabs" id="tabs">
			<?php foreach ($course_categories as $index => $category): ?>
				<div class="tab <?php echo $index === 0 ? 'active' : ''; ?>" data-category="<?php echo $category->term_id; ?>">
					<?php echo esc_html($category->name); ?>
				</div>
			<?php endforeach; ?>
		</div>
		
		<div class="tab-content">
		    <?php foreach ($course_categories as $index => $category): ?>
			<div id="category-<?php echo $category->term_id; ?>" class="tab-pane <?php echo $index === 0 ? 'active' : ''; ?>">
				<div class="course-list">
					 <?php
        $query = new WP_Query([
            'post_type' => 'courses',
            'posts_per_page' => 2,
            'paged' => 1,
            'tax_query' => [
                [
                    'taxonomy' => 'course-category',
                    'field'    => 'term_id',
                    'terms'    => $category->term_id,
                ],
            ],
        ]);

        if ($query->have_posts()) :
            while ($query->have_posts()) :
                $query->the_post();
                ?>
                <div class="cards">
                    <img src="<?php echo esc_url(get_the_post_thumbnail_url() ?: 'https://leadwithtech.in/wp-content/uploads/2024/11/311996.jpg'); ?>" alt="Course Image">
                    <div class="container">
                        <h4>Live Classroom / Classroom</h4>
                        <h2><?php the_title(); ?></h2>
                        <p>
                            <i class="fa fa-clock-o"></i> 16 Hrs<br>
                            <i class="fa fa-users"></i> 144689 Enrolled
                        </p>
                        <div class="recommended">Recommended</div>
                        <p>Start from <span style="color: green;">₹14,499</span></p>
                        <button>Enroll Now</button>
                    </div>
                </div>
                <?php
            endwhile;
            wp_reset_postdata();
        else :
            echo '<p>No courses found.</p>';
        endif;
        ?>
				</div>
				<button id="load-more" data-category-id="<?php echo $category->term_id; ?>" data-max-pages="<?php echo $query->max_num_pages; ?>">Load More</button>
				</div>
			<?php endforeach; ?>
		</div>

        
    <?php else: ?>
        <p>No course categories found.</p>
    <?php endif; ?>
</div>

<script>



    
</script>
<?php get_footer(); ?>
