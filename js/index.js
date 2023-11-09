

$(document).ready(function() {

    // AWAL RELOAD
    $('.sub-link-nav').hide();
    $('#form-add-wrap').hide();
    $('#form-edit-wrap').hide();

    // DROPDOWN CLICKED
    $('.dropdown').click(function() {
        var index = $('.dropdown').index(this);
        $('.sub-link-nav').eq(index).toggle(100);
    });

    // ADD BUTTON TO OPEN FORM ADD
    $('#add-btn').click(function(){
        $('#form-add-wrap').show(200);
    });
    // CLOSE FORM
    $("#close-icon-add").click(function(){
        $('#form-add-wrap').hide(200);
    });

    
  });

