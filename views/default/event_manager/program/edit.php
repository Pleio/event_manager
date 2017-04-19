<?php 

	$event = $vars["entity"];
	$register_type = $vars["register_type"];
	
	if (!empty($event) && ($event instanceof Event)) {
		if ($event->with_program) {
			if ($eventDays = $event->getEventDays()) {
				foreach ($eventDays as $key => $day) {					
					$day_title = date(EVENT_MANAGER_FORMAT_DATE_EVENTDAY, $day->date);
					if ($description = $day->description) {
						$day_title = $description;
					}
					
					$tabtitles .= "<a href='javascript:void(0);' rel='day_" . $day->getGUID() . "'>" . $day_title . "</a>";
					
					$tabcontent .= elgg_view("event_manager/program/elements/day", array("title" => $day_title, "entity" => $day, "selected" => true, 'participate' => true, 'register_type' => $register_type));
				}
			}
			
			$program .= elgg_view('input/hidden', array('id' => 'event_manager_program_guids', 'name' => 'program_guids'));
			
			$program .= $tabcontent;
			
			$slot_sets = elgg_get_metadata(array(
					"type" => "object",
					"subtype" => EventSlot::SUBTYPE,
					"container_guids" => array($event->getGUID()),
					"metadata_names" => array("slot_set"),
					"count" => true
			));
			
			if ($slot_sets > 0) {
				$program .= "<span class='elgg-subtext'>" . elgg_echo("event_manager:slots:explanation") .  "</span>";
			}

			if ($event->require_slots === "1") {
				$program .= " <span class='elgg-subtext'>" . elgg_echo("event_manager:slots:required") . "</span>";
			}
			
			echo elgg_view_module("info", elgg_echo('event_manager:event:program'), $program);
		}
	}	