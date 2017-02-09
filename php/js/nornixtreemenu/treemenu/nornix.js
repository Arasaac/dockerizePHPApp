/**
 * Namespace for Nornix JavaScript functions.
 * @type Object
 */
var Nornix = {};

/**
 * Function to add events to objects.
 * @see http://www.quirksmode.org/blog/archives/2005/10/_and_the_winner_1.html
 * @see http://ejohn.org/projects/flexible-javascript-events/
 * @see http://dean.edwards.name/weblog/2005/12/js-tip1
 * @param {Object} obj object to add the event to
 * @param {String} type event type, like "load", "click"
 * @param {Function} fn the function that should be run when the event fires
 * @param {boolean} capture if true, indicates that the user wishes to initiate capture
 * @member event
 */
Nornix.addEvent = function ( obj, type, fn, capture ) {};
/**
 * Function to remove events from objects.
 * You should use the same parameters as in {@link event#addEvent} to remove the same event listener.
 * @see http://www.quirksmode.org/blog/archives/2005/10/_and_the_winner_1.html
 * @see http://ejohn.org/projects/flexible-javascript-events/
 * @see http://dean.edwards.name/weblog/2005/12/js-tip1
 * @param {Object} obj object to add the event to
 * @param {String} type event type, like "load", "click"
 * @param {Function} fn the function that should be run when the event fires
 * @param {boolean} capture if true, indicates that the user wishes to initiate capture
 * @member event
 */
Nornix.removeEvent = function ( obj, type, fn, capture ) {};


if (document.addEventListener)
{
	Nornix.addEvent = function ( obj, type, fn, capture )
	{
		obj.addEventListener( type, fn, capture );
	};
	Nornix.removeEvent = function ( obj, type, fn, capture )
	{
		obj.removeEventListener( type, fn, capture );
	};
}
else if (document.attachEvent)
{
	Nornix.addEvent = function( obj, type, fn )
	{
		obj["e"+type+fn] = fn;
		obj[type+fn] = function()
		{
			var e = window.event;
			e.target = window.event.srcElement;
			obj["e"+type+fn]( e );
		};
		obj.attachEvent( "on"+type, obj[type+fn] );
	};
	Nornix.removeEvent = function( obj, type, fn )
	{
		obj.detachEvent( "on"+type, obj[type+fn] );
		obj[type+fn] = null;
		obj["e"+type+fn] = null;
	};
}
else
{
	// sorry, no support!
	Nornix.addEvent = Function;
	Nornix.removeEvent = Function;
}

/**
 * Function to stop normal browser action on events.
 * Function you can call within your event handlers to stop them performing
 * the normal browser action or kill the event entirely.
 * @see http://www.twinhelix.com
 * @param {Event} e the event object
 * @param {boolean} c set to true to cancel event bubbling
 * @member event
 */
Nornix.cancelEvent = function(e, c)
{
	e.returnValue = false;
	if (e.preventDefault) e.preventDefault();
	if (c)
	{
		e.cancelBubble = true;
		if (e.stopPropagation) e.stopPropagation();
	}
};

/**
 * Function to run an initialization after an element
 * has became available in the DOM.
 *
 * The element will be sent to the initializing function as an object.
 *
 * @param {String} id ID of element to wait for
 * @param {Function} initFunc the function that should be run when the element is available
 * @param {number} interval time in milliseconds
 * @member event
 */
Nornix.delayedInit = function (id, initFunc, interval)
{
	var el;
	if (interval === undefined) interval = 10;
	var intervalId = window.setInterval( function ()
		{
			if (el = document.getElementById(id))
			{
				window.clearInterval(intervalId);
				initFunc(el);
			}
		},
		interval
	);
};

/**
 * Function to create a browser cookie.
 * @param {String} name name of cookie
 * @param {String} value value of cookie
 * @param {Number} days number of days browser should save the cookie
 * @member cookie
 */
Nornix.createCookie = function (name, value, days)
{
	var expire;
	if (days)
	{
		var date = new Date();
		date.setTime(date.getTime()+(days*24*60*60*1000));
		expire = "; expires="+date.toGMTString();
	}
	else
	{
		expire = "";
	}
	document.cookie = name+"="+value+expire+"; path=/";
};

/**
 * Function to read a browser cookie.
 * @param {String} name name of cookie
 * @member cookie
 * @return value of cookie
 * @type String
 */
Nornix.readCookie = function (name)
{
	var nameEQ = name + "=";
	var ca = document.cookie.split(';'), i = 0, c;
	while (c = ca[i++])
	{
		c = Nornix.trim(c);
		if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length);
	}
	return '';
};

/**
 * Function to erase a browser cookie.
 * @param {String} name name of cookie
 * @member cookie
 */
Nornix.eraseCookie = function (name)
{
	createCookie(name, "", -1);
};

/**
 * Function that reads the text content of a DOM node.
 * IE FIX for .textContent
 * @param {Node} node DOM node to get text content from
 * @return text content of node
 * @type String
 */
Nornix.getTextContent = function (node)
{
	if (typeof node.textContent != "undefined")
	{
		return node.textContent;
	}
	else
	{
		return node.innerText;
	}
};

/**
 * String function that removes whitespace from the start and end of a string.
 * @param {String} s the string to use
 * @return the string with whitespace removed
 * @type String
 */
Nornix.trim = function (s)
{
	return s.replace(/^\s*|\s*$/g, "");
};

/**
 * Function to swap, remove or add a class name on an object.
 * @param {HTMLElement} el the object to work on
 * @param {String} oldstr the old class -- set to null to add class
 * @param {String} newstr the new class -- leave empty to remove class
 */
Nornix.swapClasses = function (el, oldstr, newstr)
{
	if (!el) return;
	if (el.className.length === 0)
	{
		el.className = newstr ? newstr : "";
		return;
	}
	var arr = el.className.split(" "), i = 0, t;
	while (t = arr[i++])
	{
		if (t === oldstr)
		{
			if (newstr)
			{
				arr[i-1] = newstr;
				el.className = arr.join(" ");
				return;
			}
			else
			{
				delete arr[i-1];
				el.className = arr.join(" ");
				return;
			}
		}
		else if (t === newstr)
		{
				el.className = arr.join(" ");
				return;
		}
	}
	if (newstr) arr[arr.length] = newstr;
	el.className = arr.join(" ");
};

Nornix.addClass = function (el, className)
{
	return Nornix.swapClasses(el, null, className);
};

Nornix.removeClass = function (el, className)
{
	return Nornix.swapClasses;
}(); // create alias for swapClasses()


/**
 * Check if class exists on element.
 * @param {HTMLElement} el the object to work on
 * @param {String} s class name
 * @return true if the class exists
 */
Nornix.containsClass = function (el, s)
{
	if (!el || !el.className) return false;
	var arr = el.className.split(" "), i = 0, t;
	while (t = arr[i++])
	{
		if (t === s) return true;
	}
	return false;
};

/**
 * True when browser is Internet Exlorer.
 * @type boolean
 */
Nornix.isIe = document.all && window.opera === undefined;


/**
 * Check if node name of element is equal to a string.
 * @param {HTMLElement} el the object to work on
 * @param {String} nodeName
 * @return true if the node name is equivalent
 */
Nornix.eqNodeName = function  (el, nodeName)
{
	if (el && el.nodeName && el.nodeName.toLowerCase() === nodeName)
	{
		return true;
	}
	return false;
};


/**
 * Find first or last children of element type.
 * @param {HTMLElement} nodes node, which children nodes will be searched
 * @param {String} nodeName type of HTML element we are looking for
 * @param {Function} nodeAction closure for action to execute
 * @param {boolean} backwards search from the end of the child list when true
 * @return value of action closure.
 */
Nornix.findChildOfType = function (nodes, nodeName, nodeAction, backwards)
{
	var e;
	if (!backwards)
	{
		var i = 0;
		while (e = nodes.childNodes[i++])
		{
			if (Nornix.eqNodeName(e, nodeName))
			{
				return nodeAction(e);
			}
		}
	}
	else
	{
		var i = nodes.childNodes.length - 1;
		while (e = nodes.childNodes[i--])
		{
			if (Nornix.eqNodeName(e, nodeName))
			{
				return nodeAction(e);
			}
		}
	}
};

/**
 * Preload images for faster rendering.
 * @param {Array} imgs array of image file names
 * @param {String} imgPath path to image files
 */
Nornix.imagePreload = function (imgs, imgPath)
{
	var i = 0, img;
	if (!imgPath) imgPath = "";
	while (img = imgs[i++])
	{
		(new Image()).src = imgPath + img; // no need to keep the images!
	}
};

/**
 * Create static copy of a live collection.
 * This makes it much faster to work with the elements.
 * @param {HTMLCollection} collection a live collection
 * @return static copy of the live collection
 */
Nornix.live2copy = function (collection)
{
	var elements = [], i = 0, el;
	while (el = collection[i++])
	{
		elements[elements.length] = el;
	}
	return elements;
}

/**
 * Get position of node.
 * @param {HTMLElement} obj the object to work on
 * @return absolute position as .x and .y of return value.
 */
Nornix.getPos = function (obj)
{
	var pos = {x: obj.offsetLeft || 0, y: obj.offsetTop || 0};
	while (obj = obj.offsetParent)
	{
		pos.x += obj.offsetLeft || 0;
		pos.y += obj.offsetTop || 0;
	}
	return pos;
};

/**
 * Get current style of element.
 * @param {HTMLElement} el element to get the style from
 * @param {String} styleProp CSS style propterty to fetch
 * @return current setting of style property
 */
Nornix.getElementStyle = function (el, styleProp)
{
	if (window.getComputedStyle)
	{
		return function (el, styleProp)
		{
			return window.getComputedStyle(el, "").getPropertyValue(styleProp);
		};
	}
	return function (el, styleProp)
	{
		return el.currentStyle ? el.currentStyle[Nornix.cssProp2JsProp(styleProp)] : null;
	};
}();

/**
 * Transform a CSS property to a JS property
 * @param {String} p valid CSS property
 * @return JS property name 
 */
Nornix.cssProp2JsProp = function (p)
{
	var arr = p.split("-");
	if (arr.length > 1)
	{
		var sum = arr[0], i = 1, part;
		while (part = arr[i++])
		{
			sum += part.charAt(0).toUpperCase() + part.substr(1);
		}
		return sum;
	}
	return p;
};

/**
 * Get background color of element.
 * @param {HTMLElement} el element to get the background color from
 * @return color as an object like {r: XX, g: XX, b: XX} or undefined
 */
Nornix.getBackgroundColor = function (el)
{
	var c = Nornix.getElementStyle(el, "background-color");
	if (c === undefined || c === "" || c === "transparent") return null;
	return Nornix.convert2Rgb(c);
};

/**
 * Get text color of element.
 * @param {HTMLElement} el element to get the text color from
 * @return color as an object like {r: XX, g: XX, b: XX} or undefined
 */
Nornix.getTextColor = function (el)
{
	var c = Nornix.getElementStyle(el, "color");
	if (c === undefined || c === "" || c === "transparent") return null;
	return Nornix.convert2Rgb(c);
};

/**
 * Convert rgb(r,g,b) string to a {r,g,b} object
 * @param {String} c rgb(r,g,b) string
 * @return a {r,g,b} object
 */
Nornix.convert2Rgb = function (c)
{
	var rgb = c.match(/rgb\s*\(\s*(\d{1,3})\s*,\s*(\d{1,3})\s*,\s*(\d{1,3})\s*\)/);
	if (rgb)
	{
		return {r : parseInt(rgb[1]), g : parseInt(rgb[2]), b : parseInt(rgb[3])};
	}
	return Nornix.makeRgbColor(c);
};


/**
 * Create string representation of RGB color information.
 * @param {Object} rgb color information like {r: 23.342, g: 12.372, b: 34}
 * @return string like rgb(23, 12, 34)
 */
Nornix.printRgbColor = function (rgb)
{
	return "rgb(" + Math.round(rgb.r) + "," + Math.round(rgb.g) + "," + Math.round(rgb.b) + ")";
};

/**
 * Create RGB color object from hexadecimal string represenation.
 * @param {String} color, must begin with "#", then 3 or 6 hexadecimal digits.
 * @return color as RGB object like {r: XX, g: XX, b: XX} or undefined
 */
Nornix.makeRgbColor = function (c)
{
	if (c.charAt(0) === "#")
	{
		if (c.length === 4)
		{
			c = "#" + c.charAt(1) + c.charAt(1) + c.charAt(2) + c.charAt(2) + c.charAt(3) + c.charAt(3);
		}
		if (c.length === 7)
		{
			return {
				r : parseInt(c.substr(1, 2), 16),
				g : parseInt(c.substr(3, 2), 16),
				b : parseInt(c.substr(5, 2), 16)
				};
		}
	}
};

/**
 * Fade element from current background color to fade color and back.
 *
 */
Nornix.fader = function (el, className, fps, durationIn, durationOut)
{
	if (!fps) fps = 30;
	if (!durationIn) durationIn = 200;
	if (!durationOut) durationOut = 1500;
	if (!className) className = "fader";

	var toColor = Nornix.getBackgroundColor(el);
	var toColorCopy = {r : toColor.r, g : toColor.g, b : toColor.b};
	var toTextColor = Nornix.getTextColor(el);
	var toTextColorCopy = {r : toTextColor.r, g : toTextColor.g, b : toTextColor.b};

	// get colors from CSS
	var div = document.createElement("div");
	Nornix.addClass(div, className);
	document.documentElement.appendChild(div); // IE(7) fix
	var fromColor = Nornix.getBackgroundColor(div);
	var fromTextColor = Nornix.getTextColor(div);
	document.documentElement.removeChild(div);
	div = null;

	var oldBackgroundColor = el.style.backgroundColor;
	var oldTextColor = el.style.color;

	Nornix.fade(el,
	[
		{"property" : "background-color", "toColor" : fromColor,     "fromColor" : toColorCopy},
		{"property" : "color",            "toColor" : fromTextColor, "fromColor" : toTextColorCopy}
	],
	fps,
	durationIn,
	function () // function to run on stop
	{
		Nornix.fade(el,
		[
			{"property" : "background-color", "toColor" : toColor,     "fromColor" : fromColor,
			 "oldStyle" : oldBackgroundColor},
			{"property" : "color",            "toColor" : toTextColor, "fromColor" : fromTextColor,
			 "oldStyle" : oldTextColor}
		],
		fps,
		durationOut
		);
	});
};

/**
 * Fade element from one color to another.
 */
Nornix.fade = function (el, fades, fps, duration, stopFunc)
{
	if (!fps) fps = 30;
	if (!duration) duration = 3000;

	var framesCount = Math.round(fps * duration / 1000);
	var interval = Math.round(duration / framesCount);
	var frame = 0;

	var aFade, i = 0;
	//  IN: property, toColor, fromColor, oldStyle
	//  PREPARE: jsPorperty, step
	while (aFade = fades[i++])
	{
		if (!aFade.property) aFade.property = "background-color";
		aFade.jsProperty = Nornix.cssProp2JsProp(aFade.property);
		aFade.step = {
			r : (aFade.toColor.r - aFade.fromColor.r) / framesCount,
			g : (aFade.toColor.g - aFade.fromColor.g) / framesCount,
			b : (aFade.toColor.b - aFade.fromColor.b) / framesCount
		};
	}

	var intervalId = window.setInterval( function ()
		{
			if (++frame !== framesCount)
			{
				i = 0;
				while (aFade = fades[i++])
				{
					el.style[aFade.jsProperty] = Nornix.printRgbColor(aFade.fromColor);
					aFade.fromColor.r += aFade.step.r;
					aFade.fromColor.g += aFade.step.g;
					aFade.fromColor.b += aFade.step.b;
				}
			}
			else
			{
				window.clearInterval(intervalId);
				if (stopFunc)
				{
					stopFunc();
				}
				else
				{
					// only set old styles after the last link in the chain
					i = 0;
					while (aFade = fades[i++])
					{
						el.style[aFade.jsProperty] = aFade.oldStyle;
					}
				}
			}
		},
		interval
	); // end setInterval
};

