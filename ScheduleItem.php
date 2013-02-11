<?php
namespace CablecastPHP;

class CablecastScheduleItem
{

    function __construct($scheduleID, $showID, $showTitle, $startTime, $endTime, $cgExempt) 
    {
        $this->showID = $showID;
        $this->title = $showTitle;
        $this->startDateTime = $startTime;
        $this->endDateTime = $endTime;
    }

    private $title;
    public function getTitle()
    {
        return $this->title;
    }

    private $showID;
    public function getShowID()
    {
        return $this->showID;
    }

    private $startDateTime;
    public function getStartDateTime()
    {
        return $this->startDateTime;
    }

    private $endDateTime;
    public function getEndDateTime()
    {
        return $this->endDateTime;
    }
}