/**
 * Transparent Data Use Wheel script.
 * Developed for the Data Futures Partnership by Parhelion http://www.parhelion.co.nz
 * 
 * 
 * To use on your website, first visit the Transparent Data Website, and complete the eight questions.
 * 
 * Next include a link to this script in your page <head> section:
 * <script src="http://trusteddata.co.nz/media/dataFutures.js"></script>
 * 
 * And in your page, insert the code below.  Your answers will be pulled in and displayed in the wheel.
 * <div id="dataFutures" data-wheel-id="[your code]"></div>
 * 
 * Styling:
 * The wheel itself is sized at 350x350px.  Your answers will be injected into a named div inside the 
 * div you inserted above, with the id 'dataFuturesGuidelinesAnswers'.
 * The script will inject standard styling for these elements.  To suppress this and use your own CSS, 
 * append data-style="none" to the #dataFutures div above.  The hierarchy of injected content is shown below.
 * 
 *
 * div#dataFutures
 * 		canvas#dataFuturesWheelCanvas
 * 		div#dataFuturesGuidelinesAnswers
 * 			div#dataFuturesGuidelinesAnswersQuestion
 * 				h1.dataFuturesQuestion
 * 					[question shown here]
 * 				div#dataFuturesGuidelinesAnswersAnswer
 * 					[answer shown here]
 * 
 * 
 * For further assistance contact colin@parhelion.co.nz
 * 
 */
(function(window, document, version, callback) {
    var j, d;
    var loaded = false;
    if (!(j = window.jQuery) || version > j.fn.jquery || callback(j, loaded)) {
        var script = document.createElement("script");
        script.src = "https://code.jquery.com/jquery-3.2.1.js";
        script.onload = script.onreadystatechange = function() {
            if (!loaded && (!(d = this.readyState) || d == "loaded" || d == "complete")) {
                callback((j = window.jQuery).noConflict(1), loaded = true);
                j(script).remove();
            }
        };
        (document.getElementsByTagName("head")[0] || document.documentElement).appendChild(script);
    }
})(window, document, "3.0", function($, jquery_loaded) {
	$( document ).ready(initDataFuturesWheel);
	
	/**
	 * The main wheel object
	 */
	var dataFuturesWheel = {
			'canvas'	:	null,
			'centerX'	:	175,
			'centerY'	:	175,
			'rotation'	:	0,
			'rotating'	:	false,
			'slices'	: [
				{'start':210,'end':255,'color':'#F78F33', 'text':'What will my data be used for?', 'src':'images/Icons-08.png'},
				{'start':255,'end':300,'color':'#F78F33', 'text':'What are the benefits and who will benefit?', 'src':'images/Icons-10.png'},
				{'start':300,  'end':345, 'color':'#F78F33', 'text':'Who will be using my data?', 'src':'images/Icons-09.png'},
				{'start':345, 'end':390, 'color':'#5085a0', 'text':'Is my data secure?', 'src':'images/Icons-07.png'},
				{'start':30, 'end':75,'color':'#5085a0', 'text':'Will my data be anonymous?', 'src':'images/Icons-06.png'},
				{'start':75,'end':120,'color':'#5085a0', 'text':'Can I see and correct data about me?', 'src':'images/Icons-04.png'},
				{'start':120,'end':165,'color':'#9352a0', 'text':'Could my data be sold?', 'src':'images/Icons-05.png'},
				{'start':165,'end':210,'color':'#9352a0', 'text':'Will I be asked for consent?', 'src':'images/Icons-03.png'}
			],
			'answers'	:	[],
			'init'		:	function() {
				this.canvas = document.getElementById('dataFuturesWheelCanvas');
				/*this.slices.forEach(function(slice) {
					slice.img = new Image();
					slice.img.src = 'http://parhelion.co.nz/dataFutures/'+slice.src;
				});*/
			},
			toRadians	:	function(deg) {
				return deg * Math.PI / 180;
			},
			drawSlice	:	function(ctx, colour, startDegrees, endDegrees, radius) {
				var toRadians = this.toRadians;
				var midpoint = startDegrees + ((endDegrees - startDegrees) / 2);
				
				var xOffset = Math.cos(toRadians(midpoint));
				var yOffset = Math.sin(toRadians(midpoint));

				var cx = this.centerX + (xOffset * 5);
				var cy = this.centerY + (yOffset * 5);
				ctx.fillStyle = colour;
				ctx.beginPath();
				ctx.moveTo(cx, cy);
				ctx.arc(cx, cy, radius, toRadians(startDegrees), toRadians(endDegrees));
				ctx.lineTo(cx, cy);
				ctx.closePath();
				ctx.fill();
			},
			arcPath	:	function(ctx, startDegrees, endDegrees, radius) {
				var toRadians = this.toRadians;
				var midpoint = startDegrees + ((endDegrees - startDegrees) / 2);
				
				var xOffset = Math.cos(toRadians(midpoint));
				var yOffset = Math.sin(toRadians(midpoint));

				var cx = this.centerX + (xOffset * 5);
				var cy = this.centerY + (yOffset * 5);
				ctx.beginPath();
				ctx.moveTo(cx, cy);
				ctx.arc(cx, cy, radius, toRadians(startDegrees), toRadians(endDegrees));
				ctx.lineTo(cx, cy);
				ctx.closePath();
			},
			drawInnerSlice:	function(ctx, colour, startDegrees, endDegrees, radius) {
				var self = this;
				var midpoint = startDegrees + ((endDegrees - startDegrees) / 2);
				
				var xOffset = Math.cos(self.toRadians(midpoint));
				var yOffset = Math.sin(self.toRadians(midpoint));

				var cx = self.centerX + (xOffset*2);
				var cy = self.centerY + (yOffset*2);
				ctx.fillStyle = colour;
				ctx.beginPath();
				ctx.moveTo(cx, cy);
				ctx.arc(cx, cy, radius, self.toRadians(startDegrees), self.toRadians(endDegrees));
				ctx.lineTo(cx, cy);
				ctx.closePath();
				ctx.fill();
			},
			
			drawSlices	:	function (ctx, rotation) {
				var innerRadii = 40;
				var middleRadii = 60
				var outerRadii = 165;
				var padding = 5;
				var self = this;
				var toRadians = this.toRadians;
				this.slices.forEach(function(slice) {
					self.drawSlice(ctx, slice.color, slice.start + rotation, slice.end + rotation, outerRadii);
					self.drawText(canvas, (rotation + slice.start + 22.5) % 360, slice.text);
					//self.drawImage(ctx, rotation + slice.start + 22.5, slice.img);
				});

				//fill center with white out to middleRadii + padding
				ctx.fillStyle = '#ffffff';

				cx = self.centerX;
				cy = self.centerY;
				ctx.beginPath();
				ctx.moveTo(cx, cy);
				ctx.arc(cx, cy, middleRadii + padding, 0, Math.PI * 2);
				ctx.lineTo(cx, cy);
				ctx.closePath();
				ctx.fill(); 

				//draw inner slices out to middleRadii
				self.drawInnerSlice(ctx, '#9352a0', this.slices[6].start + rotation, this.slices[7].end + rotation, middleRadii);
				self.drawInnerSlice(ctx, '#F78F33', this.slices[0].start + rotation, this.slices[2].end + rotation, middleRadii);
				self.drawInnerSlice(ctx, '#5085a0', this.slices[3].start + rotation, this.slices[5].end + 360 + rotation, middleRadii);
				
				//fill center with white out to innerRadii + padding
				ctx.fillStyle = '#ffffff';
				
				cx = self.centerX;
				cy = self.centerY;
				ctx.beginPath();
				ctx.moveTo(cx, cy);
				ctx.arc(cx, cy, innerRadii + 5, 0, Math.PI * 2);
				ctx.lineTo(cx, cy);
				ctx.closePath();
				ctx.fill();  
				 		
				//draw text on paths
				var textRadius = innerRadii + 9;
				ctx.font = 'bold 10px Arial';
				ctx.fillTextCircle("CHOICE",self.centerX,self.centerY,textRadius,toRadians(220+rotation), toRadians(290+rotation));
				ctx.fillTextCircle("VALUE",self.centerX,self.centerY,textRadius,toRadians(340+rotation), toRadians(385+rotation));
				ctx.fillTextCircle("PROTECTION",self.centerX,self.centerY,textRadius,toRadians(95+rotation), toRadians(190+rotation));
				
				ctx.fillStyle = '#000000';
				
				cx = self.centerX;
				cy = self.centerY;
				ctx.beginPath();
				ctx.moveTo(cx, cy);
				ctx.arc(cx, cy, innerRadii, 0, Math.PI * 2);
				ctx.lineTo(cx, cy);
				ctx.closePath();
				ctx.fill();  
				
				ctx.fillStyle = '#ffffff';
				ctx.fillText('TRANSPARENT', self.centerX - 36, self.centerY);
				ctx.fillText('DATA USE', self.centerX - 24, self.centerY + 13);
					
			},
			     
			drawImage	:	function (ctx, rotation, img) {
				var xOffset = Math.cos(this.toRadians(rotation)) * 62;
				var yOffset = Math.sin(this.toRadians(rotation)) * 62;
				if (img.complete) {
					ctx.drawImage(img, this.centerX + xOffset - 40, this.centerY + yOffset - 40);
				} else {
					window.setTimeout(this.drawImage.bind(this), 1000, ctx, rotation, img);
				}
			},
			     
			drawText	:	function (canvas, rotation, text) {
				canvas.getContext('2d').fillStyle = '#ffffff';
				var xOffset = Math.cos(this.toRadians(rotation)) * 120;
				var yOffset = Math.sin(this.toRadians(rotation)) * 120;
				this.writeTextWrap(canvas, this.centerX + xOffset - 40, this.centerY + yOffset - 35, 80, 70, text, 12, 5);

			},

			draw		:	function () {
				var self = this;
				var canvas = document.getElementById('dataFuturesWheelCanvas');
				if (canvas.getContext) {
			    	var ctx = canvas.getContext('2d');
				}
				var f = new FontFace('MyriadPro', 'url(https://trusteddata.co.nz/dial-font)');
				f.load().then(function() {
					self.drawSlices(ctx, 0);
				});

			},
			
			rotate	:	function (desiredRotation) {
				var self = this;

				var ctx = canvas.getContext('2d');
				if (desiredRotation % 360 === self.rotation % 360) {
					self.rotating = false;
					//showSelectedText();
					return;
				}
				
				desiredRotation = desiredRotation % 360;
				self.rotation = self.rotation % 360;
				if (desiredRotation > self.rotation) {
					self.rotation = self.rotation + 360;
				}
				
				if (self.rotation - desiredRotation > (desiredRotation + 360 - self.rotation)) {
					self.rotation += 5;
				} else {	
					self.rotation -= 5;
					if (self.rotation <= 0) {
						self.rotation += 360;
					}
				}
				ctx.fillStyle = '#ffffff';
				ctx.clearRect(0,0,350,350);
			    	  
				self.drawSlices(ctx, self.rotation);
				window.requestAnimationFrame(function() {
					self.rotate(desiredRotation);
			    });
			},
			
			getMousePos	:	function(canvas, evt) {
				var rect = canvas.getBoundingClientRect();
				return {
					x: evt.clientX - rect.left,
					y: evt.clientY - rect.top
				};
			},
			
			/**
			 * Writes text inside a fixed rectangle, wrapping as required
			 * @param canvas : The canvas object where to draw . 
			 * @param x     :  The x position of the rectangle.
			 * @param y     :  The y position of the rectangle.
			 * @param w     :  The width of the rectangle.
			 * @param h     :  The height of the rectangle.
			 * @param text  :  The text we are going to centralize.
			 * @param fh    :  The font height (in pixels).
			 * @param spl   :  Vertical space between lines
			 */
			writeTextWrap	:	function(canvas, x, y, w, h, text, fh, spl) {
			    var Paint = {
			        VALUE_FONT : '12px MyriadPro'
			    }
			    /*
			     * @param ctx   : The 2d context 
			     * @param mw    : The max width of the text accepted
			     * @param font  : The font used to draw the text
			     * @param text  : The text to be splitted   into 
			     */
				var splitLines = function(ctx, mw, font, text) {
			        // We give a little "padding"

			        mw = mw - 10;
			        // We setup the text font to the context (if not already)
			        ctx2d.font = font;
			        // We split the text by words 
			        var words = text.split(' ');
			        var newLine = words[0];
			        var lines = [];
			        for(var i = 1; i < words.length; ++i) {
			        	if (ctx.measureText(newLine + " " + words[i]).width < mw) {
			        		newLine += " " + words[i];
			           } else {
			        	   lines.push(newLine);
			        	   newLine = words[i];
			           }
			        }
			        lines.push(newLine);
			        return lines;
			    }

			    var ctx2d = canvas.getContext('2d');
			    if (ctx2d) {

			        // Paint text
			        var lines = splitLines(ctx2d, w, Paint.VALUE_FONT, text);
			        // Block of text height
			        var both = lines.length * (fh + spl);
			        if (both >= h) {
			            // We won't be able to wrap the text inside the area
			            // the area is too small. We should inform the user 
			            // about this in a meaningful way
			            console.log('both >= h');
			        } else {
			            // We determine the y of the first line
			            var ly = (h - both)/2 + y + spl*lines.length;
			            var lx = 0;
			            for (var j = 0, ly; j < lines.length; ++j, ly+=fh+spl) {
			                // We continue to centralise the lines
			                lx = x+w/2-ctx2d.measureText(lines[j]).width/2;
			                ctx2d.fillText(lines[j], lx, ly);
			            }
			        }
			    } else {
			    	console.log('No context!');
			    }
			},
			load: function(id) {
				$.get('https://trusteddata.co.nz/wp-json/dataFutures/v1/wheel/'+id, {}, function(response) {
					dataFuturesWheel.answers = response.answers;
					dataFuturesWheel.rotate(0);
				});
			}
			
		}

		function initDataFuturesWheel($) {
			var elem = $('#dataFutures');
			if (!elem.length) {
				console.log('Not able to find Data Futures embed location. Please read the documentation at the top of this file.');
				return;
			}
			var comment = "<!-- Transparent Data Use Dial embeddable widget created for Data Futures by Parhelion http://parhelion.co.nz -->";
			$(comment).insertBefore(elem);
			
			var style_link = $("<style>");
			style_link.text(
					"h1.dataFuturesQuestion {font-size:1.2em;font-weight:bold;}" +
					"#dataFutures { max-width:700px;} " +
					"#dataFuturesGuidelinesAnswers {width:270px;display:inline-block;vertical-align: top;padding:40px;font-size:1.1em;}" +
					"#dataFuturesWheelCanvas{display:inline-block;max-width:350px;width:100%;vertical-align: top}" +
					"#dataFutures .dataFuturesDisclaimer {font-size:0.9em;}");
			
			if (elem.data('style') != 'none') {
				style_link.appendTo('head');
			}
			elem.append("<canvas id='dataFuturesWheelCanvas' width='350px' height='350px'></canvas><div id='dataFuturesGuidelinesAnswers'><div id='dataFuturesGuidelinesAnswersQuestion'></div><div id='dataFuturesGuidelinesAnswersAnswer'></div></div>");
			if (elem.data('disclaimer') != 'none') {
				elem.append("<div class='dataFuturesDisclaimer'><p>This <strong>Transparent Data</strong> privacy dial was created using the free tool at <a href=\"http://www.trusteddata.co.nz\">trusteddata.co.nz</a>, brought to you by the Data Futures Partnership. <a href=\"http://www.trusteddata.co.nz\">Create yours today</a>");
			}
			canvas = document.getElementById('dataFuturesWheelCanvas');
			var ctx = canvas.getContext('2d');
			dataFuturesWheel.init();
			dataFuturesWheel.draw();
			
			if (typeof dataFuturesDialCallback === "function") {
				dataFuturesDialCallback(dataFuturesWheel);
			}
			
			document.getElementById('dataFutures').dataset.dial = dataFuturesWheel;
			
			if (elem.data('wheel-id')) {
				var data = {'action':'public_wheel', 'id':elem.data('wheel-id')};
				$.get('https://trusteddata.co.nz/wp-json/dataFutures/v1/wheel/'+elem.data('wheel-id'), data, function(response) {
					dataFuturesWheel.answers = response.answers;
				});
			}
			
			canvas.addEventListener('click', function(evt) {
				
				if (dataFuturesWheel.rotating) {
					return;
				}
				var ctx = canvas.getContext('2d');
			    
				var mousePos = dataFuturesWheel.getMousePos(canvas, evt);

				var actualX = mousePos.x * canvas.width / canvas.clientWidth;
				var actualY = mousePos.y * canvas.height / canvas.clientHeight;
				
				var cx = dataFuturesWheel.centerX;
				var cy = dataFuturesWheel.centerY;
				var innerRadii = 40;
				ctx.beginPath();
				ctx.arc(cx, cy, innerRadii, 0, Math.PI * 2, false);
				if (ctx.isPointInPath(actualX,actualY)) {
					window.location = 'https://trusteddata.co.nz/';
					return;
				}
				
				var clicked = -1;
				
				for(var i=0;i<8;i++){
					dataFuturesWheel.arcPath(ctx, (i*45)+210+dataFuturesWheel.rotation,((i+1)*45)+210+dataFuturesWheel.rotation,165);
					if(ctx.isPointInPath(actualX,actualY)){
						clicked = i;
						break;
					}
				}
				
				if (clicked >= 0) {
					$('#dataFuturesGuidelinesAnswersQuestion').html('<h1 class="dataFuturesQuestion">'+dataFuturesWheel.slices[clicked].text+"</h1>");
					var answer = dataFuturesWheel.answers.find(function(el){return el.question_id == clicked+1});
					if (answer) {
						$('#dataFuturesGuidelinesAnswersAnswer').text(answer.answer);
					} else {
						$('#dataFuturesGuidelinesAnswersAnswer').text('');
					}
					dataFuturesWheel.rotate(485 - (i * 45));
				}
			    	 
			});
			
			canvas.addEventListener('mousemove', function(evt) {
				var ctx = canvas.getContext('2d');
				var mousePos = dataFuturesWheel.getMousePos(canvas, evt);
				
				evt.preventDefault();
				evt.stopPropagation();

				mouseX = mousePos.x * canvas.width / canvas.clientWidth;
				mouseY = mousePos.y * canvas.height / canvas.clientHeight;
				
				var isPointer = false;
				
				var cx = dataFuturesWheel.centerX;
				var cy = dataFuturesWheel.centerY;
				var innerRadii = 40;
				ctx.beginPath();
				ctx.arc(cx, cy, innerRadii, 0, Math.PI * 2, false);
				if (ctx.isPointInPath(mouseX, mouseY)) {
					canvas.style.cursor='alias';
					return;
				}
				
				for(var i=0;i<8;i++){
					dataFuturesWheel.arcPath(ctx, (i*45)+210+dataFuturesWheel.rotation,((i+1)*45)+210+dataFuturesWheel.rotation,165);
					if(ctx.isPointInPath(mouseX,mouseY)){
			    	   	isPointer = true;
			    	   	break;
			    	}
			    }
			    if(isPointer){
			    	canvas.style.cursor = 'pointer';
				} else {
					canvas.style.cursor = 'default';
				}
			    
			 }, false);
		}

});




/**
 * Write text on a path
 */
CanvasRenderingContext2D.prototype.fillTextCircle = function(text,x,y,radius,startRotation, endRotation){
	var numRadsPerLetter = (endRotation - startRotation) / text.length;
	this.save();
	this.translate(x,y);
	this.rotate(startRotation);
	startRotation = startRotation % (2 * Math.PI);
	endRotation = endRotation % (2 * Math.PI);
	var numIs = 0;
	
	if (startRotation > (3 * Math.PI / 8) && startRotation < (13 * Math.PI) / 8 && endRotation > (3 * Math.PI / 8) && endRotation < (13 * Math.PI) / 8) {
		this.rotate(Math.PI);
		this.rotate(numRadsPerLetter);
		for(var i=0;i<text.length;i++){
			this.save();
			if (text[text.length - 1 - i] === 'I') {
				numIs++;
			}
			this.rotate(i*numRadsPerLetter - (numIs*numRadsPerLetter/2));
			
			this.fillText(text[text.length - 1 - i],0,radius+6);
			this.restore();
		}
	} else {
		for(var i=0;i<text.length;i++){
			this.save();
			this.rotate(i*numRadsPerLetter - (numIs * numRadsPerLetter/2));

			this.fillText(text[i],0,-radius);
			if (text[i] === 'I') {
				numIs++;
			}
			this.restore();
		}
	}
	this.restore();
}
//https://tc39.github.io/ecma262/#sec-array.prototype.find
if (!Array.prototype.find) {
  Object.defineProperty(Array.prototype, 'find', {
    value: function(predicate) {
     // 1. Let O be ? ToObject(this value).
      if (this == null) {
        throw new TypeError('"this" is null or not defined');
      }

      var o = Object(this);

      // 2. Let len be ? ToLength(? Get(O, "length")).
      var len = o.length >>> 0;

      // 3. If IsCallable(predicate) is false, throw a TypeError exception.
      if (typeof predicate !== 'function') {
        throw new TypeError('predicate must be a function');
      }

      // 4. If thisArg was supplied, let T be thisArg; else let T be undefined.
      var thisArg = arguments[1];

      // 5. Let k be 0.
      var k = 0;

      // 6. Repeat, while k < len
      while (k < len) {
        // a. Let Pk be ! ToString(k).
        // b. Let kValue be ? Get(O, Pk).
        // c. Let testResult be ToBoolean(? Call(predicate, T, « kValue, k, O »)).
        // d. If testResult is true, return kValue.
        var kValue = o[k];
        if (predicate.call(thisArg, kValue, k, o)) {
          return kValue;
        }
        // e. Increase k by 1.
        k++;
      }

      // 7. Return undefined.
      return undefined;
    }
  });
}