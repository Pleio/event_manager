<?php
$guid = (int) get_input('guid');
$group_guid = (int) get_input('group_guid');
$add_to_site = (int) get_input('add_to_site');

if ($guid) {
    $event = get_entity($guid);
}

if (!$event || !elgg_instanceof($event, "object", "event") || !$event->canEdit()) {
    register_error('InvalidParameterException:NoEntityFound');
    forward(REFERER);
}

if ($group_guid) {
    $group = get_entity($group_guid);
}

if (!$group || !elgg_instanceof($group, "group") || !$group->canEdit()) {
    register_error('event_manager:add_attendees_to_group:no_group');
    forward(REFERER);
}

if ($add_to_site && elgg_is_admin_logged_in()) {
    $add_to_site = true;
} else {
    $add_to_site = false;
}

$site = elgg_get_site_entity();

$added_group = 0;
$added_site = 0;

foreach ($event->exportAttendees() as $attendee) {
    if ($attendee instanceof ElggUser) {
        $user = $attendee;
        $password = null;
    } elseif ($attendee instanceof EventRegistration) {
        $hidden = access_get_show_hidden_status();
        access_show_hidden_entities(true);
        $users = get_user_by_email($attendee->email);
        access_show_hidden_entities($hidden);

        if (count($users) > 0) {
            $user = $users[0];
        } else {
            list($user, $password) = event_manager_register_attendee($attendee);
        }
    }

    if (!$user) {
        continue;
    }

    if ($add_to_site && !$site->isUser($user->guid)) {
        $site->addUser($user->guid);
        $added_site++;
    }

    if (!$group->isMember($user)) {
        $group->join($user);
        event_manager_add_to_group_send_notification($user, $group, $password);
        $added_group++;
    }
}

system_message(elgg_echo('event_manager:add_attendees_to_group:added', array($added_group, $added_site)));
forward($event->getURL());