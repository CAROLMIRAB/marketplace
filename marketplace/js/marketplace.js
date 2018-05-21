/*var $grid = $('.grid').isotope({
    itemSelector: '.filter-item',
    layoutMode : 'fitRows'
    // layout mode opti

    });*/


var $container = $('.grid')


$container.isotope({
    itemSelector: '.filter-item'
});


var $optionSets = $('#options .option-set'),
    $optionLinks = $optionSets.find('a');

$optionLinks.click(function () {
    var $this = $(this);
    // don't proceed if already selected
    if ($this.hasClass('selected')) {
        return false;
    }
    var $optionSet = $this.parents('.option-set');
    $optionSet.find('.selected').removeClass('selected');
    $this.addClass('selected');

    // make option object dynamically, i.e. { filter: '.my-filter-class' }
    var options = {},
        key = $optionSet.attr('data-option-key'),
        value = $this.attr('data-option-value');
    // parse 'false' as false boolean
    value = value === 'false' ? false : value;
    options[key] = value;
    if (key === 'layoutMode' && typeof changeLayoutMode === 'function') {
        // changes in layout modes need extra logic
        changeLayoutMode($this, options)
    } else {
        // otherwise, apply new options
        $container.isotope(options);
    }

    return false;
});


$('#categories-products .selected').addClass('active');

    $("#login-form").on("submit", function (e) {
        var postData = $(this).serialize();
        var formURL = $(this).attr("action");
        $.ajax({
            url: formURL,
            type: "POST",
            data: postData
        }).done(function (text) {
            if (text.status == 'OK') {
                $('#btn-enter').button('loading');
                alert('hola');
                //$(location).attr('href', '/');
                $('#login-modal').modal('hide');
            } else {
               // $('.alert-login').removeClass('hidden').fadeIn(1000);
                alert(text.message);
              //  $('.alert-login').fadeOut(10000);
            }
        })
        return false;
    });

$("#resgister-form #rut").mask("99999999-9");


function lineclamp() {
    var lineheight = parseFloat($('.product-description').css('line-height'));
    var articleheight = $('article').height();
    var calc = parseInt(articleheight/lineheight);
    $("p").css({"-webkit-line-clamp": "" + calc + ""});
}


$(document).ready(function() {
    lineclamp();
});

$( window ).resize(function() {
    lineclamp();
});



