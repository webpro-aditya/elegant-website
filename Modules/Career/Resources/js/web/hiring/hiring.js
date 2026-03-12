"use strict";
require('../../../../../../resources/js/web');


var IpixListCareers = (function() {
    var handleTab = function(tabId) {
        if (tabId === 'home-tab') {
            tabId = 'All';
        }

        $.ajax({
            url: $("#category-form").attr("action"),
            type: 'POST',
            data: {
                tabId: tabId,
                _token: document.querySelector('input[name="_token"]').value
            },
            success: function(data) {
                $("#career-list-div").html(data.view);
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', error);
            }
        });
    };

    var applyModal = function() {
        // Delegate event listener to a parent element
        $(document).on('click', '.apply-now', function() {
            var url = $(this).data('url');

            $.ajax({
                type: 'POST',
                url: url,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },

                success: function(response) {
                    if (response.html) {
                        console.log(response.html);
                        $('#careerEnquiryModal .modal-body').html(response.html);
                        $('#careerEnquiryModal').modal('show');

                    } else {
                        console.error("No HTML content in response.");
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });
    };

    var initTabHandler = function() {
        var tabs = document.querySelectorAll('#category-form .nav-link');

        tabs.forEach(function(tab) {
            tab.addEventListener('click', function(event) {
                event.preventDefault();

                var tabId = tab.getAttribute('id').replace('tab-', '');
                handleTab(tabId);
            });
        });
    };

    var loadInitialContent = function() {
        handleTab('home-tab');
    };

    return {
        init: function() {
            initTabHandler();
            loadInitialContent();
            applyModal();
            validateForm();
        }
    };
})();

document.addEventListener('DOMContentLoaded', function() {
    IpixListCareers.init();
});