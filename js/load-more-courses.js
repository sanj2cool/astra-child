document.addEventListener('DOMContentLoaded', function () {
    const tabs = document.querySelectorAll('.tab');
    const tabPanes = document.querySelectorAll('.tab-pane');
    const loadMoreButtons = document.querySelectorAll('#load-more');

    // Tab click event handler
    tabs.forEach(tab => {
        tab.addEventListener('click', function (e) {
            e.preventDefault();

            // Remove active class from all tabs and tab panes
            tabs.forEach(t => t.classList.remove('active'));
            tabPanes.forEach(pane => pane.classList.remove('active'));

            // Add active class to clicked tab and corresponding pane
            this.classList.add('active');
            const target = document.querySelector('#category-' + this.dataset.category);
            target.classList.add('active');
        });
    });

    // Load more button click handler
    loadMoreButtons.forEach(button => {
        button.addEventListener('click', function () {
            const categoryId = this.dataset.categoryId;
            const currentPage = parseInt(this.dataset.currentPage) || 1;
            const maxPages = parseInt(this.dataset.maxPages);

            if (currentPage >= maxPages) {
                alert('No more courses to load.');
                return;
            }

            // Increment the page for the next request
            const nextPage = currentPage + 1;

            // Send AJAX request
            const data = new FormData();
            data.append('action', 'load_more_courses');
            data.append('category_id', categoryId);
            data.append('paged', nextPage);

            fetch(ajaxurl, {
                method: 'POST',
                body: data,
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Append new courses to the current tab's content
                    const tabContent = document.querySelector(`#category-${categoryId} .course-list`);
                    data.data.courses.forEach(course => {
                        const card = document.createElement('div');
                        card.classList.add('card');
                        card.innerHTML = `
                            <img src="${course.image}" alt="Course Image">
                            <div class="container">
                                <h4>Live Classroom / Classroom</h4>
                                <h2>${course.title}</h2>
                                
                                <div class="course_fee_details flex justify-between">
                                <div class="duration">
                                    <i class="fa fa-clock-o"></i> ${course.duration}<br>
                                    <i class="fa fa-users"></i> ${course.enrolled} Enrolled
                                </div>
                                <div class="course-fee">Start from <span style="color: green;">₹${course.price}</span></div>
                                </div>
                                <div class="course-action flex justify-between">
                                <div class="recommended">Recommended</div>
                                <button>Enroll Now</button>
                                </div>
                            </div>
                        `;
                        tabContent.appendChild(card);
                    });

                    // Update the current page data attribute
                    button.dataset.currentPage = nextPage;

                    // Disable button if no more pages
                    if (nextPage >= maxPages) {
                        button.disabled = true;
                        button.innerText = 'No more courses';
                    }
                }
            })
            .catch(error => console.error('Error loading more courses:', error));
        });
    });
});
