jQuery(document).ready(function($) {
  let isLiked = false;
  let thumbBtn = $("#thumb-btn");
  isLiked = !!thumbBtn.hasClass('fa-green'); // isLiked is true if thumbBtn has such class

  $('#thumb-btn').click(function(e) {
    let post_id = $(this).attr("data-post_id");
    let numberOfThumbs = parseInt($('#number-of-thumbs').text());
    if (!isLiked) { // if wasn't previously liked
      $(this).removeClass('jumping');
      $(this).addClass('fa-green'); // add class and change how btn looks like
      $('#number-of-thumbs').text(++numberOfThumbs); // first increments, then returns, number++ wouldn't work
      isLiked = 1;
    } else { // if was already liked before, unlike it
      $(this).removeClass('fa-green');
      $(this).addClass('jumping');
      $('#number-of-thumbs').text(--numberOfThumbs);
      isLiked = 0; // need 1-0 bcs POST passes string to server, true-false will be always true
    }
    $.ajax({
      type: "POST",
      url: thumb.ajaxurl,
      data: {action: 'thumbgo', post_id: post_id, isLiked: isLiked}
    }).done(function (resp) {
      console.log(resp);
      // $("#number-of-thumbs").html(resp);
    }).fail(function (error) {
      console.log("Error during ajax: " + error);
    })
    // old way to write
      // success: function(resp) {
      //     $("#number-of-thumbs").html(resp);
      // },
      // error: function(error) {
      //   alert("Error during ajax: " + error);
      // }
    // });
  });
})