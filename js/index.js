
var unsupportedBrowsers = false;
if ((navigator.userAgent.indexOf('Safari') != -1 && navigator.userAgent.indexOf('Chrome') == -1) || (navigator.userAgent.match(/MSIE\s(?!10)/))) {
  unsupportedBrowsers = true;
}

if (!Modernizr.input.placeholder) {
  Modernizr.load({
    load: [
      'http://lab.alexcican.com/minimal_signup_form/placeholder.min.js',
    ],
    complete: function(){
      $('input').placeholder();
    }
  })
}

if (unsupportedBrowsers) {
  Modernizr.load({
    load: [
      'http://lab.alexcican.com/minimal_signup_form/jquery.validate.min.js'
    ],
    complete: function(){
      $('form').find('input[required]').each(function () {
        $(this).attr('class', 'required ' + this.getAttribute('type')).removeAttr('required');
      });

      $('form').each(function () {
        $(this).validate();
      });
    }
  })
}



$('#password').keyup(function() {
  var pass = $(this).val();
  var cacheResult = checkPassStrength(pass);
})

$('#password').blur(function() {
  $('#passwordMeter').addClass('blur');
})

$('#password').focus(function() {
  if ($('#passwordMeter').hasClass('blur'))
    $('#passwordMeter').removeClass('blur');
})



function scorePassword(pass) {
  var i = pass.length,
      score = 0;
  if (i >= 7) {
    score += /[a-z]/.test(pass) ? 3 : 0;
    score += /[A-Z]/.test(pass) ? 4 : 0;
    score += /\d/.test(pass) ? 1 : 0;
    score += /[^\w\d\s]/.test(pass) ? 1 : 0;
  }
  if (i >= 22 && score >= 9)
    score += 1;

  return score;
}

function checkPassStrength(pass) {
  var score = scorePassword(pass);
  console.log(score);
  if (score < 1)
    $('#password, #passwordMeter').removeClass().addClass('weak');
  if (score >= 7)
    $('#password, #passwordMeter').removeClass().addClass('good');
  if (score >= 8)
    $('#password, #passwordMeter').removeClass().addClass('better');
  if (score >= 9)
    $('#password, #passwordMeter').removeClass().addClass('strong');
  if (score >= 10)
    $('#password, #passwordMeter').removeClass().addClass('military');
}
