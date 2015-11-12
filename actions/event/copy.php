<?php

$guid = get_input('guid');
$event = get_entity($guid);

if (!$event | !$event->canEdit()) {
    register_error(elgg_echo("InvalidParameterException:NoEntityFound"));
    forward(REFERER);
}

$new_event = new Event();
$new_event->title = $event->title . " (Kopie)";
$new_event->description = $event->description;
$new_event->container_guid = $event->container_guid;
$new_event->access_id = $event->access_id;
$new_event->save();

$fields = array(
    'shortdescription',
    'tags',
    'twitter_hash',
    'organizer',
    'organizer_rsvp',
    'comments_on',
    'location',
    'region',
    'event_type',
    'website',
    'contact_details',
    'latitude',
    'longitude',
    'venue',
    'fee',
    'start_day',
    'end_day',
    'end_time_hours',
    'end_time_minutes',
    'registration_ended',
    'show_attendees',
    'hide_owner_block',
    'notify_onsignup',
    'endregistration_day',
    'max_attendees',
    'waiting_list',
    'with_program',
    'registration_needed'
);

foreach ($fields as $field) {
    $new_event->$field = $event->$field;
}

if ($new_event->save()) {
    system_message(elgg_echo("event_manager:action:event:edit:ok"));
    forward($new_event->getURL());
} else {
    register_error(elgg_echo("event_manager:action:event:copy:error"));
    forward(REFERER);
}