jQuery( function($){

// hide imgs when deleted or saved
  $message = $('.notice.notice-success');
  if ($message.hasClass('deleted')) {
    $('#no-image').hide(); 
    $('#is-image').hide();
  }
  if ($message.hasClass('saved')) {
    $('#no-image').hide();
    $('#is-image').hide();
  }

  // on upload button click
  $( 'body' ).on( 'click', '.rudr-upload', function( event ){
    event.preventDefault(); 
    const button = $(this)
    const imageId = button.next().next().val();
    const customUploader = wp.media({
      title: 'Insert image', // modal window title
      library : {
        type : 'image'
      },
      button: {
        text: 'Use this image' // button label text
      },
      multiple: false
    }).on( 'select', function() { 
      const attachment = customUploader.state().get( 'selection' ).first().toJSON();
      button.removeClass( 'button' ).html( '<img src="' + attachment.url + '">'); 
      button.next().show(); // show "Remove image" link
      button.next().next().val( attachment.id );
    })

    // already selected images
    customUploader.on( 'open', function() {

      if( imageId ) {
        const selection = customUploader.state().get( 'selection' )
        attachment = wp.media.attachment( imageId );
        attachment.fetch();
        selection.add( attachment ? [attachment] : [] );
      }
    })

    customUploader.open()

  });
  
  // on remove button click
  $( 'body' ).on( 'click', '.rudr-remove', function( event ){
    event.preventDefault();
    const button = $(this);
    $('#rudr-hid-val').val( '' ); // emptying the hidden field
    $('#rudr-hid-val1').val( '' ); 
    button.hide().prev().addClass( 'button' ).html( 'Upload image' ); // replace the image with text
  });
});