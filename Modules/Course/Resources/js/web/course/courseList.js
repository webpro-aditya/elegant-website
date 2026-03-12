"use strict";
require('../../../../../../resources/js/web');

var IpixCourseList = function () {

    var loadMoreBtnClick = function() {
        $("#loadmore").on("click", function() {
            setupEventListeners(true);
        });
    }

    $('.grid-cn').on('click', function () {
        $('.course-list-container').removeClass('list').addClass('grid');
    });

    $('.list-cn').on('click', function () {
        $('.course-list-container').removeClass('grid').addClass('list');
    });

    function collectSelectedCategories() {
        let selectedCategories = [];
    
        if ($('#offcanvasExample').hasClass('show')) {
            $(".offcanvas-body .sidebar-category input[type='checkbox']:checked").each(function () {
                selectedCategories.push($(this).val());
            });
        } else {
            $(".sidebar-section.d-lg-block input[type='checkbox']:checked").each(function () {
                selectedCategories.push($(this).val());
            });
        }
    
        return selectedCategories;
    }
    

    $(".sidebar-category input[type='checkbox']").on('change', function () {
        setupEventListeners();
    });

    $('.search-input-desktop').on('keyup', function () {
        setupEventListeners();
    });

    $('.search-input-mobile').on('keyup', function () {
        setupEventListeners();
    });


  var setupEventListeners = function(isMore) {
    if (!isMore) {
        $('#page').val(1); // Reset to the first page for new filters
    }

    let selectedData = collectSelectedCategories();
    let url = $('#course-list-div').data('url');
    let desktopSearch = $('.search-input-desktop').val();
    let mobileSearch = $('.search-input-mobile').val();
    let page = parseInt($('#page').val());
    let limit = parseInt($('#limit').val());
    
    let search = mobileSearch?.trim() || desktopSearch?.trim() || '';
    
    $.ajax({
        url: url,
        type: 'POST',
        data: {
            categories: selectedData,
            _token: $('meta[name="csrf-token"]').attr('content'),
            search: search,
            page: page,
            limit: limit
        },
        success: function (response) {
            $(".no-course").hide();
    
            if (isMore) {
                $("#course-list-div").append(response.view);
            } else {
                $("#course-list-div").html(response.view);
            }
    
            if (response.more) {
                $("#loadmore").show();
                // Increment the page value for subsequent requests
                $('#page').val(page + 1);
            } else {
                $("#loadmore").hide();
            }
    
            var listAvailable = response.listAvailable;
            var totalCourse = response.totalCourse;
    
            $(".out-of").text(listAvailable);
            $(".total-course").text(totalCourse);
        },
        error: function (xhr, status, error) {
            $(".no-course").show();
            console.error("Error:", error);
        }
    });
};

    
    return {
        init: function () {
            setupEventListeners(false); // Attach event listeners on page load
            loadMoreBtnClick();
        }
    }
}();

IpixUtil.onDOMContentLoaded(function () {
    IpixCourseList.init();
});

