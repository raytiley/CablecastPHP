<?php
namespace CablecastPHP;

class Show
{
    function __construct($showID, $title, $cgTitle, $comments, $lengthInSeconds)
    {
        $this->showID = $showID;
        $this->title = $title;
        $this->cgTitle = $cgTitle;
        $this->comments = $comments;
        $this->lengthInSeconds = $lengthInSeconds;
    }

    private $title;
    public function getTitle()
    {
        return $this->title;
    }

    private $cgTitle;
    public function getCGTitle()
    {
        return $this->cgTitle;
    }

    private $lengthInSeconds;
    public function getLengthInSeconds()
    {
        return $this->lengthInSeconds;
    }

    private $comments;
    public function getComments()
    {
        return $this->comments;
    }
}
?>
