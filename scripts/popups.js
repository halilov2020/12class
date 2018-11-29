$(document).ready(function() {

  $("#auth, #reg").click(function(event) {
    event.stopPropagation();
  }).hide();
  $(".h-auth, .h-reg").click(function(event) {
    event.stopPropagation();
  });

  $("#reg .close").click(function() {
    $("#reg").hide();
  });
  $("#auth .close").click(function() {
    $("#auth").hide();
  });
  $(".btn-popup.login").click(function(event) {
    $("#auth")
      .fadeIn()
      .click(function() {
        // remove click event
        $(this)
          .fadeOut("fast")
          .off("click");
      }).find(".h-auth")
      .hide()
      .slideDown();
    event.stopPropagation();
  });
  $(".btn-popup.register").click(function(event) {
    $("#reg").fadeIn()
      .click(function() {
        // remove click event
        $(this).fadeOut("fast")
          .off("click");
      }).find(".h-reg")
      .hide()
      .slideDown();
    event.stopPropagation();
  });
  $('.hamburger-ico').click(function() {
    $('#m-menu').show();
  });
  $('.cross-mobile').click(function() {
    $('#m-menu').hide();
  });
});
