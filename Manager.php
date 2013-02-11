<?php
namespace CablecastPHP;

use CablecastPHP\Show;
use CablecastPHP\ScheduleItem;
use CablecastPHP\Location;
use CablecastPHP\Channel;

use SoapClient;
use DateTime;

class Manager
{
	private $soapClient = null;
	private static $cachedManager = null;
	private $cablecastServer = null;
	private $cachedChannels = null;

	function __construct($serverAddress)
	{
		$this->cablecastServer = $serverAddress;
		$this->soapClient = new SoapClient($this->cablecastServer . '/CablecastWS/CablecastWS.asmx?WSDL', array('cache_wsdl' => 0));
	}

	public static function getManager($serverAddress)
	{
		if (!self::$cachedManager)
		{
			self::$cachedManager = new Manager($serverAddress);
		}
		return self::$cachedManager;
	}

	public function getChannels()
	{

	    //Return immediately if channels have already been cached
		if($this->cachedChannels != null)
		{
			return $this->cachedChannels;
		}

	    //Lookup channels from server
		$result = $this->soapClient->GetChannels(NULL);
		$this->cachedChannels = array();

		foreach ($result->GetChannelsResult->Channel as $channel) {
			$this->cachedChannels[] = new Channel($channel->ChannelID, $channel->Name, $channel->PrimaryLocationID);
		}

		return $this->cachedChannels;
	}

	public function getLocations()
	{
		$result = $this->soapClient->getLocations(NULL);

		$result = is_array($result->GetLocationsResult->Location) ? $result->GetLocationsResult->Location : array($result->GetLocationsResult->Location);

		$locations = array();

		foreach($result as $location) {
			$locations[] = new Location($location->LocationID, $location->Name);
		}

		return $locations;
	}

	public function getSchedule($channelID, $fromDate, $toDate)
	{
	    //Create $params for web service call
		$params = array('ChannelID' => $channelID,
			'FromDate' =>  $fromDate->format('Y-m-d\T00:00:00'),
			'ToDate'  =>  $toDate->format('Y-m-d\T23:59:59'),
			'restrictToShowID'  =>  0,
			);

	    //Get Data from WebService
		$result = $this->soapClient->GetCGExemptScheduleInformation($params);

	    //Create ScheduleItems if results are returned.
		$schedule = array();
		if($result->GetCGExemptScheduleInformationResult->ScheduleInfo) {
			foreach ($result->GetCGExemptScheduleInformationResult->ScheduleInfo as $run) {
				$schedule[] = new ScheduleItem($run->ScheduleID,
					$run->ShowID,
					$run->ShowTitle,
					new DateTime($run->StartTime),
					new DateTime($run->EndTime),
					$run->CGExempt);
			}
		}

	    //return schedule items
		return $schedule;
	}

	public function getModifiedShows($locationID, $searchDate = null)
	{
		if($searchDate == null)
		{
			$searchDate = new DateTime();
			$searchDate->modify('-3 day');
		}
		$params = array(
			"LocationID" => $locationID, 
			"SearchDate" => $searchDate->format('Y-m-d\T00:00:00'), 
			"DateComparator" => ">"
			);

		$result = $this->soapClient->LastModifiedSearch($params);

		$shows = array();
		foreach ($result->LastModifiedSearchResult->ShowInfo as $show) {
			$shows[] = new Show(
				$show->ShowID,
				$show->InternalTitle,
				$show->Title,
				$show->Comments,
				$show->TotalSeconds
				);
		}

		return $shows;
	}
}
?>