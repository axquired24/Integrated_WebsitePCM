$(document).ready(function () {
  $('[data-toggle="offcanvas"]').click(function () {
    $('.row-offcanvas').toggleClass('active');
    $('#nav-fa').toggleClass('fa-close fa-navicon');
  });
});