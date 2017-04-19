<?php 

	$event = $vars["entity"];
	$tabtitles = '';
	$tabcontent = '';
	
	if(!empty($event) && ($event instanceof Event)){
		if($event->with_program) {

			if($eventDays = $event->getEventDays()){
				foreach($eventDays as $key => $day){
						
					$day_title = date(EVENT_MANAGER_FORMAT_DATE_EVENTDAY, $day->date);
					if($description = $day->description){
						$day_title = $description;
					}
										
					$tabcontent .= elgg_view("event_manager/program/elements/day", array("title" => $day_title, "entity" => $day, "selected" => true, "member" => $vars["member"]));
				}
			}
			
			$program .= $tabcontent;
			
			if ($event->canEdit() && !elgg_in_context('programmailview')) {
				$program .= elgg_view("output/url", [
					"href" => "javascript:void(0);",
					"rel" => $event->guid,
					"text" => elgg_echo("event_manager:program:day:add"),
					"class" => "elgg-button elgg-button-action event_manager_program_day_add"

				]);
			}

			echo elgg_view_module("info", elgg_echo('event_manager:event:program'), $program);			
		}
	}	