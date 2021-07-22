window.$=jQuery;
$(document).ready(function(){
    $('.tablink').on('click', function(){
        $target = $(this).data('target');

        $('.tablink').removeClass('active');
        $(this).addClass('active');

        $('.tabcontent').css('display','none');
        $(`#${$target}`).css('display', 'block');
    });

    $('.tablink:first').trigger('click');
});