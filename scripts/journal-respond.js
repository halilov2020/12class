function setMouseEvents() {
  $('.subjects li').mouseenter(function() {
    // get the sequencial index of this li
    let index = getIndex(this);
    // assert no error
    if (index !== null) {
      $('.task-more').remove();

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
    }
  })
  // remove one task expansion if left subjects div
  // at the left, top, or bottom side
  $('.subjects').mouseleave(function(event) {
    let tasks = $(this).parent().find('.tasks');
    let borders = tasks.offset();
    let toTop = $(window).scrollTop();

    // if moved from objects not over to tasks
    if (event.clientX < borders.left - 2 ||
      event.clientY < borders.top - toTop ||
      event.clientY > borders.top - toTop + tasks.outerHeight()) {
      $('.task-more').remove();
      tasks.find('ul').show();
    }
  })
  // remove one task expansion if left tasks div
  // at the right, top, or bottom side
  $('.tasks').mouseleave(function(event) {
    let subjs = $(this).parent().find('.subjects');
    let borders = subjs.offset();
    let toTop = $(window).scrollTop();

    // if moved from objects not over to subjects
    if (event.clientX > borders.left + subjs.outerWidth() ||
      event.clientY < borders.top - toTop ||
      event.clientY > borders.top - toTop + subjs.outerHeight()) {
      $('.task-more').remove();
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
