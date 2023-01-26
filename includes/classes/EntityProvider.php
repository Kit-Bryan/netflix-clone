<?php
class EntityProvider
{

    // Gets a bunch of entities
    public static function getEntities($con, $categoryId, $limit)
    {

        $sql = "SELECT * FROM entities ";

        // If categoryId is given, select random rows with that categoryId
        // If not given, select random rows
        if ($categoryId != null) {
            $sql .= "WHERE categoryId = :categoryId ";
        }

        $sql .= "ORDER BY RAND() LIMIT :limit";

        $query = $con->prepare($sql);

        if ($categoryId != null) {
            $query->bindValue(":categoryId", $categoryId);
        }

        $query->bindValue(":limit", $limit, PDO::PARAM_INT);
        $query->execute();

        $result = [];
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            // Create entity object and append
            $result[] = new Entity($con, $row);
        }

        return $result;
    }

    public static function getTVShowEntities($con, $categoryId, $limit)
    {

        $sql = "SELECT DISTINCT(entities.id) FROM `entities` 
                    INNER JOIN `videos` 
                    ON entities.id = videos.entityId 
                    WHERE videos.isMovie=0 ";

        // If categoryId is given, select random rows with that categoryId
        // If not given, select random rows
        if ($categoryId != null) {
            $sql .= "AND categoryId = :categoryId ";
        }

        $sql .= "ORDER BY RAND() LIMIT :limit";

        $query = $con->prepare($sql);

        if ($categoryId != null) {
            $query->bindValue(":categoryId", $categoryId);
        }

        $query->bindValue(":limit", $limit, PDO::PARAM_INT);
        $query->execute();

        $result = [];
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            // Create entity object and append
            $result[] = new Entity($con, $row["id"]);
        }

        return $result;
    }

    public static function getMoviesEntities($con, $categoryId, $limit)
    {

        $sql = "SELECT DISTINCT(entities.id) FROM `entities` 
                    INNER JOIN `videos` 
                    ON entities.id = videos.entityId 
                    WHERE videos.isMovie=1 ";

        // If categoryId is given, select random rows with that categoryId
        // If not given, select random rows
        if ($categoryId != null) {
            $sql .= "AND categoryId = :categoryId ";
        }

        $sql .= "ORDER BY RAND() LIMIT :limit";

        $query = $con->prepare($sql);

        if ($categoryId != null) {
            $query->bindValue(":categoryId", $categoryId);
        }

        $query->bindValue(":limit", $limit, PDO::PARAM_INT);
        $query->execute();

        $result = [];
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            // Create entity object and append
            $result[] = new Entity($con, $row["id"]);
        }

        return $result;
    }

    public static function getSearchEntities($con, $term)
    {

        $sql = "SELECT * FROM entities WHERE name LIKE '%' :term '%' LIMIT 30";

        $query = $con->prepare($sql);

        $query->bindValue(":term", $term);
        $query->execute();

        $result = [];
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            // Create entity object and append
            $result[] = new Entity($con, $row);
        }

        return $result;
    }
}
