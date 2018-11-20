var _index = 0;
var batchSize = 2;
var all = false;

$(document).ready(function() {
  $('.more-users').click(function() {
    addBatch();
  });
})

function loadBatch() {
  return new Promise(function(resolve, reject) {
    if (!all) {
      $.get('./data-management/getUsers.php?index='
      + _index + '&batch=' + batchSize,
        function(data) {
          json = JSON.parse(data);
          _index += batchSize;
          if (json.length < batchSize) {
            all = true;
            $('.more-users').remove();
          }
          console.log(json);
          resolve(json);
        });
    }
  })
}

function addBatch() {
  loadBatch().then(function(users) {
    for (let i = 0; i < users.length; i++) {
      $('<li>').html(users[i].login)
        .append(
          $('<img>').attr('src', users[i].avatar)
      ).appendTo('ul.user-list');
    }
  });

}
