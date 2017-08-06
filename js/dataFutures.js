/**
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
	console.log('have a jquery, initing');
	$( document ).ready(initDataFuturesWheel);
});


var dataFuturesWheel = {
	'canvas'	:	null,
	'centerX'	:	175,
	'centerY'	:	175,
	'rotation'	:	0,
	'rotating'	:	false,
	'slices'	: [
		{'start':90,'end':135,'color':'#9352a0', 'text':'Will I be asked for consent?', 'src':'images/Icons-05.png'},
		{'start':135,'end':180,'color':'#9352a0', 'text':'Could my data be sold?', 'src':'images/Icons-03.png'},
		{'start':180,'end':225,'color':'#F78F33', 'text':'What will my data be used for?', 'src':'images/Icons-08.png'},
		{'start':225,'end':270,'color':'#F78F33', 'text':'What are the benefits and who will benefit?', 'src':'images/Icons-10.png'},
		{'start':270,  'end':315, 'color':'#F78F33', 'text':'Who will be using my data?', 'src':'images/Icons-09.png'},
		{'start':315, 'end':360, 'color':'#5085a0', 'text':'Is my data secure?', 'src':'images/Icons-07.png'},
		{'start':0, 'end':45,'color':'#5085a0', 'text':'Will my data be anonymous?', 'src':'images/Icons-06.png'},
		{'start':45,'end':90,'color':'#5085a0', 'text':'Can I see and correct data about me?', 'src':'images/Icons-04.png'}
			
	],
	'init'		:	function() {
		this.canvas = document.getElementById('dataFuturesWheelCanvas');
		this.slices.forEach(function(slice) {
			slice.img = new Image();
			slice.img.src = 'http://parhelion.co.nz/dataFutures/'+slice.src;
		});
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
		var innerRadii = 22;
		var outerRadii = 165;
		var self = this;
		var toRadians = this.toRadians;
		this.slices.forEach(function(slice) {
			self.drawSlice(ctx, slice.color, slice.start + rotation, slice.end + rotation, outerRadii);
			self.drawText(canvas, (rotation + slice.start + 22.5) % 360, slice.text);
			self.drawImage(ctx, rotation + slice.start + 22.5, slice.img);
		});

		ctx.fillStyle = '#ffffff';

		cx = self.centerX;
		cy = self.centerY;
		ctx.beginPath();
		ctx.moveTo(cx, cy);
		ctx.arc(cx, cy, innerRadii + 20, 0, Math.PI * 2);
		ctx.lineTo(cx, cy);
		ctx.closePath();
		ctx.fill(); 

		self.drawInnerSlice(ctx, '#9352a0', this.slices[0].start + rotation, this.slices[1].end + rotation, innerRadii + 15);
		self.drawInnerSlice(ctx, '#F78F33', this.slices[2].start + rotation, this.slices[4].end + rotation, innerRadii + 15);
		self.drawInnerSlice(ctx, '#5085a0', this.slices[5].start + rotation, this.slices[7].end + 360 + rotation, innerRadii + 15);
		
		ctx.fillStyle = '#ffffff';
		
		cx = self.centerX;
		cy = self.centerY;
		ctx.beginPath();
		ctx.moveTo(cx, cy);
		ctx.arc(cx, cy, innerRadii + 5, 0, Math.PI * 2);
		ctx.lineTo(cx, cy);
		ctx.closePath();
		ctx.fill();  
		 		
		var textRadius = innerRadii + 7;
		ctx.font = '7px Arial';
		ctx.fillTextCircle("CHOICE",self.centerX,self.centerY,textRadius,toRadians(280+rotation), toRadians(350+rotation));
		ctx.fillTextCircle("VALUE",self.centerX,self.centerY,textRadius,toRadians(30+rotation), toRadians(105+rotation));
		ctx.fillTextCircle("PROTECTION",self.centerX,self.centerY,textRadius,toRadians(145+rotation), toRadians(260+rotation));
		
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
		ctx.fillText('Transparent', self.centerX - 19, self.centerY - 4);
		ctx.fillText('Data Use', self.centerX - 14, self.centerY + 4);
			
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
		var canvas = document.getElementById('dataFuturesWheelCanvas');
		if (canvas.getContext) {
	    	var ctx = canvas.getContext('2d');
		}
	    drawSlices(ctx, 0);

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
	        VALUE_FONT : '12px Arial'
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
	}
	
}

function initDataFuturesWheel($) {
	var elem = $('#dataFutures');
	if (!elem.length) {
		console.log('Not able to find Data Futures embed location');
		return;
	}
	
	
	elem.append("<canvas id='dataFuturesWheelCanvas' width='350px' height='350px'></canvas><div id='dataFuturesGuidelinesAnswers'></div>");

	canvas = document.getElementById('dataFuturesWheelCanvas');
	var ctx = canvas.getContext('2d');
	dataFuturesWheel.init();
	dataFuturesWheel.drawSlices(ctx, 0);
	
	canvas.addEventListener('click', function(evt) {
		if (dataFuturesWheel.rotating) {
			return;
		}
		var ctx = canvas.getContext('2d');
	    
		var mousePos = dataFuturesWheel.getMousePos(canvas, evt);

		var clicked = -1;
		
		for(var i=0;i<8;i++){
			dataFuturesWheel.arcPath(ctx, (i*45)+dataFuturesWheel.rotation,((i+1)*45)+dataFuturesWheel.rotation,165);
			if(ctx.isPointInPath(mousePos.x,mousePos.y)){
				clicked = i;
				break;
			}
		}
		
		if (clicked >= 0) {
			document.getElementById('dataFuturesGuidelinesAnswers').innerHTML = '';
			console.log('clicked on ',clicked);
			dataFuturesWheel.rotate(315 - (i * 45));
		}
	    	 
	});
	
	canvas.addEventListener('mousemove', function(evt) {
		var ctx = canvas.getContext('2d');
		var mousePos = dataFuturesWheel.getMousePos(canvas, evt);
		
		evt.preventDefault();
		evt.stopPropagation();

		mouseX=mousePos.x;
		mouseY=mousePos.y;

		// Put your mousemove stuff here
		var isPointer = false;
		for(var i=0;i<8;i++){
			dataFuturesWheel.arcPath(ctx, (i*45)+dataFuturesWheel.rotation,((i+1)*45)+dataFuturesWheel.rotation,165);
			if(ctx.isPointInPath(mouseX,mouseY)){
	    	   	isPointer = true;
	    	   	break;
	    	}
	    }
	    if(isPointer){
			canvas.style.cursor='pointer';              
		} else {
			canvas.style.cursor = 'default';
		}
	    
	 }, false);
}


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

	if (startRotation > (3 * Math.PI / 8) && startRotation < (13 * Math.PI) / 8 && endRotation > (3 * Math.PI / 8) && endRotation < (13 * Math.PI) / 8) {
		this.rotate(Math.PI);
		this.rotate(numRadsPerLetter);
		for(var i=0;i<text.length;i++){
			this.save();
			this.rotate(i*numRadsPerLetter);

			this.fillText(text[text.length - 1 - i],0,radius+6);
			this.restore();
		}
	} else {
		for(var i=0;i<text.length;i++){
			this.save();
			this.rotate(i*numRadsPerLetter);

			this.fillText(text[i],0,-radius);
			this.restore();
		}
	}
	this.restore();
}


//Copyright (c) 2013 Pieroxy <pieroxy@pieroxy.net>
//This work is free. You can redistribute it and/or modify it
//under the terms of the WTFPL, Version 2
//For more information see LICENSE.txt or http://www.wtfpl.net/
//
//For more information, the home page:
//http://pieroxy.net/blog/pages/lz-string/testing.html
//
//LZ-based compression algorithm, version 1.4.4
var LZString = (function() {

//private property
var f = String.fromCharCode;
var keyStrBase64 = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";
var keyStrUriSafe = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+-$";
var baseReverseDic = {};

function getBaseValue(alphabet, character) {
if (!baseReverseDic[alphabet]) {
 baseReverseDic[alphabet] = {};
 for (var i=0 ; i<alphabet.length ; i++) {
   baseReverseDic[alphabet][alphabet.charAt(i)] = i;
 }
}
return baseReverseDic[alphabet][character];
}

var LZString = {
compressToBase64 : function (input) {
 if (input == null) return "";
 var res = LZString._compress(input, 6, function(a){return keyStrBase64.charAt(a);});
 switch (res.length % 4) { // To produce valid Base64
 default: // When could this happen ?
 case 0 : return res;
 case 1 : return res+"===";
 case 2 : return res+"==";
 case 3 : return res+"=";
 }
},

decompressFromBase64 : function (input) {
 if (input == null) return "";
 if (input == "") return null;
 return LZString._decompress(input.length, 32, function(index) { return getBaseValue(keyStrBase64, input.charAt(index)); });
},

compressToUTF16 : function (input) {
 if (input == null) return "";
 return LZString._compress(input, 15, function(a){return f(a+32);}) + " ";
},

decompressFromUTF16: function (compressed) {
 if (compressed == null) return "";
 if (compressed == "") return null;
 return LZString._decompress(compressed.length, 16384, function(index) { return compressed.charCodeAt(index) - 32; });
},

//compress into uint8array (UCS-2 big endian format)
compressToUint8Array: function (uncompressed) {
 var compressed = LZString.compress(uncompressed);
 var buf=new Uint8Array(compressed.length*2); // 2 bytes per character

 for (var i=0, TotalLen=compressed.length; i<TotalLen; i++) {
   var current_value = compressed.charCodeAt(i);
   buf[i*2] = current_value >>> 8;
   buf[i*2+1] = current_value % 256;
 }
 return buf;
},

//decompress from uint8array (UCS-2 big endian format)
decompressFromUint8Array:function (compressed) {
 if (compressed===null || compressed===undefined){
     return LZString.decompress(compressed);
 } else {
     var buf=new Array(compressed.length/2); // 2 bytes per character
     for (var i=0, TotalLen=buf.length; i<TotalLen; i++) {
       buf[i]=compressed[i*2]*256+compressed[i*2+1];
     }

     var result = [];
     buf.forEach(function (c) {
       result.push(f(c));
     });
     return LZString.decompress(result.join(''));

 }

},


//compress into a string that is already URI encoded
compressToEncodedURIComponent: function (input) {
 if (input == null) return "";
 return LZString._compress(input, 6, function(a){return keyStrUriSafe.charAt(a);});
},

//decompress from an output of compressToEncodedURIComponent
decompressFromEncodedURIComponent:function (input) {
 if (input == null) return "";
 if (input == "") return null;
 input = input.replace(/ /g, "+");
 return LZString._decompress(input.length, 32, function(index) { return getBaseValue(keyStrUriSafe, input.charAt(index)); });
},

compress: function (uncompressed) {
 return LZString._compress(uncompressed, 16, function(a){return f(a);});
},
_compress: function (uncompressed, bitsPerChar, getCharFromInt) {
 if (uncompressed == null) return "";
 var i, value,
     context_dictionary= {},
     context_dictionaryToCreate= {},
     context_c="",
     context_wc="",
     context_w="",
     context_enlargeIn= 2, // Compensate for the first entry which should not count
     context_dictSize= 3,
     context_numBits= 2,
     context_data=[],
     context_data_val=0,
     context_data_position=0,
     ii;

 for (ii = 0; ii < uncompressed.length; ii += 1) {
   context_c = uncompressed.charAt(ii);
   if (!Object.prototype.hasOwnProperty.call(context_dictionary,context_c)) {
     context_dictionary[context_c] = context_dictSize++;
     context_dictionaryToCreate[context_c] = true;
   }

   context_wc = context_w + context_c;
   if (Object.prototype.hasOwnProperty.call(context_dictionary,context_wc)) {
     context_w = context_wc;
   } else {
     if (Object.prototype.hasOwnProperty.call(context_dictionaryToCreate,context_w)) {
       if (context_w.charCodeAt(0)<256) {
         for (i=0 ; i<context_numBits ; i++) {
           context_data_val = (context_data_val << 1);
           if (context_data_position == bitsPerChar-1) {
             context_data_position = 0;
             context_data.push(getCharFromInt(context_data_val));
             context_data_val = 0;
           } else {
             context_data_position++;
           }
         }
         value = context_w.charCodeAt(0);
         for (i=0 ; i<8 ; i++) {
           context_data_val = (context_data_val << 1) | (value&1);
           if (context_data_position == bitsPerChar-1) {
             context_data_position = 0;
             context_data.push(getCharFromInt(context_data_val));
             context_data_val = 0;
           } else {
             context_data_position++;
           }
           value = value >> 1;
         }
       } else {
         value = 1;
         for (i=0 ; i<context_numBits ; i++) {
           context_data_val = (context_data_val << 1) | value;
           if (context_data_position ==bitsPerChar-1) {
             context_data_position = 0;
             context_data.push(getCharFromInt(context_data_val));
             context_data_val = 0;
           } else {
             context_data_position++;
           }
           value = 0;
         }
         value = context_w.charCodeAt(0);
         for (i=0 ; i<16 ; i++) {
           context_data_val = (context_data_val << 1) | (value&1);
           if (context_data_position == bitsPerChar-1) {
             context_data_position = 0;
             context_data.push(getCharFromInt(context_data_val));
             context_data_val = 0;
           } else {
             context_data_position++;
           }
           value = value >> 1;
         }
       }
       context_enlargeIn--;
       if (context_enlargeIn == 0) {
         context_enlargeIn = Math.pow(2, context_numBits);
         context_numBits++;
       }
       delete context_dictionaryToCreate[context_w];
     } else {
       value = context_dictionary[context_w];
       for (i=0 ; i<context_numBits ; i++) {
         context_data_val = (context_data_val << 1) | (value&1);
         if (context_data_position == bitsPerChar-1) {
           context_data_position = 0;
           context_data.push(getCharFromInt(context_data_val));
           context_data_val = 0;
         } else {
           context_data_position++;
         }
         value = value >> 1;
       }


     }
     context_enlargeIn--;
     if (context_enlargeIn == 0) {
       context_enlargeIn = Math.pow(2, context_numBits);
       context_numBits++;
     }
     // Add wc to the dictionary.
     context_dictionary[context_wc] = context_dictSize++;
     context_w = String(context_c);
   }
 }

 // Output the code for w.
 if (context_w !== "") {
   if (Object.prototype.hasOwnProperty.call(context_dictionaryToCreate,context_w)) {
     if (context_w.charCodeAt(0)<256) {
       for (i=0 ; i<context_numBits ; i++) {
         context_data_val = (context_data_val << 1);
         if (context_data_position == bitsPerChar-1) {
           context_data_position = 0;
           context_data.push(getCharFromInt(context_data_val));
           context_data_val = 0;
         } else {
           context_data_position++;
         }
       }
       value = context_w.charCodeAt(0);
       for (i=0 ; i<8 ; i++) {
         context_data_val = (context_data_val << 1) | (value&1);
         if (context_data_position == bitsPerChar-1) {
           context_data_position = 0;
           context_data.push(getCharFromInt(context_data_val));
           context_data_val = 0;
         } else {
           context_data_position++;
         }
         value = value >> 1;
       }
     } else {
       value = 1;
       for (i=0 ; i<context_numBits ; i++) {
         context_data_val = (context_data_val << 1) | value;
         if (context_data_position == bitsPerChar-1) {
           context_data_position = 0;
           context_data.push(getCharFromInt(context_data_val));
           context_data_val = 0;
         } else {
           context_data_position++;
         }
         value = 0;
       }
       value = context_w.charCodeAt(0);
       for (i=0 ; i<16 ; i++) {
         context_data_val = (context_data_val << 1) | (value&1);
         if (context_data_position == bitsPerChar-1) {
           context_data_position = 0;
           context_data.push(getCharFromInt(context_data_val));
           context_data_val = 0;
         } else {
           context_data_position++;
         }
         value = value >> 1;
       }
     }
     context_enlargeIn--;
     if (context_enlargeIn == 0) {
       context_enlargeIn = Math.pow(2, context_numBits);
       context_numBits++;
     }
     delete context_dictionaryToCreate[context_w];
   } else {
     value = context_dictionary[context_w];
     for (i=0 ; i<context_numBits ; i++) {
       context_data_val = (context_data_val << 1) | (value&1);
       if (context_data_position == bitsPerChar-1) {
         context_data_position = 0;
         context_data.push(getCharFromInt(context_data_val));
         context_data_val = 0;
       } else {
         context_data_position++;
       }
       value = value >> 1;
     }


   }
   context_enlargeIn--;
   if (context_enlargeIn == 0) {
     context_enlargeIn = Math.pow(2, context_numBits);
     context_numBits++;
   }
 }

 // Mark the end of the stream
 value = 2;
 for (i=0 ; i<context_numBits ; i++) {
   context_data_val = (context_data_val << 1) | (value&1);
   if (context_data_position == bitsPerChar-1) {
     context_data_position = 0;
     context_data.push(getCharFromInt(context_data_val));
     context_data_val = 0;
   } else {
     context_data_position++;
   }
   value = value >> 1;
 }

 // Flush the last char
 while (true) {
   context_data_val = (context_data_val << 1);
   if (context_data_position == bitsPerChar-1) {
     context_data.push(getCharFromInt(context_data_val));
     break;
   }
   else context_data_position++;
 }
 return context_data.join('');
},

decompress: function (compressed) {
 if (compressed == null) return "";
 if (compressed == "") return null;
 return LZString._decompress(compressed.length, 32768, function(index) { return compressed.charCodeAt(index); });
},

_decompress: function (length, resetValue, getNextValue) {
 var dictionary = [],
     next,
     enlargeIn = 4,
     dictSize = 4,
     numBits = 3,
     entry = "",
     result = [],
     i,
     w,
     bits, resb, maxpower, power,
     c,
     data = {val:getNextValue(0), position:resetValue, index:1};

 for (i = 0; i < 3; i += 1) {
   dictionary[i] = i;
 }

 bits = 0;
 maxpower = Math.pow(2,2);
 power=1;
 while (power!=maxpower) {
   resb = data.val & data.position;
   data.position >>= 1;
   if (data.position == 0) {
     data.position = resetValue;
     data.val = getNextValue(data.index++);
   }
   bits |= (resb>0 ? 1 : 0) * power;
   power <<= 1;
 }

 switch (next = bits) {
   case 0:
       bits = 0;
       maxpower = Math.pow(2,8);
       power=1;
       while (power!=maxpower) {
         resb = data.val & data.position;
         data.position >>= 1;
         if (data.position == 0) {
           data.position = resetValue;
           data.val = getNextValue(data.index++);
         }
         bits |= (resb>0 ? 1 : 0) * power;
         power <<= 1;
       }
     c = f(bits);
     break;
   case 1:
       bits = 0;
       maxpower = Math.pow(2,16);
       power=1;
       while (power!=maxpower) {
         resb = data.val & data.position;
         data.position >>= 1;
         if (data.position == 0) {
           data.position = resetValue;
           data.val = getNextValue(data.index++);
         }
         bits |= (resb>0 ? 1 : 0) * power;
         power <<= 1;
       }
     c = f(bits);
     break;
   case 2:
     return "";
 }
 dictionary[3] = c;
 w = c;
 result.push(c);
 while (true) {
   if (data.index > length) {
     return "";
   }

   bits = 0;
   maxpower = Math.pow(2,numBits);
   power=1;
   while (power!=maxpower) {
     resb = data.val & data.position;
     data.position >>= 1;
     if (data.position == 0) {
       data.position = resetValue;
       data.val = getNextValue(data.index++);
     }
     bits |= (resb>0 ? 1 : 0) * power;
     power <<= 1;
   }

   switch (c = bits) {
     case 0:
       bits = 0;
       maxpower = Math.pow(2,8);
       power=1;
       while (power!=maxpower) {
         resb = data.val & data.position;
         data.position >>= 1;
         if (data.position == 0) {
           data.position = resetValue;
           data.val = getNextValue(data.index++);
         }
         bits |= (resb>0 ? 1 : 0) * power;
         power <<= 1;
       }

       dictionary[dictSize++] = f(bits);
       c = dictSize-1;
       enlargeIn--;
       break;
     case 1:
       bits = 0;
       maxpower = Math.pow(2,16);
       power=1;
       while (power!=maxpower) {
         resb = data.val & data.position;
         data.position >>= 1;
         if (data.position == 0) {
           data.position = resetValue;
           data.val = getNextValue(data.index++);
         }
         bits |= (resb>0 ? 1 : 0) * power;
         power <<= 1;
       }
       dictionary[dictSize++] = f(bits);
       c = dictSize-1;
       enlargeIn--;
       break;
     case 2:
       return result.join('');
   }

   if (enlargeIn == 0) {
     enlargeIn = Math.pow(2, numBits);
     numBits++;
   }

   if (dictionary[c]) {
     entry = dictionary[c];
   } else {
     if (c === dictSize) {
       entry = w + w.charAt(0);
     } else {
       return null;
     }
   }
   result.push(entry);

   // Add w+entry[0] to the dictionary.
   dictionary[dictSize++] = w + entry.charAt(0);
   enlargeIn--;

   w = entry;

   if (enlargeIn == 0) {
     enlargeIn = Math.pow(2, numBits);
     numBits++;
   }

 }
}
};
return LZString;
})();

if (typeof define === 'function' && define.amd) {
define(function () { return LZString; });
} else if( typeof module !== 'undefined' && module != null ) {
module.exports = LZString
} else if( typeof angular !== 'undefined' && angular != null ) {
angular.module('LZString', [])
.factory('LZString', function () {
 return LZString;
});
}