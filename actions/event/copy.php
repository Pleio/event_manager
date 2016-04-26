<?php

$guid = get_input('guid');
$event = get_entity($guid);

if (!$event | !$event->canEdit()) {
    register_error(elgg_echo("InvalidParameterException:NoEntityFound"));
    forward(REFERER);
}

$new_event = clone $event;
$new_event->title = $event->title . " (Kopie)";
$new_event->save();

if (!$new_event->save()) {
    register_error(elgg_echo("event_manager:action:event:copy:error"));
    forward(REFERER);
}

foreach ($event->getEventDays() as $day) {
    $new_day = clone $day;
    $new_day->save();
    $new_day->addRelationship($new_event->guid, 'event_day_relation');

    foreach ($day->getEventSlots() as $slot) {
        $new_slot = clone $slot;
        $new_slot->save();
        $new_slot->addRelationship($new_day->guid, 'event_day_slot_relation');
    }
}

foreach ($event->getRegistrationFormQuestions() as $question) {
    $new_question = clone $question;
    $new_question->save();
    $new_question->addRelationship($new_event->guid, 'event_registrationquestion_relation');
}

system_message(elgg_echo("event_manager:action:event:edit:ok"));
forward($new_event->getURL());