$(document).ready(function() {

  //$("#auth").hide();
  //$("#reg").hide();

  $("#reg div.close").click(function() {
    $("#reg").hide();
  });
  $("#auth div.close").click(function() {
    $("#auth").hide();
  });
  $("div.btn-popup.login").click(function() {
    $("#auth").show();
  });
  $("div.btn-popup.register").click(function() {
    $("#reg").show();
  });
})

function a() {
  console.log('hello world')
}
