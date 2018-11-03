// $(document).ready(function() {
//   let boxes = $('.box');
//   let sch = [];
//
//   $.each(boxes, function(i, val) {
//     let a = [];
//
//     let temp = $(boxes.get(i))
//       .find(".day_title")
//       .html();
//     let regex = /<(?:\/?)strong>/g;
//     temp = temp.replace(regex, '');
//     a.push(temp);
//
//     let k = $(this).find('div.objects').find('div');
//
//     // console.log($(k[0]).find("div"));
//
//     $.each(k, function(j, val) {
//       a.push([$(this).attr('class'), $(this).html()]);
//     });
//     sch.push(a);
//   })
//   let message = {
//     data: sch
//   }
//   console.log(JSON.stringify(message.data))
//   save(message);
//
// })



function save(messages) {
  // console.log(messages)
  $.ajax({
    type: "GET",
    dataType: 'json',
    async: false,
    url: './stories/save-json.php',
    data: {
      data: JSON.stringify(messages.data)
    },
    success: function() {
      alert("Thanks!");
    },
    failure: function() {
      alert("Error!");
    }
  });
}
