
function fixNavbar() {
  var  $totop       = $('.backtotop'),
       $nav        = $('nav.fixedtop'),
       totop = 200,
       offset     = 0,
       logoHeight = 56,
       distance   = offset + logoHeight,
       scroll     = $(window).scrollTop();

  if (scroll >= distance) {
    $nav.css({
      'position': 'fixed',
      'top':      '0',
      'right':    '0',
      'left':     '0'
    });
  } else {
    $nav.css({
      'position': 'relative',
      'top':      'auto',
      'right':    'auto',
      'left':     'auto'
    });
  }

  if (scroll >= totop) {
    $totop.css({
      'display': 'inline-block',
    });
  } else {
    $totop.css({
      'display': 'none',
    });
  }
}

function fixNavbar_backup() {
   
    // $(window).bind('mousewheel DOMMouseScroll onmousewheel touchmove scroll', function(event) {
    //     if (event.originalEvent.wheelDelta >= 0) {
    //         //console.log('Scroll up');
    //         $("body").addClass("fixedtopbar");
    //     }
    //     else {
    //        // console.log('Scroll down');
    //         $("body").removeClass("fixedtopbar");
    //     }
    // });

  var  $totop       = $('.backtotop'),
       $nav        = $('nav.fixedtop'),
       totop = 200,
       offset     = 0,
       logoHeight = 56,
       distance   = offset + logoHeight,
       scroll     = $(window).scrollTop();


  if (scroll >= totop) {
    $totop.css({
      'display': 'inline-block',
    });
  } else {
    $totop.css({
      'display': 'none',
    });
  }
}

$(document).ready(function(){
    $(document).on( 'click', '.backtotop', function (e){
         $("HTML, BODY").animate({ scrollTop: 0 }, 400, 'swing');
    });
});

$(window).scroll( function() {
  fixNavbar();
});
