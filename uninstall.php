<?php

// Clear up stored data
delete_option( 'nflteams-apikey' );
unregister_setting( 'nflteams', 'nflteams-apikey' );
delete_transient( 'nflteams-data' );
