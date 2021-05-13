KB.on('dom.ready', function () {
    $(document).on('click','.sameActionsToggleIcon', function() {

        alert('You clicked!');
        // declare the IDs
        //var iconId = '#aco_icon_' + $(this).attr('data-toggle-type') + $(this).attr('data-toggle-id');
        var same_actions = '#same_' + $(this).attr('data-toggle-type') + $(this).attr('data-toggle-id');
        alert(same_actions);
        // get the show/hide-messages
        //var title_show = $(this).attr('title_show');
        //var title_hide = $(this).attr('title_hide');

        // let's toggle the textbox
        $(same_actions).slideToggle(200, function(){
            // after toggling we'll have to change some attributes of the icon
            if ($(same_actions).is(':visible')) {
                //$(iconId).css('opacity', '0.5');
                //$(iconId).attr('title', title_hide);

            } else {
                //$(iconId).css('opacity', '1.0');
                //$(iconId).attr('title', title_show);
            }
        });
      });
});
