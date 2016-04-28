<?php
set_time_limit(60*10);

elgg_make_sticky_form('event_mail');

$guid = get_input('guid');
$event = get_entity($guid);

if (!$event || !$event->canEdit()) {
    register_error(elgg_echo('InvalidParameterException:GUIDNotFound', array($guid)));
    forward(REFERER);
}

$subject = get_input('subject');
if (!$subject) {
    register_error(elgg_echo('event_manager:mail:subject_missing'));
    forward(REFERER);
}

$message = get_input('message');
if (!$message) {
    register_error(elgg_echo('event_manager:mail:message_missing'));
    forward(REFERER);
}

$site = elgg_get_site_entity();

$from = $site->email;
if (empty($from)) {
    $from = "noreply@" . get_site_domain($site->getGUID());
}

if (!empty($site->name)) {
    $site_name = $site->name;
    if (strstr($site_name, ',')) {
        $site_name = '"' . $site_name . '"'; // Protect the name with quotations if it contains a comma
    }

    $site_name = '=?UTF-8?B?' . base64_encode($site_name) . '?='; // Encode the name. If may content nos ASCII chars.
    $from = $site_name . " <" . $from . ">";
}

$send_type = get_input('send_type');
if ($send_type == elgg_echo('event_manager:mail:send_test')) {
    $current_user = elgg_get_logged_in_user_entity();
    elgg_send_email($from, $current_user->email, "[TEST] " . $subject, $message);
    system_message(elgg_echo('event_manager:mail:test_messages_sent'));
    forward(REFERER);

} else {
    $i = 0;
    foreach ($event->exportAttendees() as $attendee) {
        elgg_send_email($from, $attendee->email, $subject, $message);
        $i++;
    }

    elgg_clear_sticky_form('event_mail');
    system_message(elgg_echo('event_manager:mail:messages_sent', array($i)));
    forward($event->getURL());
}
