var _index = 0;
const batchSize = 4;
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
          resolve(json);
        });
    }
  })
}

function addBatch() {
  pending = true;
  loadBatch().then(function(users) {
    for (let i = 0; i < users.length; i++) {
      $('<li>')
        .addClass('user')
        .append(
          $('<div>')
            .addClass('cont')
            .css('backgroundColor', randomColor())
            .append(
              $('<img>')
                .attr('src', users[i].avatar)
          ).append(
            $('<div>')
              .append(
                $('<span>')
                  .html(users[i].login)
            )))
        .appendTo('ul.user-list')
    }
    let toAnimate = $('.cont')
      .not('.done')
      .css({
        position: 'relative',
        top: 200,
        opacity: 0,
      })

    animate(toAnimate);

    pending = false;
  });
}

function animate(els) {
  if (els.length === 0) {
    return;
  }
  $(els.get(0)).animate({
    top: 0,
    opacity: 1
  }, {
    transition: 'top 200ms cubic-bezier(0.39,0.7,0.38,0.93), opacity 200ms linear',
    complete: function() {
      $(this).addClass('done');
      els.splice(0, 1);
      animate(els);
    }
  })
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
  return result;
}
