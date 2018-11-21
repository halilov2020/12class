var _index = 0;
var batchSize = 2;
var all = false;
var pending = false;

$(document).ready(function() {
  $('.more-users').click(function() {
    if (!pending) {
      addBatch();
    }
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
  pending = true;
  loadBatch().then(function(users) {
    for (let i = 0; i < users.length; i++) {
      $('<li>').addClass('user')
        .append($('<div>').addClass('cont')
          .css('backgroundColor', randomColor())
          .append(
            $('<img>').attr('src', users[i].avatar)
        ).append(
          $('<div>').append($('<span>').html(users[i].login)
          ))).appendTo('ul.user-list');
    }
    pending = false;
  });
}


function randomColor() {
  let result = 'rgb(';
  for (let i = 0; i < 3; i++) {
    result += ~~(Math.random() * 255);
    if (i < 2) {
      result += ','
    }
  }
  result += ')';
  console.log(result);
  return result;
}
