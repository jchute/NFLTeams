<?php

// Helper function to grab initalism of a string
function nflteams_initialism( $str ) {

    $return = '';

    // Obtain each unique word
    $arr = explode( ' ', $str );

    // Store first letter for return;
    foreach ( $arr as $v ) {

        $return .= strtoupper( $v[0] );

    }

    return $return;

}
