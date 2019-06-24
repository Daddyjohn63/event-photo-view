<?php

add_action( 'wp_enqueue_scripts', 'my_enqueue_assets' );
function my_enqueue_assets() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
}

//FOR EXCERPT CHANGE IN PHOTO VIEW
function word_count($string, $limit) {
 
	$words = explode(' ', $string);
	 
	return implode(' ', array_slice($words, 0, $limit));
	 
	}

//TARGETS MUBER OF TICKETS AND REPLACES WITH PLACES
add_filter( 'tribe_tickets_buy_button', 'changes_button_text', 11, 2 );

function changes_button_text( $html ) {

	$html = str_replace("tickets left", "places left", $html);
	$html = str_replace("ticket left", "place left", $html);                                                                                                                                                       
    return $html;
}

/*
 * EXAMPLE OF CHANGING ANY TEXT (STRING) IN THE EVENTS CALENDAR
 * See the codex to learn more about WP text domains:
 * http://codex.wordpress.org/Translating_WordPress#Localization_Technology
 * Example Tribe domains: 'tribe-events-calendar', 'tribe-events-calendar-pro'...
 */
function tribe_custom_theme_text ( $translations, $text, $domain ) {
 
// Put your custom text here in a key => value pair
// Example: 'Text you want to change' => 'This is what it will be changed to'
// The text you want to change is the key, and it is case-sensitive
// The text you want to change it to is the value
// You can freely add or remove key => values, but make sure to separate them with a comma
// This example changes the label "Venue" to "Location", and "Related Events" to "Similar Events"
$custom_text = array(
		'Photo' => 'Grid',
		'Month' => 'Calendar',
);
 
// If this text domain starts with "tribe-" or "the-events-", and we have replacement text
if((strpos($domain, 'tribe-') === 0 || strpos($domain, 'the-events-') === 0 || strpos($domain, 'event-') === 0) && array_key_exists($text, $custom_text) ) {
	$text = $custom_text[$text];
}

return $text;
}
add_filter('gettext', 'tribe_custom_theme_text', 20, 3);




//CHANGE UPCOMING EVENTS TO UPCOMING COURSES
add_filter('tribe_get_events_title', 'change_upcoming_events_title');
 
function change_upcoming_events_title($title) {
    // Safe detection of photo/map views (in case PRO is not installed or becomes deactivated)
    $tribe_is_map   = function_exists( 'tribe_is_map' ) && tribe_is_map();
    $tribe_is_photo = function_exists( 'tribe_is_photo' ) && tribe_is_photo(); 
 
    // We'll change the title on upcoming, map and photo views
    if ( tribe_is_upcoming() or $tribe_is_map or $tribe_is_photo ) return 'Upcoming Courses';
 
    // In all other circumstances, leave the original title in place
    return $title;
}


/** FILTER TO CHNAGE THE LABEL EVENT TO COURSE AND PLURAL TOO
*/
add_filter( 'tribe_event_label_singular', 'event_display_name' );
function event_display_name() {
	return 'Course';
}

add_filter( 'tribe_event_label_plural', 'event_display_name_plural' );
function event_display_name_plural() {
	return 'Courses';
}



