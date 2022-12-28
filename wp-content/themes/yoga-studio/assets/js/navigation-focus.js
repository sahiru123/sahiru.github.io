var yoga_studio_Keyboard_loop = function (elem) {
  var yoga_studio_tabbable = elem.find('select, input, textarea, button, a').filter(':visible');
  var yoga_studio_firstTabbable = yoga_studio_tabbable.first();
  var yoga_studio_lastTabbable = yoga_studio_tabbable.last();
  yoga_studio_firstTabbable.focus();

  yoga_studio_lastTabbable.on('keydown', function (e) {
    if ((e.which === 9 && !e.shiftKey)) {
      e.preventDefault();
      yoga_studio_firstTabbable.focus();
    }
  });

  yoga_studio_firstTabbable.on('keydown', function (e) {
    if ((e.which === 9 && e.shiftKey)) {
      e.preventDefault();
      yoga_studio_lastTabbable.focus();
    }
  });

  elem.on('keyup', function (e) {
    if (e.keyCode === 27) {
      elem.hide();
    };
  });
};