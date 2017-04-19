<?php 

	class EventDay extends ElggObject {
		const SUBTYPE = "eventday";
		
		protected function initializeAttributes() {
			parent::initializeAttributes();
			
			$this->attributes["subtype"] = self::SUBTYPE;
		}
		
		public function getEventSlotSets() {
			$metadata = elgg_get_metadata(array(
				"type" => "object",
				"subtype" => EventSlot::SUBTYPE,
				"container_guids" => array($this->container_guid),
				"metadata_names" => array("slot_set"),
				"limit" => false
			));
			
			$metadata_values = metadata_array_to_values($metadata);
			
			if (empty($metadata_values)) {
				return [];
			}

			return $metadata_values;
		}

		public function getEventSlots() {
			$entities_options = array(
				'type' => 'object',
				'subtype' => EventSlot::SUBTYPE,
				'relationship_guid' => $this->getGUID(),
				'relationship' => 'event_day_slot_relation',
				'inverse_relationship' => true,
				'order_by_metadata' => array("name" => "start_time", "as" => "integer"),
				'limit' => false
			);
		 
			return elgg_get_entities_from_relationship($entities_options);
		}
	}