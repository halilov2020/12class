var curr = true;
var next = false;
var prev = false;

function resolveWeek(forward) {
  if (forward) { // go forward
    if (curr) {
      curr = false;
      next = true;
    } else if (prev) {
      curr = true;
      prev = false;
    }
    return;
  } else { // go backward
    if (curr) {
      curr = false;
      prev = true;
    } else if (next) {
      curr = true;
      next = false;
    }
  }
}
function addButtons() {
  $('<button>')
    .addClass('next settings-btn')
    .click(function() {
      removeMore();
      let week = curr ? 'next' : '';
      setDzs(week);
      resolveWeek(true);
      if (curr) {
        $('.prev').removeAttr('disabled');
      } else {
        $(this).attr('disabled', 'disabled');
      }
    })
    .html('Предыдущая')
    .appendTo('.day-page');

  $('<button>')
    .addClass('prev settings-btn')
    .click(function() {
      removeMore();
      let week = curr ? 'prev' : '';
      setDzs(week);
      resolveWeek(false);
      if (curr) {
        $('.next').removeAttr('disabled');
      } else {
        $(this).attr('disabled', 'disabled');
      }
    })
    .html('Следующая')
    .appendTo('.day-page');
}

if (window.location.pathname === "/journal-edit.php") {
  $(document).ready(function() {
    addButtons();
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

      let date = new Date(Date.now() - (index - r - 1) * 24 * 60 * 60 * 1000);

      var $dayDate = $("<div>").addClass('day-date')
        .html(
          daysWeek[r] +
          '\n' + date.getDate() +
          '.' + (date.getMonth() + 1));

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

function setDzs(specificString) {
  if (!specificString) {
    specificString = '';
  }
  var dzs = $('.dz'); // shortened name
  // access table specific table with tasks
  console.log(specificString);
  $.get('./dz.php?index=' + specificString, function(data) {
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
