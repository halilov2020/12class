
$(document).ready(function() {
  let d = new Date();
  var index = d.getDay();
  var firstDayWeek = (d.getDate() - d.getDay())+1;
  var daysWeek = [
    'Пн','Вт','Ср',
    'Чт','Пт','Сб',
    'Вc',
  ];

  $.getJSON("./stories/sch.json", function(data) {
    // get schedule for day
    for (var r = 0; r < 7; r++) {
      let day = data.data[r];
      // create elements to hold the next day's schedule

      let $subjs = $("<div>").addClass('subjects');
      let $ul = $("<ul>");

      // and for the hometask
      let $tasks = $("<div>").addClass('tasks');
      let $dz = $("<ul>");



      let $dayDate = $("<div>").addClass('day-date')
        .html(
          daysWeek[r]
          + '\n' + (firstDayWeek + r)  +
          '.' + ( d.getMonth() + 1 ));

      $.each(day, function(i, val) {
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
            .addClass(day[i][0]) // shortened name
            .html(day[i][1]) // full name
            .appendTo($ul);

          $("<li>") // holds a task
            .addClass('dz') // shortened name
            .appendTo($dz);
        }
      });

      $subjs.append($ul); // add subjects
      $tasks.append($dz); // add hometask

      let div =  $("<div>").addClass('day-schedule');

      div
        .append($dayDate)
        .append($subjs)
        .append($tasks)
        .appendTo('.day-page');
      // get hometask from DB and shove it into proper li's
      setDzs();

      if (( r + 1 ) === index ) {
        div.css('backgroundColor','yellow');
      }
    }
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
