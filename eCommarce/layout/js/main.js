$(function ()
{
        'use strict';
        //hide placeholder on form focus
        $('[placeholder]').focus(function () {
            $(this).attr('data-text', $(this).attr('placeholder'));
            $(this).attr('placeholder', '');
        }).blur(function () {
            $(this).attr('placeholder', $(this).attr('data-text')); 
        });
    
        //Add astrisk on requierd filed
    $('input').each(function () {
            if ($(this).attr('required') === 'required') {
                $(this).after('<span class="asterisk">*</span>');
            }
        });

    //switch btween login and signup
    $('.reg-link').click(function () {
        $('.login-container').hide();
        $('.signup-container').show();
    });

    $('.login-link').click(function () {
        $('.login-container').show();
        $('.signup-container').hide();
    });

    //add new ad
    $('.live').keyup(function () {
        $($(this).data('class')).text($(this).val());
    });
    //show img directly im box
    $('.item-img').change(function (event) {
        var url = URL.createObjectURL(event.target.files[0]);
        $('.uplode-image').attr("src", url);
    });
      
   
    

});