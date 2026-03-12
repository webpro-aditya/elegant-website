"use strict";
require("../../../../../../resources/js/admin.js");
require("../../../../../../resources/plugins/dropzone/dropzone.js");
window.IpixImageInput = require("../../../../../../resources/js/components/image-input.js");
require("../../../../../../resources/plugins/tinymce/tinymce.js");
require("../../../../../../resources/plugins/tagify/tagify.js");

var IpixAddContent = (function () {
  var formValidation = function () {
    $("#contentForm").submit(function (event) {
      var isValid = true;

      // Reset validation states
      $(".is-invalid").removeClass("is-invalid");
      $(".is-valid").removeClass("is-valid");
      $(".invalid-feedback").hide();

      // Validate title field
      var title = $("#title");
      if (!title.val().trim()) {
        isValid = false;
        title.addClass("is-invalid");
        if (title.next(".invalid-feedback").length === 0) {
          title.after('<div class="invalid-feedback">Title is required.</div>');
        }
        title.next(".invalid-feedback").show();
      } else {
        title.addClass("is-valid");
      }

      // Validate name fields for each language
      $("[id^=name_]").each(function () {
        var nameField = $(this);
        if (!nameField.val().trim()) {
          isValid = false;
          nameField.addClass("is-invalid");
          if (nameField.next(".invalid-feedback").length === 0) {
            nameField.after(
              '<div class="invalid-feedback">Name is required.</div>'
            );
          }
          nameField.next(".invalid-feedback").show();
        } else {
          nameField.addClass("is-valid");
        }
      });

      $("[id^=short_desc_]").each(function () {
        var shortDescField = $(this);
        if (shortDescField.val().length > 191) {
          isValid = false;
          shortDescField.addClass("is-invalid");
          if (shortDescField.next(".invalid-feedback").length === 0) {
            shortDescField.after(
              '<div class="invalid-feedback">Short description cannot exceed 191 characters.</div>'
            );
          }
          shortDescField.next(".invalid-feedback").show();
        } else {
          shortDescField.removeClass("is-invalid");
          shortDescField.addClass("is-valid");
          shortDescField.next(".invalid-feedback").hide();
        }
      });

      // Prevent form submission if not valid
      if (!isValid) {
        event.preventDefault();
      }
    });
  };

$(document).ready(function () {
    $('#category_id').change(function () {

        var categoryId = $(this).val();

        var filterOptions = {
            category_id: {
                value: categoryId
            }
        };
        $('#course_id').attr('data-select2-filter', JSON.stringify(filterOptions)).trigger('change');
    });
});

  var statusEvent = function (e) {
    const target = document.getElementById("content_status");
    $("#content_status_select").change(function (e) {
      switch (e.target.value) {
        case "active": {
          target.classList.remove(...["bg-success", "bg-warning", "bg-danger"]);
          target.classList.add("bg-success");
          break;
        }
        case "inactive": {
          target.classList.remove(...["bg-success", "bg-warning", "bg-danger"]);
          target.classList.add("bg-danger");
          break;
        }
        default:
          break;
      }
    });
  };

  var languageInput = function () {
    // Hide all language-specific input fields initially
    $(".language-input").hide();

    // Show the input fields for the first language by default
    $('.language-input[data-language="1"]').show();

    // Handle tab click event
    $(".nav-link").on("click", function () {
      var languageId = $(this).attr("href").split("-")[1];

      // Hide all language-specific input fields
      $(".language-input").hide();

      // Show the selected language-specific input fields
      $('.language-input[data-language="' + languageId + '"]').show();
    });

    // Trigger click on the first tab to set the correct initial state
    $(".nav-link.active").trigger("click");
    $("#title-div").show();
    $("#content-tab").show();
  };

  function checkActiveTab() {
    if ($("#seo-tab").hasClass("active")) {
      $("#title-div").hide();
      $("#content-tab").hide();
    } else {
      $("#title-div").show();
      $("#content-tab").show();
    }
  }

  $('a[data-bs-toggle="tab"]').on("shown.bs.tab", function (e) {
    checkActiveTab();
  });



  return {
    init: function () {
      formValidation();
      statusEvent();
      languageInput();
      checkActiveTab();
    },
  };
})();

IpixUtil.onDOMContentLoaded(function () {
  IpixAddContent.init();
  IpixImageInput.init();
});

// $('#contentForm').submit(function(event) {
//     // Prevent the default form submission behavior
//     event.preventDefault();

//     // Gather form data
//     var formData = $(this).serializeArray();

//     // Display form data in an alert
//     var formDataString = JSON.stringify(formData, null, 2); // Convert form data to a readable string
//     console.log("Form Data:\n" + formDataString);

//     // Optionally, you can proceed with form submission programmatically
//     // $(this).unbind('submit').submit();
// });
