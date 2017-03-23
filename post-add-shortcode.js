jQuery( document ).ready( function ( $ ) {

      $( '#pas-form' ).on( 'submit', function(e) {
          e.preventDefault();

          var title = $( '#post-submission-title' ).val();
          var content = $( '#post-submission-content' ).val();
          var status = WP_PAS.status_default;

          var data = {
              title: title,
              status: status,
              content: content,
          };

          $.ajax({
              method: 'POST',
              url: WP_PAS.url,
              data: data,
              beforeSend: function ( xhr ) {
                  xhr.setRequestHeader( 'X-WP-Nonce', WP_PAS.nonce );
              },
              success: function( response ) {
                  $( '#pas-form-result' ).append( '<p>' + WP_PAS.success + '</p>');
                  $( '#pas-form-result' ).append( '<p><a href="' + response.link + '">Просмотреть</a></p>' );
                  $( "#pas-form" ).remove();

                  // console.log( response.link );
                  // console.log( response );

                  // alert( CMDB_SUBMITTER.success );
              },
              fail: function( response ) {
                $('#pas-form-result').append( WP_PAS.failure );
                // console.log( response );

                // alert( CMDB_SUBMITTER.failure );
              }
          });
      });
});
