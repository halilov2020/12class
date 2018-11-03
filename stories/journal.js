
$(document).ready(function() {
  let d = new Date();
  let index = d.getDay();

  $.getJSON("./stories/sch.json", function(data) {
    // get schedule for today
    let today = data.data[index < 5 ? index + 1 : 0];

    // create elements to hold the next day's schedule
    let $subjs = $("<div>").addClass('subjects');
    let $ul = $("<ul>");

    // and for the hometask
    let $tasks = $("<div>").addClass('tasks');
    let $dz = $("<ul>");

    $.each(today, function(i, val) {
      if (i === 0) {
        // ignore the day of the week, which is the
        // first item in the loaded 'schedule' data.
        // instead, aplly headers to both lists
        $subjs.html($("<strong>")
          .html('Предметы'));
        $tasks.html($("<strong>")
          .html('Домашнее задание'));
      } else {
        $("<li>") // holds a subject
          .addClass(today[i][0]) // shortened name
          .html(today[i][1]) // full name
          .appendTo($ul);

        $("<li>") // holds a task
          .addClass('dz') // shortened name
          .appendTo($dz);
      }
    });

    $subjs.append($ul); // add subjects
    $tasks.append($dz); // add hometask

    $('.day-page')
      .append($subjs)
      .append($tasks);
      
    // get hometask from DB and shove it into proper li's
    setDzs();
  });
})

function setDzs() {
  let dzs = $('.dz');

  // load data from DB ...
  // ...

  // number rows for now
  $.each(dzs, function(i, val) {
    $(this).html(i + 1);
  });
}
