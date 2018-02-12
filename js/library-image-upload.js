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
        
        $libraryImages.css('filter','grayscale(80%)');
        $libraryImages.css('opacity','0.8');
        $libraryEntry.on('mouseover', function(e) {
        	$(this).find('.greyed').css('filter','inherit');
        	$(this).find('.greyed').css('opacity','1');

        }).on('mouseout', function(e) {
        	$(this).find('.greyed').css('filter','grayscale(80%)');
        	$(this).find('.greyed').css('opacity','0.8');
        }).click(function(e) {
        	if (e.target.type === 'file' || $(e.target).hasClass('btn-change-image')) {
        		return;
        	}
        	displayModal($(this).data('dialId'), $(this).data('title'), $(this).data('url'), $(this).data('publicId'));
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
    
    function displayModal(dial, title, url, publicDial) {
    		$('#dialLoadingOverlay').show();
    		$('#opengraph').hide();
    		$('#dialInsertion').hide();
		$('#dialTitle').text("Loading answers...");
		library = new DataFuturesWheel();
		library.init(
			document.getElementById('dataFuturesWheelCanvas'),
			document.getElementById('dataFuturesGuidelinesAnswersQuestion'), 
			document.getElementById('dataFuturesGuidelinesAnswersAnswer'));
		library.draw();
		$('#displayModal').modal();
		
		$.when(getResponses(library, publicDial, title, url), getOpenGraph(dial)).done(function (a1, a2) {
			console.log('whenning', a1, a2);
			$('#dialLoadingOverlay').hide();
			$('#dialInsertion').fadeIn();
			
			if ($('#opengraph-title').text()) {
				$('#opengraph').show();
			}

		});
		
		
		
    }
    
    function getResponses(library, publicDial, title, url) {
    		var data = {'action':'public_wheel', 'id':publicDial};
		return $.get('https://trusteddata.co.nz/wp-json/dataFutures/v1/wheel/'+publicDial, data, function(response) {
			library.answers = response.answers;
			library.redraw();
			$('#dialTitle').text(title);
			
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
    }
    
    function getOpenGraph(dial) {
    		return $.post(su_config.ajax_url + "?action=opengraph&id="+dial, function(response) {
			var data = JSON.parse(response);
			if (data.title) {
				
				$('#opengraph-title').text(data.title);
				$('#opengraph-description').text(data.description);
				$('#opengraph-image').attr('src', data.image);

			} else {
				$('#opengraph-title').text('');
			}
		});
    }
    
})(jQuery);

