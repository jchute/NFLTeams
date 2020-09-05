jQuery(document).ready(function( $ ) {

    // Add flip class when a card is clicked
    $('.nflteams-card').click( function() {

        $(this).toggleClass('flip');

    } );

    // Choose which category to diplay
    $('.nflteams-button').click( function( e ) {

        e.preventDefault();

        let target = $(this).data('value'),
            root = $(this).parents('.nflteams').first();

        // Remove the active class from buttons
        root.find( '.nflteams-button' ).removeClass( 'active' );

        // Add active class to button for possible styling by user
        $(this).addClass( 'active' );

        // For each card and title alter it's visibility based on the button that was clicked.
        root.children('.nflteams-card, .nflteams-title').each( function() {

            let data = '';

            // Determine data-attribute depending on sort request
            if ( root.hasClass( 'sort-division' ) ) {

                data = $(this).data( 'division' );

            } else if ( root.hasClass( 'sort-conference' ) ) {

                data = $(this).data( 'conference' );

            }

            // Hide all cards
            $(this).removeClass( 'show' );

            // Show desired cards
            if ( data == target ) {
                $(this).addClass( 'show' );
            }

        } );

    } )

});
