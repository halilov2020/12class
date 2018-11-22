if (window.location.pathname === "/journal-edit.php") {
  $(document).ready(function() {
    createTables();


    $('<a>')
      .html('Сохранить')
      .addClass('settings-btn')
      .attr('name', 'confirmDz')
      .appendTo('.day-page')
      .on("click", function() {
        let a = [];
        $('li.dz').each(function() {
          a.push($(this).html());
        });

        $.post('/data-management/journal-save.php', {
          dzs: a
        }, function(data) {
          console.log(data);
        })
      });

    $('<a>')
      .html('Назад')
      .addClass('settings-btn back-btn')
      .appendTo('.day-page')
      .on('click', function() {
        window.open(window.location.origin + '/journal.php', "_self")
      });

  });
}

function createTables() {
  let d = new Date();
  var index = d.getDay();
  var firstDayWeek = (d.getDate() - d.getDay()) + 1;
  var daysWeek = [
    'Пн', 'Вт', 'Ср',
    'Чт', 'Пт', 'Сб',
    'Вc',
  ];

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
          daysWeek[r] +
          '\n' + (firstDayWeek + r) +
          '.' + (d.getMonth() + 1));

      $.each(day, function(i, val) {
        if (i === 0) {
          // ignore the day of the week, which is the
          // first item in the loaded 'schedule' data.
          // instead, aplly headers to both lists
          $subjs.html($("<div>")
            .html('Предметы'));
          $tasks.html($("<div>")
            .html('Задание'));
        } else {
          $("<li>") // holds a subject
            .addClass(day[i][0]) // shortened name
            .html(day[i][1]) // full name
            .appendTo($ul);
          if (window.location.pathname === "/journal-edit.php") {
            $("<li>")
              .addClass("dz")
              .attr('contenteditable', 'true') //надо это убрать для journal.php
              .appendTo($dz);
          } else {
            $("<li>")
              .addClass("dz") //надо это убрать для journal.php
              .appendTo($dz);
          }
        }
      });
      $subjs.append($ul); // add subjects
      $tasks.append($dz); // add hometask

      let div = $("<div>").addClass('day-schedule');
      let divDays = $("<div>").addClass('day-div');
      $dayDate.appendTo(divDays);

      div
        .append(divDays)
        .append($subjs)
        .append($tasks)
        .appendTo('.day-page');

      if ((r + 1) === index) {
        div.css('backgroundColor', 'yellow');
      }
    }
    // get hometask from DB and shove it into proper li's
    setDzs();
    setMouseEvents();

  })
}

function setDzs() {
  var dzs = $('.dz'); // shortened name
  $.get('./dz.php', function(data) {
    let $obj = JSON.parse(data);
    let $dzt = [];
    for (let j = 1; j <= 49; j++) {
      $dzt.push($obj[j]);
    }

    $.each(dzs, function(i, val) {
      $(this).attr('id', i + 1);
      $(this).html($dzt[i]);
    })
  });
}
