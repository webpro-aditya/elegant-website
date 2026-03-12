"use strict";
require("../../../../../../resources/js/admin");
window.IpixImageInput = require("../../../../../../resources/js/components/image-input.js");
require("../../../../../../resources/plugins/tinymce/tinymce.js");
require("../../../../../../resources/plugins/dropzone/dropzone.js");

var IpixCourseEditCourse = (function () {
  flatpickr("#start_date", {
    enableTime: false,
    dateFormat: "Y-m-d",
    minDate: "today",
    defaultDate: null,
  });

  var validateForm = function (e) {
    $("#editCourseForm").submit(function (event) {
      var isValid = true;
      var firstErrorTab = null;

      // Clear previous error indicators
      $('.is-invalid').removeClass('is-invalid');
      $('.invalid-feedback').hide();

      // Validate title
      $('input[id^="title_"]').each(function () {
        var title = $(this);
        if (!title.val()) {
          isValid = false;
          title.addClass("is-invalid");
          if (title.next(".invalid-feedback").length === 0) {
            title.after(
              '<div class="invalid-feedback">Title is required.</div>'
            );
          }
          title.next(".invalid-feedback").show();

          // Store tab info for first error
          if (!firstErrorTab) {
            firstErrorTab = $(this).closest('.tab-pane').attr('id');
          }
        } else {
          title.removeClass("is-invalid");
          title.addClass("is-valid");
          title.next(".invalid-feedback").hide();
        }
      });

      // Validate category_id
      var categoryId = $("#category_id");
      if (!categoryId.val()) {
        isValid = false;
        categoryId.addClass("is-invalid");
        if (categoryId.next(".invalid-feedback").length === 0) {
          categoryId.after(
            '<div class="invalid-feedback">Category is required.</div>'
          );
        }
        categoryId.next(".invalid-feedback").show();

        // Store tab info for first error
        if (!firstErrorTab) {
          firstErrorTab = "title-div"; // This is in the main content area
        }
      } else {
        categoryId.removeClass("is-invalid");
        categoryId.addClass("is-valid");
        categoryId.next(".invalid-feedback").hide();
      }

      // Validate duration
      var duration = $("#duration");
      if (!duration.val()) {
        isValid = false;
        duration.addClass("is-invalid");
        if (duration.next(".invalid-feedback").length === 0) {
          duration.after(
            '<div class="invalid-feedback">Duration is required.</div>'
          );
        }
        duration.next(".invalid-feedback").show();

        // Store tab info for first error
        if (!firstErrorTab) {
          firstErrorTab = "title-div"; // This is in the main content area
        }
      } else {
        duration.removeClass("is-invalid");
        duration.addClass("is-valid");
        duration.next(".invalid-feedback").hide();
      }

      var feeField = $("input[name='fee']");
      var feeValue = feeField.val();
      var feePattern = /^[A-Za-z0-9 _. -]+$/;
      if (!feeValue || !feePattern.test(feeValue)) {
        isValid = false;
        feeField.addClass("is-invalid");
        if (feeField.next(".invalid-feedback").length === 0) {
          feeField.after(
            '<div class="invalid-feedback">Please enter a valid fee (e.g., 150.25).</div>'
          );
        }
        feeField.next(".invalid-feedback").show();

        // Store tab info for first error
        if (!firstErrorTab) {
          firstErrorTab = "title-div"; // This is in the main content area
        }
      } else {
        feeField.removeClass("is-invalid");
        feeField.addClass("is-valid");
        feeField.next(".invalid-feedback").hide();
      }

      // Validate URL
      var urlField = $("#url");
      var urlValue = urlField.val();
      var urlPattern = /^(https?:\/\/)?([\da-z.-]+)\.([a-z.]{2,6})([/\w .-]*)*(\?.*)?$/;
      if (!urlValue || !urlPattern.test(urlValue)) {
        isValid = false;
        urlField.addClass("is-invalid");
        if (urlField.next(".invalid-feedback").length === 0) {
          urlField.after(
            '<div class="invalid-feedback">Please enter a valid URL.</div>'
          );
        }
        urlField.next(".invalid-feedback").show();

        // Store tab info for first error
        if (!firstErrorTab) {
          firstErrorTab = "title-div"; // This is in the main content area
        }
      } else {
        urlField.removeClass("is-invalid");
        urlField.addClass("is-valid");
        urlField.next(".invalid-feedback").hide();
      }

      if (!isValid) {
        event.preventDefault();

        // Switch to the tab with the first error
        if (firstErrorTab) {
          if (firstErrorTab === "title-div") {
            // This is the main content area, activate the first language tab
            $('#language-1-tab').tab('show');
          } else {
            // This is a language tab, find and activate it
            var tabId = firstErrorTab.replace('language-', '');
            $('#language-' + tabId + '-tab').tab('show');
          }

          // Scroll to the first error
          $('html, body').animate({
            scrollTop: $('.is-invalid').first().offset().top - 100
          }, 500);
        }
      }
    });
  };

  return {
    init: function () {
      validateForm();
    },
  };
})();

function checkActiveTab() {
  if ($("#seo-tab").hasClass("active") || $("#faq-tab").hasClass("active")) {
    $("#title-div").hide();
  } else {
    $("#title-div").show();
  }
}

$('a[data-bs-toggle="tab"]').on("shown.bs.tab", function (e) {
  checkActiveTab();
});

var checkFormat = function () {
  $("#pricing_format").change(function () {
    var pricingFormat = $(this).val();
    if (pricingFormat === "free") {
      $("#feeInputBox").hide();
    } else {
      $("#feeInputBox").show();
    }
  });

  $("#certificate").change(function () {
    var flag = $(this).val();
    if (flag == 0) {
      $("#certificate-text").hide();
    } else {
      $("#certificate-text").show();
    }
  });

  $("#discount").change(function () {
    var discount = $(this).val();
    if (discount == "no") {
      $("#discountInputBox").hide();
    } else {
      $("#discountInputBox").show();
    }
  });
};

IpixUtil.onDOMContentLoaded(function () {
  IpixImageInput.init();
  IpixCourseEditCourse.init();
  checkFormat();
});