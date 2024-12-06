<?php 
function add_faq_meta_box() {
    add_meta_box(
        'project_faqs',
        'FAQs',
        'render_faq_meta_box',
        'courses',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'add_faq_meta_box');

function render_faq_meta_box($post) {
    $faqs = get_post_meta($post->ID, 'project_faqs', true) ?: [];
    wp_nonce_field('save_project_faqs', 'project_faqs_nonce');
    ?>
    <div id="faqs-wrapper" class="acf-postbox">
        <button type="button" id="add-faq" class="button button-primary">Add FAQ</button>
        <ul id="faq-list">
            <?php foreach ($faqs as $index => $faq): ?>
                <li class="faq-item" style="border:1px solid #ccc; padding:10px; border-radius:10px;";>
                    <div class="acf-field acf-field-text">
						<p>#<?php echo $index+1; ?></p>
                        <div class="acf-label">
                            <label>Question</label>
                        </div>
                        <div class="acf-input">
                            <div class="acf-input-wrap"><input type="text" name="faq_question[]" value="<?php echo esc_attr($faq['question']); ?>" /></div>
                        </div>
                    </div>
                    <div class="acf-field acf-field-text">
                        <div class="acf-label">
                            <label>Answer</label>
                        </div>
                        <div class="acf-input">
                            <div class="acf-input-wrap"><textarea name="faq_answer[]"><?php echo esc_textarea($faq['answer']); ?></textarea></div>
                        </div>
                    </div>
                    <button type="button" class="remove-faq button button-secondary">Remove FAQ</button>
                    <hr>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const faqList = document.getElementById('faq-list');
            const addFaqButton = document.getElementById('add-faq');

            // Enable drag-and-drop sorting
            new Sortable(faqList, {
                animation: 150,
                handle: '.faq-item',
                ghostClass: 'sortable-ghost',
            });

            // Add new FAQ
            addFaqButton.addEventListener('click', function () {
                const newFaq = document.createElement('li');
                newFaq.classList.add('faq-item');
                newFaq.innerHTML = `
                    <div class="acf-field acf-field-text">
                        <div class="acf-label"><label>Question</label></div>
                        <div class="acf-input"><div class="acf-input-wrap"><input type="text" name="faq_question[]" /></div></div>
                    </div>
                    <div class="acf-field acf-field-text">
                        <div class="acf-label"><label>Answer</label></div>
                        <div class="acf-input"><div class="acf-input-wrap"><textarea name="faq_answer[]"></textarea></div></div>
                    </div>
                    <button type="button" class="remove-faq button button-secondary">Remove FAQ</button>
                    <hr>
                `;
                faqList.appendChild(newFaq);
            });

            // Remove FAQ
            faqList.addEventListener('click', function (event) {
                if (event.target.classList.contains('remove-faq')) {
                    event.target.closest('.faq-item').remove();
                }
            });
        });
    </script>
    <?php
}



function save_faq_meta_box($post_id) {
    // Verify nonce to ensure security
    if (!isset($_POST['project_faqs_nonce']) || !wp_verify_nonce($_POST['project_faqs_nonce'], 'save_project_faqs')) {
        return;
    }

    // Check if the user has permission to edit the post
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Prepare an array to hold FAQs
    $faqs = [];

    // Check if FAQ data is present and process it
    if (!empty($_POST['faq_question']) && !empty($_POST['faq_answer'])) {
        foreach ($_POST['faq_question'] as $index => $question) {
            if (!empty($question) && !empty($_POST['faq_answer'][$index])) {
                $faqs[] = [
                    'question' => sanitize_text_field($question),
                    'answer' => sanitize_textarea_field($_POST['faq_answer'][$index]),
                ];
            }
        }
    }

    // Save or delete the meta field based on the presence of FAQ data
    if (!empty($faqs)) {
        update_post_meta($post_id, 'project_faqs', $faqs);
    } else {
        delete_post_meta($post_id, 'project_faqs');
    }
}
add_action('save_post', 'save_faq_meta_box');


// Add this to your theme's functions.php file
function display_course_faqs_shortcode($atts) {
    // Extract attributes (optional, can be expanded as needed)
    $atts = shortcode_atts([
        'post_id' => get_the_ID(), // Default to the current post ID
    ], $atts);

    // Get the post ID from the attributes
    $post_id = intval($atts['post_id']);

    // Fetch the FAQs meta field
    $faqs = get_post_meta($post_id, 'project_faqs', true);

    // If there are no FAQs, return nothing
    if (empty($faqs)) {
        return '';
    }

    // Start building the output
    ob_start();
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
    <?php
    return ob_get_clean();
}

// Register the shortcode
add_shortcode('course_faqs', 'display_course_faqs_shortcode');
