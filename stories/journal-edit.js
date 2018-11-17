
$(document).ready(function() {
  let d = new Date();
  var index = d.getDay();
  var firstDayWeek = (d.getDate() - d.getDay()) + 1;
  var daysWeek = [
    'Пн', 'Вт', 'Ср',
    'Чт', 'Пт', 'Сб',
    'Вc',
  ];

  $('<button>', {
    type: 'submit'
  })
    .html('Сохранить')
    .addClass('settings-btn')
    .attr('name', 'confirmDz')
    .appendTo('.day-page')
    .on("click", function() {
      let a = [];
      $('li.dz').each(function() {
        a.push($(this).html());
      });

      var str = encodeURIComponent(a)
      window.open(window.location.href + "?vals=" + str, "_self")
    });



  $.getJSON("./stories/sch.json", function(data) {
    // get schedule for day
    for (var r = 0; r < 7; r++) {
      var day = data.data[r];
      // create elements to hold the next day's schedule

      var $subjs = $("<div>").addClass('subjects');
      var $ul = $("<ul>");

      // and for the hometask
      var $tasks = $("<div>").addClass('tasks');
      var $dz = $("<ul>");


      var $dayDate = $("<div>").addClass('day-date')
        .html(
          daysWeek[r]
          + '\n' + (firstDayWeek + r) +
          '.' + (d.getMonth() + 1));

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

          $("<li>")
            .addClass("dz")
            .attr('contenteditable', 'true')
            .appendTo($dz);

        }
      });
      $subjs.append($ul); // add subjects
      $tasks.append($dz); // add hometask

      var div = $("<div>").addClass('day-schedule');

      div
        .append($dayDate)
        .append($subjs)
        .append($tasks)
        .appendTo('.day-page');
        // get hometask from DB and shove it into proper li's

      if ((r + 1) === index) {
        div.css('backgroundColor', 'yellow');
      }
    }
    setDzs();


  })
});

function setDzs() {
  var dzs = $('.dz'); // shortened name

  $.get('./dz.php', function(data) {
    let $obj = JSON.parse(data);
    let $dz = [];
    for (let j = 1; j <= 49; j++) {
      $dz.push($obj[j]);
    }

    $.each(dzs, function(i, val) {
      $(this).attr('id', i + 1);
      $(this).html($dz[i]);
    })
  });
}
