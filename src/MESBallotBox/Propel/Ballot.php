<?php

namespace MESBallotBox\Propel;

use MESBallotBox\Propel\Base\Ballot as BaseBallot;

/**
 * Skeleton subclass for representing a row from the 'Ballot' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class Ballot extends BaseBallot
{
    private $timezonesNice = Array(
        1 => 'Eastern',
        2 => 'Central',
        3 => 'Mountain',
        4 => 'Western',
        5 => 'Alaska',
        6 => 'Hawaii'
    );
    private $timezonesPHP = Array(
        1 => 'America/New_York',
        2 => 'America/Chicago',
        3 => 'America/Denver',
        4 => 'America/Los_Angeles',
        5 => 'America/Anchorage',
        6 => 'Pacific/Honolulu'
    );
    
    public function setStartDate($start){
        $timezone = new \DateTimeZone($this->getTimezonePHP());
        $startTime = new \DateTime($start,$timezone);
        $this->setStartTime($startTime->format('U'));
        
    }
    
    public function getStartDate(){
        $timezone = new \DateTimeZone($this->getTimezonePHP());
        $startTime = new \DateTime(false,$timezone);
        $startTime->setTimestamp($this->getStarttime());
        return $startTime->format('l, F jS Y h:i A');
    }
    
    public function setEndDate($end){
        $timezone = new \DateTimeZone($this->getTimezonePHP());
        $endTime = new \DateTime($end,$timezone);
        $this->setEndTime($endTime->format('U'));
    }
    
    public function getEndDate(){
        $timezone = new \DateTimeZone($this->getTimezonePHP());
        $endTime = new \DateTime(false,$timezone);
        $endTime->setTimestamp($this->getEndtime());
        return $endTime->format('l, F jS Y h:i A');
    }

    public function getTimezoneNice(){
        return $this->timezonesNice[(int)$this->getTimezone()];
    }
    
    function getTimezonePHP(){
        return $this->timezonesPHP[$this->getTimezone()];
    }
}
