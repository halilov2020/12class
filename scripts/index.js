$(document).ready(function() {

  $("#auth, #reg").click(function(event) {
    event.stopPropagation();
  }).hide()
    .toggleClass('unhid');

  $(".h-auth, .h-reg").click(function(event) {
    event.stopPropagation();
  })

  $("#reg div.close").click(function() {
    $("#reg").hide();
  });
  $("#auth div.close").click(function() {
    $("#auth").hide();
  });
  $("div.btn-popup.login").click(function(event) {
    $("#auth").fadeIn()
      .click(function() {
        // remove click event
        $(this).fadeOut("fast")
          .off("click");
      }).find(".h-auth")
      .hide()
      .slideDown();
    event.stopPropagation();
  });
  $("div.btn-popup.register").click(function(event) {
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
})

function a() {
  console.log('hello world')
}
