<?php
/**
 * Template for displaying single course
 *
 * @package Tutor\Templates
 * @author Themeum <support@themeum.com>
 * @link https://themeum.com
 * @since 1.0.0
 */

$course_id     = get_the_ID();
$course_rating = tutor_utils()->get_course_rating( $course_id );
$is_enrolled   = tutor_utils()->is_enrolled( $course_id, get_current_user_id() );

// Prepare the nav items.
$course_nav_item = apply_filters( 'tutor_course/single/nav_items', tutor_utils()->course_nav_items(), $course_id );
$is_public       = \TUTOR\Course_List::is_public( $course_id );
$is_mobile       = wp_is_mobile();

$enrollment_box_position = tutor_utils()->get_option( 'enrollment_box_position_in_mobile', 'bottom' );
if ( '-1' === $enrollment_box_position ) {
	$enrollment_box_position = 'bottom';
}
$student_must_login_to_view_course = tutor_utils()->get_option( 'student_must_login_to_view_course' );

tutor_utils()->tutor_custom_header();

if ( ! is_user_logged_in() && ! $is_public && $student_must_login_to_view_course ) {
	tutor_load_template( 'login' );
	tutor_utils()->tutor_custom_footer();
	return;
}
?>
<style>

.tutor-full-width-course-top {
	position: relative; /* Ensure content inside behaves normally */
  margin-left: calc(-50vw + 50%) !important; /* Offset the container to the left */
  margin-right: calc(-50vw + 50%) !important; /* Offset the container to the right */
  width: 100vw; /* Make it span the full viewport width */
  background-color: lightblue; /* Optional styling for clarity */
}
.accordion .accordion-item {
  border-bottom: 1px solid #e5e5e5;
    background: #fff;
    padding: 10px;
    margin-top: 15px;
    border-radius: 15px;
    box-shadow: 0px 0px 3px #d2c9c9;
}

.accordion .accordion-item button[aria-expanded='true'] {
 border-bottom: 1px solid #faf4e8;
}

.accordion button {
  position: relative;
  display: block;
  text-align: left;
  width: 100%;
  padding: 1em 0;
  color: #7288a2;
  font-size: 1.15rem;
  font-weight: 400;
  border: none;
  background: none;
  outline: none;
  padding: 10px 20px;
}

.accordion button:hover,
.accordion button:focus {
  cursor: pointer;
  color: #da291c;
}

.accordion button:hover::after,
.accordion button:focus::after {
  cursor: pointer;
  color: #03b5d2;
  border: 1px solid #da291c;
}

.accordion button .accordion-title {
    padding: 0px;
    display: inline-block;
    font-size: 14px;
    font-weight: 700;
    font-family: 'Poppins';
    color: #222;
}

.accordion button .icon {
  display: inline-block;
  position: absolute;
  top: 18px;
  right: 0;
  width: 22px;
  height: 22px;
  border: 1px solid;
  border-radius: 22px;
}

.accordion button .icon::before {
  display: block;
  position: absolute;
  content: '';
  top: 9px;
  left: 5px;
  width: 10px;
  height: 2px;
  background: currentColor;
}
.accordion button .icon::after {
  display: block;
  position: absolute;
  content: '';
  top: 5px;
  left: 9px;
  width: 2px;
  height: 10px;
  background: currentColor;
}

.accordion button[aria-expanded='true'] {
     color: #da291c;
}
.accordion button[aria-expanded='true'] .icon::after {
  width: 0;
}
.accordion button[aria-expanded='true'] + .accordion-content {
  opacity: 1;
  max-height: 9em;
  transition: all 200ms linear;
  will-change: opacity, max-height;
}
.accordion .accordion-content {
  opacity: 0;
  max-height: 0;
  overflow: hidden;
  transition: opacity 200ms linear, max-height 200ms linear;
  will-change: opacity, max-height;
  font-family: 'roboto';
  padding:10px 20px;
}
.accordion .accordion-content p {
  font-size: 14px;
  font-weight: 400;
  margin: 0;
}

.ast-container{
	display: block !important;
}
.pink-sec {
	background: #FDFAF5 !important;
	
	
}

.pink-sec h3{
	
    font-size: 14px;
    font-weight: 600;
    text-transform: uppercase;
    line-height: 16px;
    letter-spacing: 0.5px;
	  color: #da291c;
}

.pink-sec h2{
	color: #1E2436;
  font-family: "Poppins",Sans-serif;
  font-size: 40px;
  font-weight: 700;
  line-height: 43px;
}
.tutor-icon-bullet-point:before{
	content: '\f058';
    display: inline-block;
    color: #da291c;
    padding: 0 6px 0 0;
    font-family: 'Font Awesome 5 Free';
    font-weight: 900;
    font-size: 22px !important;
    margin-top: -5px !important;
}
.tutor-thumb img{
	border-radius: 8px;
}
.course-faq{
	padding: 40px ;
}
.course-faq p{
	color: #718AA5;
    font-family: "Poppins", Sans-serif;
    font-size: 14px;
    font-weight: 600;
    text-transform: uppercase;
    line-height: 16px;
    letter-spacing: 0.5px;
}
</style>
<div class="tutor-wrap tutor-full-width-course-top tutor-course-top-info tutor-page-wrap tutor-wrap-parent post-3857 courses type-courses status-publish hentry course-category-developers course-category-github-copilot ast-article-single pink-sec">

	<div class="tutor-row tutor-gx-xl-5">
		<div class="tutor-col-xl-6 tutor-mt-32">
			<h3 class="tutor-fs-5 tutor-fw-bold tutor-color-black tutor-mb-12">GitHub Copilot Certification Training</h3>
			<h2 class="tutor-fs-5 tutor-fw-bold tutor-color-black tutor-mb-12">Documenting existing Code using Github Copilot</h2>
				<ul class="tutor-course-details-widget-list tutor-color-black tutor-fs-6 tutor-m-0 tutor-mt-16">
					<li class="tutor-d-flex tutor-mb-12"><span class="tutor-icon-bullet-point tutor-color-muted tutor-mt-2 tutor-mr-8 tutor-fs-8 list-icon"></span>This Workshop focused on, fundamentals of GitHub Copilot and then help define prompts , context and document code for better understanding w.r.t Maintainability.</li>
					<li class="tutor-d-flex tutor-mb-12"><span class="tutor-icon-bullet-point tutor-color-muted tutor-mt-2 tutor-mr-8 tutor-fs-8 list-icon"></span>
					Become an Exceptional GitHub Copilot Master with Real-Time GitHub Copilot practical trainings.</li>

				</ul>
		</div>
				<div class="tutor-col-xl-6">
					
					<div class="tutor-course-thumbnail tutor-thumb">
            			<img src="https://leadwithtech.in/wp-content/uploads/2024/11/1563.jpg">
        			</div>
				</div>
	</div>
</div>
<?php do_action( 'tutor_course/single/before/wrap' ); ?>
<div <?php tutor_post_class( 'tutor-full-width-course-top tutor-course-top-info tutor-page-wrap tutor-wrap-parent' ); ?>>
	<div class="tutor-course-details-page tutor-container">
	<?php //( isset( $is_enrolled ) && $is_enrolled ) ? tutor_course_enrolled_lead_info() : tutor_course_lead_info(); ?>
		<div class="tutor-row tutor-gx-xl-5">
			<main class="tutor-col-xl-8">
				<?php //tutor_utils()->has_video_in_single() ? tutor_course_video() : get_tutor_course_thumbnail(); ?>
				
				<?php do_action( 'tutor_course/single/before/inner-wrap' ); ?>

				<?php if ( $is_mobile && 'top' === $enrollment_box_position ) : ?>
					<div class="tutor-mt-32">
						<?php tutor_load_template( 'single.course.course-entry-box' ); ?>
					</div>
				<?php endif; ?>
				

				<div class="tutor-course-details-tab tutor-mt-32">

					<?php if ( is_array( $course_nav_item ) && count( $course_nav_item ) > 1 ) : ?>
						<div class="tutor-is-sticky">
							<?php //tutor_load_template( 'single.course.enrolled.nav', array( 'course_nav_item' => $course_nav_item ) ); ?>
						</div>
					<?php endif; ?>
					<div class="tutor-tab tutor-pt-24">
						<?php foreach ( $course_nav_item as $key => $subpage ) : ?>
							<div id="tutor-course-details-tab-<?php echo esc_attr( $key ); ?>" class="tutor-tab-item<?php echo 'info' == $key ? ' is-active' : ''; ?>">
								<?php
									do_action( 'tutor_course/single/tab/' . $key . '/before' );

									$method = $subpage['method'];
								if ( is_string( $method ) ) {
									$method();
								} else {
									$_object = $method[0];
									$_method = $method[1];
									$_object->$_method( get_the_ID() );
								}

									do_action( 'tutor_course/single/tab/' . $key . '/after' );
								?>
							</div>
						<?php endforeach; ?>
					</div>
					
				</div>
				<div class="tutor-single-course-sidebar-more tutor-mt-24">
						<?php //tutor_course_instructors_html(); ?>
						<?php tutor_course_requirements_html(); ?>
						<?php tutor_course_tags_html(); ?>
						<?php tutor_course_target_audience_html(); ?>
				</div>
				<div class="pink-sec course-faq tutor-mt-40">
					<p class="tutor-fs-5 tutor-fw-bold tutor-color-black tutor-mb-12">Certified GitHub Copilot Certification Course FAQs</p>
					<h2 class="tutor-fs-5 tutor-fw-bold tutor-color-black tutor-mb-12">Frequently Asked Questions</h2>


				<?php 
				 $post_id=get_the_ID();
				// Fetch the FAQs meta field
					$faqs = get_post_meta($post_id, 'project_faqs', true);
						// Retrieve course duration
                     // Get course ID (usually from the loop or query)
					$course_id = get_the_ID();

					// Retrieve course duration
					$course_duration = get_post_meta($course_id, '_tutor_course_duration', true);

					// Retrieve course price
					$course_price = get_post_meta($course_id, '_tutor_course_price', true);

					// Display the values
					echo 'Duration: ' . esc_html($course_duration);
					echo '<br>';
					echo 'Price: ' . esc_html($course_price);
					// If there are no FAQs, return nothing
					if (empty($faqs)) {
						return '';
					}
				?>

<div class="course-faqs">
        <div class="accordion">
            <?php foreach ($faqs as $index => $faq): ?>
               <!-- <li>
                    <strong><?php echo esc_html($faq['question']); ?></strong>
                    <p><?php echo esc_html($faq['answer']); ?></p>
                </li> -->
				
				<div class="accordion-item">
					  <button id="accordion-button-1" aria-expanded="false">
						<span class="accordion-title"><?php echo esc_html($faq['question']); ?></span>
						<span class="icon" aria-hidden="true"></span>
					  </button>
					  <div class="accordion-content">
						<p><?php echo esc_html($faq['answer']); ?></p>
					  </div>
					</div>
				
            <?php endforeach; ?>
        </div>
    </div>
				
				

			</div>

				<?php do_action( 'tutor_course/single/after/inner-wrap' ); ?>

				
			</main>

			<aside class="tutor-col-xl-4">
				<?php $sidebar_attr = apply_filters( 'tutor_course_details_sidebar_attr', '' ); ?>
				<div class="tutor-single-course-sidebar tutor-mt-40 tutor-mt-xl-0" <?php echo esc_attr( $sidebar_attr ); ?> >
					<?php do_action( 'tutor_course/single/before/sidebar' ); ?>

					<?php if ( ( $is_mobile && 'bottom' === $enrollment_box_position ) || ! $is_mobile ) : ?>
						<?php tutor_load_template( 'single.course.course-entry-box' ); ?>
					<?php endif ?>

					
						
					<?php do_action( 'tutor_course/single/after/sidebar' ); ?>
				</div>
			</aside>
		</div>
	</div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
  const items = document.querySelectorAll('.accordion button');

  function toggleAccordion() {
    const itemToggle = this.getAttribute('aria-expanded');

    // Collapse all accordion items
    items.forEach((item) => item.setAttribute('aria-expanded', 'false'));

    // Expand the clicked item if it was not already expanded
    if (itemToggle === 'false') {
      this.setAttribute('aria-expanded', 'true');
    }
  }

  // Add click event listener to all accordion items
  items.forEach((item) => item.addEventListener('click', toggleAccordion));

  // Expand the first item by default
  if (items.length > 0) {
    items[0].setAttribute('aria-expanded', 'true');
  }
});
</script>

<?php do_action( 'tutor_course/single/after/wrap' ); ?>

<?php
tutor_utils()->tutor_custom_footer();
