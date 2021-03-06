const edit = window.location.pathname === '/journal-edit.php';

function setMouseEvents() {
  $('.subjects li').mouseenter(function() {
    // get the sequencial index of this li
    let index = getIndex(this);
    // assert no error
    if (index !== null) {
      removeMore();

      let tasks = $(this)
        .parent() // tab three steps above
        .parent()
        .parent()
        .find('.tasks ul')
        .hide();

      $('<div>')
        .html(
          tasks
            .find('li')
            .get(index)
            .innerHTML
      )
        .addClass('task-more')
        .appendTo(tasks.parent())
        .css({
          height: tasks.height() - 20, // 20 -> padding
          padding: '10px',
          overflowY: 'auto',
          border: '2px solid black',
          backgroundColor: 'floralwhite'
        })
        .attr({
          contenteditable: edit,
        })
        .data('index', index)
    }
  })
  // remove task expansion if cursor left subjects div
  // at the left, top, or bottom side
  $('.subjects').mouseleave(function(event) {
    let tasks = $(this).parent().find('.tasks');
    let borders = tasks.offset();
    let toTop = $(window).scrollTop();

    // if moved from objects not over to tasks
    if (event.clientX < borders.left ||
      event.clientY < borders.top - toTop ||
      event.clientY > borders.top - toTop + tasks.outerHeight()) {
      removeMore();
      tasks.find('ul').show();
    }
  })
  // remove task expansion if cursor left tasks div
  // at the right, top, or bottom side
  $('.tasks').mouseleave(function(event) {
    let subjs = $(this).parent().find('.subjects');
    let borders = subjs.offset();
    let toTop = $(window).scrollTop();

    // if moved from objects not over to subjects
    if (event.clientX > borders.left + subjs.outerWidth() ||
      event.clientY < borders.top - toTop ||
      event.clientY > borders.top - toTop + subjs.outerHeight()) {
      removeMore();
      $(this).find('ul').show();
    }
  })
}

// this function would be invoked on '.subjects li'
// to get its index (among other such li's)
function getIndex(el) {
  let index = null;
  if (el) {
    $(el)
      .parent()
      .find('*')
      .each(function(i) {
        if (el == this) {
          index = i;
          return;
        }
      });
    return index;
  }
}
// remove task expansion while saving text
// if in journal-edit.php
function removeMore() {
  let more = $('.task-more');
  if (edit) { // if in journal-edit.php
    let text = more.html();
    let i = more.data('index');
    more
      .parent()
      .find('ul')
      .find('li')
      .get(i)
      .innerHTML = text;
  }
  more.remove();
}
