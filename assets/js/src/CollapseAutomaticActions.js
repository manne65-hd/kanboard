KB.on('dom.ready', function () {
    $(document).on('click','.same-category-header', function() {

        // declare the IDs
        var same_actions  = '#same-' + $(this).attr('data-toggle-type') + '-body_' +  $(this).attr('data-toggle-id');
        var toggle_header = '#same-' + $(this).attr('data-toggle-type') + '-toggle-header_' +  $(this).attr('data-toggle-id');
        var toggle_icon   = '#same-' + $(this).attr('data-toggle-type') + '-toggle-icon_' +  $(this).attr('data-toggle-id');
        // get the collapse/expand-messages
        var title_collapse = $(this).attr('data-title-collapse');
        var title_expand = $(this).attr('data-title-expand');

        // let's toggle the div-container
        $(same_actions).slideToggle(200, function(){
            // after toggling we'll have to change some attributes of the icon
            //alert('Toggled it ...');
            if ($(same_actions).is(':visible')) {
                $(toggle_header).attr('title', title_collapse);
                $(toggle_header).css('color', '#ffffff');
                $(toggle_icon).attr('class', 'fa fa-caret-down actions-toggle-icon');

            } else {
                $(toggle_header).attr('title', title_expand);
                $(toggle_header).css('color', '#000000');
                $(toggle_icon).attr('class', 'fa fa-caret-right actions-toggle-icon');
            }
        });
      });
});
