$(document).ready(function() {
  $.getJSON("./stories/sch.json", function(data) {
    let d = data.data;

    for (let i = 0; i < d.length; i++) {
      let box = $('<div>')
        .addClass('box')
        .append($('<div>')
          .addClass('day-title')
          .html($('<strong>')
            .html(d[i][0])));

<<<<<<< HEAD
      let obj = $("<div>").addClass("objects");

      for (let j = 1; j < d[i].length; j++) {
        obj.append($("<div>")
          .addClass(d[i][j][0]) // set class to short name
          .html(d[i][j][1])) // set the full name
      }
      obj.appendTo(box);
=======
      let subj = $("<div>").addClass("subjects");

      for (let j = 1; j < d[i].length; j++) {
        subj.append($("<div>")
          .addClass(d[i][j][0]) // set class to short name
          .html(d[i][j][1])) // set the full name
      }
      subj.appendTo(box);
>>>>>>> b2079786ff95abdd002c9bfc8b171f5232c8da64
      $(".schedule-page").append(box);

      $(".box").css("margin", "15px");
      $(".day-title").css({
        "text-align": "center",
        "margin-bottom": "10px"
      });
    }
  })
})
