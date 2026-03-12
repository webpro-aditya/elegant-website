"use strict";

const { isset } = require("./util");

var IpixDropzoneInput = function () { };

IpixDropzoneInput.initDropzone = () => {
    if ($('[data-kt-dropzone-input="true"]').length) {
        var ipixDropzone = new Dropzone('[data-kt-dropzone-input="true"]', {
            url: $("#image-dropzone").data("action-url"),
            type: "post",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            paramName: "file",
            maxFilesize: 10, // MB
            addRemoveLinks: true,
            acceptedFiles: $("#image-dropzone").data("accepted-file"),
            dictRemoveFile: "<i class='fas fa-times'></i>",
            accept: function (file, done) {
                if (file.name == "wow.jpg") {
                    done("Naha, you don't.");
                } else {
                    var expectedWidth = parseInt($('#image-dropzone').data('course-image-width'));
                    var expectedHeight = parseInt($('#image-dropzone').data('course-image-height'));
                    if (!isNaN(expectedWidth) && !isNaN(expectedHeight)) {
                        console.log(expectedHeight);
                        var img = new Image();
                        img.onload = function () {

                            if (img.width === expectedWidth && img.height === expectedHeight) {
                                done();
                            } else {
                                done("Image width must be " + expectedWidth + "px and Image height must be " + expectedHeight);
                            }
                        };
                        img.src = URL.createObjectURL(file);
                    } else {
                        done();
                    }

                    // done();
                }
            },
        });
        ipixDropzone.on("removedfile", function (file) {
            if (file.serverId) {
                $.get(
                    $("#image-dropzone").data("delete-url") +
                    "?file=" +
                    file.response.fileName,
                    "id=" + file.serverId
                );
            }
        });
        ipixDropzone.on("success", function (file, response) {
            file.response = response;
            file.serverId = response.id;
            $(file.previewElement).attr("data-server-id", file.serverId);
            $(file.previewElement).find(".dz-details").html(response.form);
            if (response.type == "video") {
                $(file.previewElement).find(".dz-image").addClass("video");
                $(file.previewElement)
                    .find(".dz-image.video")
                    .append("<i class='fas fa-video'></i>");
            }
        });
        if ($('#image-dropzone[data-fetchable="true"]').length) {
            $.ajax({
                url: $("#image-dropzone").data("fetch-url"),
                type: "GET",
                success: function (data) {
                    $.each(data, function (key, value) {
                        var mockFile = {
                            name: value.url,
                            fileName: value.name,
                            size: value.size,
                            serverId: value.id,
                            response: { fileName: value.file },
                        };
                        if (value.type == "video") {
                            // Preview video only from type mp4
                            ipixDropzone.options.addedfile.call(
                                ipixDropzone,
                                mockFile
                            );
                            var src = value.url;
                            var video = document.createElement("video");
                            video.src = src;
                            video.addEventListener("loadeddata", function () {
                                var canvas = document.createElement("canvas");
                                canvas.width = video.videoWidth;
                                canvas.height = video.videoHeight;
                                canvas
                                    .getContext("2d")
                                    .drawImage(
                                        video,
                                        0,
                                        0,
                                        canvas.width,
                                        canvas.height
                                    );
                                var dataURI = canvas.toDataURL("image/png");
                                ipixDropzone.options.emit(
                                    "thumbnail",
                                    mockFile,
                                    dataURI
                                );
                            });
                            ipixDropzone.emit("complete", mockFile);
                            $(mockFile.previewElement)
                                .find(".dz-image")
                                .addClass("video");
                            $(mockFile.previewElement)
                                .find(".dz-image.video")
                                .append("<i class='fas fa-video'></i>");
                            $(mockFile.previewElement).attr(
                                "data-server-id",
                                value.id
                            );
                            // $(mockFile.previewElement).attr('data-dz-size', value.size)
                            // $(mockFile.previewElement).attr('data-dz-name', value.name)
                        } else {
                            ipixDropzone.emit("addedfile", mockFile);
                            ipixDropzone.options.thumbnail.call(
                                ipixDropzone,
                                mockFile,
                                value.url
                            );
                            ipixDropzone.files.push(mockFile);
                            ipixDropzone.emit("complete", mockFile);
                            $(mockFile.previewElement).attr(
                                "data-server-id",
                                value.id
                            );
                            $(mockFile.previewElement).attr(
                                "data-link",
                                value.link
                            );
                            $(mockFile.previewElement).attr(
                                "data-title",
                                value.title
                            );
                            $(mockFile.previewElement).attr(
                                "data-name",
                                value.name
                            );

                            $(mockFile.previewElement)
                                .find(".dz-details")
                                .html(value.form);
                        }
                    });
                },
            });
        }

        $(document).on(
            "click",
            '#image-dropzone[data-content="true"] .dz-preview',
            function () {
                var image = $(this);
                var id = image.data("server-id");
                if (id != undefined) {
                    var link =
                        image.data("link") != null ? image.data("link") : "";
                    var title =
                        image.data("title") != null ? image.data("title") : "";
                    var name =
                        image.data("name") != null ? image.data("name") : "";

                    var selectUrl = $("#image-dropzone").data("select-url");
                    Swal.fire({
                        html:
                            '<span class="text-start float-start w-100 my-5">Link</span><input type="url" id="swal-url" class="swal2-input m-0 w-100" value="' +
                            link +
                            '" >' +
                            '<span class="text-start float-start w-100 my-5">Title</span><input type="text" id="swal-title" name="swal-title" class="swal2-input m-0 w-100" value="' +
                            title +
                            '" >' +
                            '<span class="text-start float-start w-100 my-5">Description</span>' +
                            '<textarea id="swal-name" name="swal-name" class="swal2-textarea m-0 w-100">' +
                            name +
                            "</textarea>" +
                            "</select>",
                        showCancelButton: false,
                        closeOnConfirm: true,
                        didOpen: function (ele) {
                            IpixApp.createSelect2();
                        },
                    }).then(function (data, inputValue) {
                        var link = $("#swal-url").val();
                        var title = $("#swal-title").val();
                        var name = $("#swal-name").val();
                        $.ajax({
                            url: $("#image-dropzone").data("link-update-url"),
                            type: "post",
                            data: {
                                _token: _token,
                                id: id,
                                link: link,
                                title: title,
                                name: name,
                            },
                            dataType: "json",
                            success: function (data) {
                                if (data.status == true) {
                                    image.attr("data-link", link);
                                    image.attr("data-title", title);
                                    image.attr("data-name", name);

                                    Swal.fire({
                                        icon: "success",
                                        text: "Link Updated",
                                    });
                                }
                            },
                        });
                    });
                }
            }
        );
    }
};

IpixDropzoneInput.init = function () {
    IpixDropzoneInput.initDropzone();
};

IpixUtil.onDOMContentLoaded(function () {
    IpixDropzoneInput.init();
});

// Webpack support
if (typeof module !== "undefined" && typeof module.exports !== "undefined") {
    module.exports = IpixDropzoneInput;
}
