var btn = $("#bottom-top");

$(window).scroll(function () {
  if ($(window).scrollTop() > 300) {
    btn.addClass("show");
  } else {
    btn.removeClass("show");
  }
});

btn.on("click", function (e) {
  e.preventDefault();
  $("html, body").animate({ scrollTop: 0 }, "300");
});

$("#show-search-box").click(function () {
  $("#hidden-search-box").toggle();
});
$(function () {
  $(".toggle-more").on("click", function (e) {
    e.stopPropagation();
    var $megamenu = $(this).closest(".col-megamenu");
    var $hiddenItems = $megamenu.find("li.hidden-li");
    if ($(this).text() === "More") {
      $hiddenItems.removeClass("d-none").slideDown();
      $(this).text("Less");
    } else {
      $hiddenItems.addClass("d-none").slideUp();
      $(this).text("More");
    }
  });
});



