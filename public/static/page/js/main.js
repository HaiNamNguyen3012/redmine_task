$(document).ready(function () {
    $(".icon-bar-menu").click(function () {
        $(this).toggleClass('active');
        $(this).siblings("nav#wrap-menu-header").toggleClass("active");
    });
});
