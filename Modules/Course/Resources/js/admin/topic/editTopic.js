"use strict";

// Class definition
var IpixTopicsEditTopic = (function () {
    // Shared variables
    const element = document.getElementById("editTopicModal");
    const form = element.querySelector("#editTopicForm");
    const modal = new bootstrap.Modal(element);

    // Init add schedule modal
    var initEditTopic = () => {
        // Close button handler
        $(".modal").on(
            "click",
            '[data-kt-users-modal-action="close"]',
            function () {
                $(this).closest(".modal").modal("hide");
            }
        );

        // Cancel button handler
        const cancelButton = element.querySelector(
            '[data-kt-users-modal-action="cancel"]'
        );
        cancelButton.addEventListener("click", (e) => {
            e.preventDefault();
            console.log("Cancel button clicked");
            Swal.fire({
                text: "Are you sure you would like to cancel?",
                icon: "warning",
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: "Yes, cancel it!",
                cancelButtonText: "No, return",
                customClass: {
                    confirmButton: "btn btn-primary",
                    cancelButton: "btn btn-active-light",
                },
            }).then(function (result) {
                console.log("44");

                if (result.value) {
                    form.reset(); // Reset form
                    // modal.hide(); // Hide modal
                    $("#editTopicModal").modal("hide");
                } else if (result.dismiss === "cancel") {
                    Swal.fire({
                        text: "Your form has not been cancelled!.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-primary",
                        },
                    });
                }
            });
        });

        // Submit button handler
        const submitButton = element.querySelector(
            '[data-kt-users-modal-action="submit"]'
        );
        submitButton.addEventListener("click", function (e) {
            // Prevent default button action
            e.preventDefault();

            // Show loading indication
            submitButton.setAttribute("data-kt-indicator", "on");

            // Disable button to avoid multiple click
            submitButton.disabled = true;

            // Simulate form submission. For more info check the plugin's official documentation: https://sweetalert2.github.io/
            setTimeout(function () {
                // Remove loading indication
                submitButton.removeAttribute("data-kt-indicator");

                // Enable button
                submitButton.disabled = false;

                // Show popup confirmation
                Swal.fire({
                    text: "Form has been successfully submitted!",
                    icon: "success",
                    buttonsStyling: false,
                    confirmButtonText: "Ok, got it!",
                    customClass: {
                        confirmButton: "btn btn-primary",
                    },
                }).then(function (result) {
                    console.log("result");

                    if (result.isConfirmed) {
                        // modal.hide();
                    $("#editTopicModal").modal("hide");

                    }
                });

                form.submit(); // Submit form
            }, 2000);
        });
    };

    return {
        // Public functions
        init: function () {
            initEditTopic();
        },
    };
})();

// On document ready
IpixUtil.onDOMContentLoaded(function () {
    IpixTopicsEditTopic.init();
});
