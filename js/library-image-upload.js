(function($) {
    $(document).ready(function() {
        var $formNotice = $('.form-notice');
        var $imgForm    = $('.image-form');
        /*var $imgNotice  = $imgForm.find('.image-notice');
        var $imgPreview = $imgForm.find('.image-preview');
        var $imgFile    = $imgForm.find('.image-file');
        var $imgId      = $imgForm.find('[name="image_id"]');*/
        
        var $libraryImages = $('.greyed');
        var $libraryEntry = $('.col-library');
        
        var library;
        
        $libraryImages.css('filter','grayscale(100%)');
        $libraryEntry.on('mouseover', function(e) {
        	$(this).find('.greyed').css('filter','inherit');
        }).on('mouseout', function(e) {
        	$(this).find('.greyed').css('filter','grayscale(100%)');
        }).click(function(e) {
        	if (e.target.type === 'file' || $(e.target).hasClass('btn-change-image')) {
        		return;
        	}
        	displayModal($(this).data('dialId'), $(this).data('title'), $(this).data('url'));
        });
        
        
        $imgForm.on( 'click', '.btn-change-image', function(e) {
            e.preventDefault();
            var self = $(this);
            var form = $(self[0].closest("form"));
            var $imgNotice  = form.find('.image-notice');
            var $imgPreview = form.find('.image-preview');
            var $imgFile    = form.find('.image-file');
            var $imgId      = form.find('[name="image_id"]');
            
            $imgNotice.empty().hide();
            $imgFile.val('').show();
            $imgId.val('');
            $imgPreview.empty().hide();
        });
        
        $('.image-file').on('change', function(e) {
            e.preventDefault();
            e.stopPropagation();
            var self = $(this);
            var form = $(self[0].closest("form"));
            var formData = new FormData();
            
            var $imgNotice  = form.find('.image-notice');
            var $imgPreview = form.find('.image-preview');
            var $imgFile    = form.find('.image-file');
            var $imgId      = form.find('[name="image_id"]');
            
            var dialId = self[0].closest("form").dialId.value;

            formData.append('action', 'upload-attachment');
            formData.append('async-upload', self[0].files[0]);
            formData.append('name', self[0].files[0].name);
            formData.append('_wpnonce', su_config.nonce);
            formData.append('publicLibrary', 'true');
            formData.append('dialId', dialId);

            $.ajax({
                url: su_config.upload_url,
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                type: 'POST',
                beforeSend: function() {
                    self.hide();
                    $imgNotice.html('Uploading&hellip;').show();
                },
                success: function(resp) {
                    if ( resp.success ) {
                    	$imgNotice.html('Successfully uploaded. <a href="#" class="btn-change-image">Change?</a>');

                        var img = $('<img>', {
                            src: resp.data.url
                        });

                        $imgId.val( resp.data.id );
                        $('#libraryImage'+dialId).attr('src', su_config.upload_basedir + '/' + dialId + '/' + dialId + '.png?'+Date.now());
                        //$imgPreview.html( img ).show();

                    } else {
                        $imgNotice.html('Failed to upload image. Please try again.');
                        $imgFile.show();
                        $imgId.val('');
                    }
                },
                xhr: function() {
                    var myXhr = $.ajaxSettings.xhr();

                    if ( myXhr.upload ) {
                        myXhr.upload.addEventListener( 'progress', function(e) {
                            if ( e.lengthComputable ) {
                                var perc = ( e.loaded / e.total ) * 100;
                                perc = perc.toFixed(2);
                                $imgNotice.html('Uploading&hellip;(' + perc + '%)');
                            }
                        }, false );
                    }

                    return myXhr;
                }
                
            });
        });
        
    });
    
    function displayModal(dial, title, url) {
    	$('#dialLoadingOverlay').show();
		$('#dialInsertion').hide();
		$('#dialTitle').text("Loading answers...");
		library = new DataFuturesWheel();
		library.init(
			document.getElementById('dataFuturesWheelCanvas'),
			document.getElementById('dataFuturesGuidelinesAnswersQuestion'), 
			document.getElementById('dataFuturesGuidelinesAnswersAnswer'));
		library.draw();
		$('#displayModal').modal();
		
		var data = {'action':'public_wheel', 'id':dial};
		$.get('https://trusteddata.co.nz/wp-json/dataFutures/v1/wheel/'+dial, data, function(response) {
			library.answers = response.answers;
			library.redraw();
			$('#dialTitle').text(title);
			$('#dialLoadingOverlay').fadeOut();
			$('#dialInsertion').fadeIn();
			$('#dataFuturesGuidelinesAnswersQuestion').text("");
			$('#dataFuturesGuidelinesAnswersAnswer').text("");
			if (url) {
				if (!url.toLocaleLowerCase().startsWith('http')) {
					url = 'http://' + url;
				} 
				$('#dialLink').find('a').attr('href', url);
				$('#dialLink').show();
			} else {
				$('#dialLink').hide();
			}
		});
		
		
		
		
		
//		lib<?php echo $dial->id;?>.answers = <?php echo json_encode($dial->answers)?>;
    }
    
})(jQuery);

