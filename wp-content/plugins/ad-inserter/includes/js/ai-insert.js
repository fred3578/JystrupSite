function ai_insert (insertion, selector, insertion_code) {
  Array.prototype.forEach.call (document.querySelectorAll (selector), function (element, index) {
    var ai_debug = typeof ai_debugging !== 'undefined';

    if (element.hasAttribute ('id')) {
      selector_string = '#' + element.getAttribute ('id');
    } else
    if (element.hasAttribute ('class')) {
      selector_string = '.' + element.getAttribute ('class').replace (new RegExp (' ', 'g'), '.');
    } else
    selector_string = '';

    var template = document.createElement ('div');
    template.innerHTML = insertion_code;

    var ai_selector_counter = template.getElementsByClassName ("ai-selector-counter")[0];
    if (ai_selector_counter != null) {
      ai_selector_counter.innerText = index + 1;
    }

    var ai_debug_name_ai_main = template.getElementsByClassName ("ai-debug-name ai-main")[0];
    if (ai_debug_name_ai_main != null) {
      ai_debug_name_ai_main.innerText = insertion.toUpperCase () + ' ' + selector + ' (' + element.tagName.toLowerCase() + selector_string + ')';
    }

    var range = document.createRange ();
    var fragment = range.createContextualFragment (template.innerHTML);

    if (insertion == 'before') {
      element.parentNode.insertBefore (fragment, element);
    } else
    if (insertion == 'after') {
      element.parentNode.insertBefore (fragment, element.nextSibling);
    } else
    if (insertion == 'prepend') {
      element.insertBefore (fragment, element.firstChild);
    } else
    if (insertion == 'append') {
      element.insertBefore (fragment, null);
    } else
    if (insertion == 'replace-content') {
      element.innerHTML = template.innerHTML;
    } else
    if (insertion == 'replace-element') {
      element.parentNode.insertBefore (fragment, element);
      element.parentNode.removeChild (element);
    }

    if (ai_debug) console.log ('AI INSERT', insertion, selector, '(' + element.tagName.toLowerCase() + selector_string + ')');
  });
}

function ai_insert_viewport (element) {

  function hasClass (element, cls) {
    if (element == null) return false;

    if (element.classList) return element.classList.contains (cls); else
      return (' ' + element.className + ' ').indexOf (' ' + cls + ' ') > - 1;
  }

  function addClass (element, cls) {
    if (element == null) return;

    if (element.classList) element.classList.add (cls); else
      element.className += ' ' + cls;
  }

  function removeClass (element, cls) {
    if (element == null) return;

    if (element.classList) element.classList.remove (cls); else
      element.className = element.className.replace (new RegExp ('(^|\\b)' + cls.split (' ').join ('|') + '(\\b|$)', 'gi'), ' ');
  }

  var ai_debug = typeof ai_debugging !== 'undefined';

  if (ai_debug) console.log ('AI VIEWPORT INSERTION:', 'class=\'' + element.getAttribute ('class') + '\'');

  var visible = !!(element.offsetWidth || element.offsetHeight || element.getClientRects().length);
  var block   = element.getAttribute ('data-block');

  if (visible) {
    var insertion_code = element.getAttribute ('data-code');
    var insertion_type = element.getAttribute ('data-insertion');
    var selector       = element.getAttribute ('data-selector');

    if (insertion_code != null) {
      if (insertion_type != null && selector != null) {

        var selector_exists = document.querySelectorAll (selector).length;

        if (ai_debug) console.log ('AI VIEWPORT VISIBLE: block', block, insertion_type, selector, selector_exists ? '' : 'NOT FOUND');

        if (selector_exists) {
          ai_insert (insertion_type, selector, b64d (insertion_code));
          removeClass (element, 'ai-viewports');
        }
      } else {
          if (ai_debug) console.log ('AI VIEWPORT VISIBLE: block', block);

          var range = document.createRange ();
          var fragment = range.createContextualFragment (b64d (insertion_code));
          element.parentNode.insertBefore (fragment, element.nextSibling);

          removeClass (element, 'ai-viewports');
        }
    }
  } else {
      if (ai_debug) console.log ('AI VIEWPORT NOT VISIBLE: block', block);

      var debug_bar = element.previousElementSibling;

      if (hasClass (debug_bar, 'ai-debug-bar') && hasClass (debug_bar, 'ai-debug-script')) {
        removeClass (debug_bar, 'ai-debug-script');
        addClass (debug_bar, 'ai-debug-viewport-invisible');
      }

      removeClass (element, 'ai-viewports');
    }
}

function b64e (str) {
  // first we use encodeURIComponent to get percent-encoded UTF-8,
  // then we convert the percent encodings into raw bytes which
  // can be fed into btoa.
  return btoa(encodeURIComponent (str).replace (/%([0-9A-F]{2})/g,
    function toSolidBytes (match, p1) {
      return String.fromCharCode ('0x' + p1);
  }));
}

function b64d (str) {
  // Going backwards: from bytestream, to percent-encoding, to original string.
  return decodeURIComponent (atob (str).split ('').map (function(c) {
    return '%' + ('00' + c.charCodeAt (0).toString (16)).slice (-2);
  }).join (''));
}


