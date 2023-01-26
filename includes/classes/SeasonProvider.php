<?php
class SeasonProvider
{
    private $con, $username;

    public function __construct($con, $username)
    {
        $this->con = $con;
        $this->username = $username;
    }

    public function create($entity) {
        // Get all seasons, with all videos in each season
        $seasons = $entity->getSeasons();

        // Check if its a movie with no seasons
        if(sizeof($seasons) == 0) {
            return;
        }

        $seasonsHtml = "";

        foreach($seasons as $season) {
            $seasonNumber = $season->getSeasonNumber();
            $videosHtml = "";
            foreach($season->getVideos() as $video) {
                $videosHtml .= $this->createVideoSquare($video);
            }


            $seasonsHtml .= "<div class='season'>
                                <h3>Season $seasonNumber</h3>
                                <div class='videos'>
                                    $videosHtml
                                </div>
                            </div>";
            
        }
        return $seasonsHtml;
    }

    // Create video thumbnails in entity page
    private function createVideoSquare($video) {
        $id = $video->getId();
        $thumbnail = $video->getThumbnail();
        $name = $video->getTitle();
        $description = $video->getDescription();
        $episodeNumber = $video->getEpisodeNumber();
        $hasSeen = $video->hasSeen($this->username) ? "<i class='fa-solid fa-circle-check seen'></i>" : "";

        return "<a href='watch.php?id=$id'>
                    <div class='episodeContainer'>
                        <div class='contents'>

                            <img src='$thumbnail' alt='thumbnail'>
                            <div class='videoInfo'>
                                <h4> $episodeNumber. $name</h4>
                                <span>$description</span>
                            </div>
                            $hasSeen
                        </div>
                    </div>    
                </a>";
    }

}











