jQuery(document).ready(function($) {
  let isLiked = false;
  let likeBtn = $("#lbp-like-btn");
  if ( likeBtn.hasClass('isLiked') ) {
    isLiked = true;
  }
  $(likeBtn).click(function(e) {
    e.preventDefault();
    var post_id = $(this).attr("data-post_id");
    var user_id = $(this).attr("data-user_id");
    var nonce = $(this).attr("data-nonce"); // another way to pass nonce (or through object in wp_localize_script)
    if (!isLiked) {
      $(this).addClass('isLiked'); // add class and change how btn looks like
      isLiked = 1;
    } else {
      $(this).removeClass('isLiked');
      isLiked = 0; // need 1-0 bcs POST passes string to server, true-false will be always true
    }
    $.ajax({
      type: "post",
      dataType: "json",
      url: lbp.ajaxurl,
      data: { action: 'lbpgo', post_id: post_id, security: nonce, isLiked: isLiked, user_id: user_id },
      success: function(resp) {
        if (resp.type === 'success') {
          $(".number-of-likes").html(resp.like_count)
        } else {
          alert("Error during liking");
        }
      },
      error: function(error) {
        alert("Error during ajax" + error);
      }
    })
  })
})

