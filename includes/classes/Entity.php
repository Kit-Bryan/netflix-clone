<?php
class Entity{
    private $con;
    private $sqlData;

    public function __construct($con, $input) {
        $this->con = $con;

        if(is_array($input)) {
            $this->sqlData = $input;
        } else { //If entity id is given, select the entity with that PK id
            $query = $this->con->prepare("SELECT * FROM entities WHERE id = :id");
            $query->bindValue(":id", $input);
            $query->execute();

            $this->sqlData = $query->fetch(PDO::FETCH_ASSOC);
        }
    }

    public function getId() {
        return $this->sqlData["id"];
    }

    public function getName() {
        return $this->sqlData["name"];
    }

    public function getThumbnail() {
        return $this->sqlData["thumbnail"];
    }
    
    public function getPreview() {
        return $this->sqlData["preview"];
    }

    public function getCategoryId() {
        return $this->sqlData["categoryId"];
    }

    // Selecting all videos from that entity.
    // Order by season in ascending order.
    // Order by episodes in ascending order. 
    public function getSeasons() {
        $query = $this->con->prepare("SELECT * FROM videos WHERE entityId = :id
                                     AND isMovie=0 ORDER BY season, episode ASC");

        $query->bindValue(":id", $this->getId());
        $query->execute();

        $seasons = [];
        $videos = [];
        $currentSeason = null;
        while($row = $query->fetch(PDO::FETCH_ASSOC)){
            // When iterate to new season, append the previous season's videos array into season array
            if($currentSeason != null && $currentSeason != $row["season"]) {
                $seasons[] = new Season($currentSeason, $videos);
                // Reset videos array
                $videos = [];
            }

            $currentSeason = $row["season"];
            $videos[] = new Video($this->con, $row);
        }

        // Check if there are videos in the last season
        if (sizeof($videos) != 0){
            // Append remaining season's video array into seasons
            $seasons[] = new Season($currentSeason, $videos);
        }

        return $seasons;
    }
 

}