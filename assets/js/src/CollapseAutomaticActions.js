KB.on('dom.ready', function () {
    $(document).on('click','.same-category-header', function() {

        // declare the IDs
        var same_actions = '#same-' + $(this).attr('data-toggle-type') + '-body_' +  $(this).attr('data-toggle-id');
        var toggle_icon = '#same-' + $(this).attr('data-toggle-type') + '-toggle-icon_' +  $(this).attr('data-toggle-id');
        // get the show/hide-messages
        //var title_show = $(this).attr('title_show');
        //var title_hide = $(this).attr('title_hide');

        // let's toggle the div-container
        $(same_actions).slideToggle(200, function(){
            // after toggling we'll have to change some attributes of the icon
            //alert('Toggled it ...');
            if ($(same_actions).is(':visible')) {
                $(toggle_icon).attr('class', 'fa fa-caret-down actions-toggle-icon');
                //$(iconId).attr('title', title_hide);

            } else {
                $(toggle_icon).attr('class', 'fa fa-caret-right actions-toggle-icon');
                //$(iconId).attr('title', title_show);
            }
        });
      });
});
