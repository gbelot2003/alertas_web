 
jQuery(document).ready(function() {
    $('.edit').on('click', function(event){
        event.preventDefault();
        $.colorbox({href: $(this).attr("href")});
    });

    $("#add").colorbox();
});
