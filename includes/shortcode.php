<?php
// Function for shortcode output
function nflteams_shortcode( $parameter ) {

    // Get options and parameters
    $apikey = esc_attr( get_option( 'nflteams-apikey' ) );
    $apiurl = 'https://delivery.chalk247.com/team_list/NFL.JSON?api_key=' . $apikey;

    extract( shortcode_atts( array(

        'sort' => 'team'

    ), $parameter ) );

    // Sanitize user input
    $sort = strtolower( esc_attr( $sort ) );

    // Check if API Key has been set
    if ( !$apikey ) {
        return '<p>API Key not set within <a href="' . admin_url( 'admin.php?page=nflteams' ) . '">NFL Teams page</a>.</p>';
    }

    // Check if sort parameter was set to a known value
    if ( ! in_array( $sort, array( 'team', 'division', 'conference' ) ) ) {
        return '<p>Sort not a valid option. Please use team, division, or conference.</p>';
    }

    // Check if transient is set for cached team data. Set transient data if not.
    if ( false === get_transient( 'nflteams-data' ) ) {

        // Get JSON data from third party source
        $fetch = wp_remote_get( $apiurl );

        // Cache the data to limit server requests
        set_transient( 'nflteams-data', $fetch['body'], DAY_IN_SECONDS );

    }

    // Receive transient data
    $data = json_decode( get_transient( 'nflteams-data' ) );

    // Check if we received an error
    if ( isset( $data->results->error ) ) {

        delete_transient( 'nflteams-data' );

        return '<p>Something went wrong!<br>' . $data->results->error . '</p>';

    }

    $teams = $data->results->data->team;


    // Sort data as per shortcode parameter

    // Always sort by Name and Nickname
    $sort_parameter = array(
        'display_name' => 'ASC',
        'nickname' => 'ASC',
    );

    // Sort by Division if asked
    if ( $sort == 'division' ) $sort_parameter = array_merge( array( 'division' => 'ASC' ), $sort_parameter );

    // Sort by conference regardless if division or conference is asked
    if ( $sort != 'team' ) $sort_parameter = array_merge( array( 'conference' => 'ASC' ), $sort_parameter );

    // Apply custom sort key for division
    if ( $sort == 'division' ) {

        foreach ( $teams as $k => $v ) {

            switch( $teams[$k]->division ) {

                case 'North':
                    $teams[$k]->division = '1North';
                    break;

                case 'East':
                    $teams[$k]->division = '2East';
                    break;

                case 'South':
                    $teams[$k]->division = '3South';
                    break;

                case 'West':
                    $teams[$k]->division = '4West';
                    break;

            }

        }

    }

    // Sort list
    $teams = wp_list_sort( $teams, $sort_parameter );

    // Collect unique categories
    $cats = array();

    // Cleanup and Data Collection
    foreach ( $teams as $k => $v ) {

        // Remove custom sort key from division
        if ( $sort == 'division' ) {
            $teams[$k]->division = substr( $teams[$k]->division, 1 );
        }

        // Collect each unique conference
        if ( 'conference' == $sort and ! in_array( $teams[$k]->conference, $cats ) ) {
            $cats[] = $teams[$k]->conference;
        }

        // Collect each unique divisions
        else if ( 'division' == $sort and ! in_array( $teams[$k]->division, $cats ) ) {
            $cats[] = nflteams_initialism( $teams[$k]->conference ) . ' ' . $teams[$k]->division;
        }

    }

    $cats = array_unique( $cats );


    // Build card output
    ob_start();

    echo '<section class="nflteams sort-' . $sort . '">';

    // Show controls if categories are set
    if ( count( $cats ) ) {

        echo '<div class="controls">';

        foreach ( $cats as $v ) {

            $class = 'nflteams-button';

            if ( $v == $cats[0] ) {

                $class .= ' active';

            }

            echo '<a href="#" class="' . $class . '" data-value="' . $v . '">' . $v . '</a>';

        }

        echo '</div>';
    }

    foreach ( $teams as $team ) {

        // Stylized division name
        $full_division = nflteams_initialism( $team->conference ) . ' ' . $team->division;

        // Variable for whether or not to show item by default
        $check_show = ( $team->conference == $cats[0] or $full_division == $cats[0] );

        // Section title variable
        $title = ( 'division' == $sort ) ? $full_division : ( ( 'conference' == $sort ) ? $team->conference : '' );

        // Output title. Titles only need to be shown once.
        if ( $title and ( ! isset ( $title_flag ) or $title_flag != $title ) ) {

            $title_flag = $title;

            echo '<h3 class="nflteams-title ';

            if ( $check_show ) echo 'show';

            echo '" data-conference="' . $team->conference . '"';
            echo '" data-division="' . $full_division . '"';
            echo '>';
            echo $title;
            echo '</h3>';
        }

        ?>

        <article class="nflteams-card <?php if ( $check_show ) : echo 'show'; endif; ?>" data-conference="<?php echo $team->conference; ?>" data-division="<?php echo $full_division; ?>">

            <div class="inner">

                <div class="face">

                    <?php if ( $team->display_name or $team->nickname ) : ?>
                        <p class="team-name">
                            <?php if ( $team->display_name ) : ?><span class="display-name"><?php echo $team->display_name; ?></span><?php endif; ?>
                            <?php if ( $team->nickname ) : ?><span class="nickname"><?php echo $team->nickname; ?></span><?php endif; ?>
                        </p>
                    <?php endif; ?>

                </div>

                <div class="face">

                    <?php if ( $team->conference ) : ?>
                        <p class="conference">
                            <strong>Conference:</strong>
                            <span><?php echo $team->conference; ?></span>
                        </p>
                    <?php endif; ?>

                    <?php if ( $team->division ) : ?>
                        <p class="division">
                            <strong>Division:</strong>
                            <span><?php echo $team->division; ?></span>
                        </p>
                    <?php endif; ?>

                </div>

            </div>

        </article>

        <?php
    }

    echo '</section>';

    return ob_get_clean();

}
add_shortcode( 'nflteams', 'nflteams_shortcode' );
