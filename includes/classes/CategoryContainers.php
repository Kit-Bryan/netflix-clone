<?php
class CategoryContainers
{
    private $con;
    private $username;

    public function __construct($con, $username) {
        $this->con = $con;
        $this->username = $username;
    }

    // Show all categories with thumbnails 
    public function showAllCategories() {
        // Retrieve all rows from categories
        $query = $this->con->prepare("SELECT * FROM categories");
        $query->execute();

        $html="<div class='previewCategories'>";

        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $html .= $this->getCategoryHtml($row, null, true, true);
        }

        return $html . "</div>";
    }

    public function showTVShowCategories() {
        // Retrieve all rows from categories
        $query = $this->con->prepare("SELECT * FROM categories");
        $query->execute();

        $html="<div class='previewCategories'>
                <h1>TV Shows</h1>";

        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $html .= $this->getCategoryHtml($row, null, true, true);
        }

        return $html . "</div>";
    }

    public function showMovieCategories() {
        // Retrieve all rows from categories
        $query = $this->con->prepare("SELECT * FROM categories");
        $query->execute();

        $html="<div class='previewCategories'>
                <h1>Movies</h1>";

        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $html .= $this->getCategoryHtml($row, null, false, true);
        }

        return $html . "</div>";
    }

    public function showCategory($categoryId, $title=null) {
        // Retrieve all rows from categories
        $query = $this->con->prepare("SELECT * FROM categories WHERE id=:id");
        $query->bindValue(":id", $categoryId);
        $query->execute();

        $html="<div class='previewCategories noScroll'>";

        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $html .= $this->getCategoryHtml($row, $title, true, false);
        }

        return $html . "</div>";
    }

    // Get category with 30 rows in HTML format
    private function getCategoryHtml($sqlData, $title, $tvShows, $movies) {
        $categoryId = $sqlData["id"];
        $title = $title == null ? $sqlData["name"] : $title;

        if($tvShows && $movies) {
            // Retrieve 30 rand rows from given categoryId
            $entities = EntityProvider::getEntities($this->con, $categoryId, 30);
        } else if ($tvShows) {
            // Get tvshow entities
            $entities = EntityProvider::getTVShowEntities($this->con, $categoryId, 30);

        } else {
            // Get movie entities
            $entities = EntityProvider::getMoviesEntities($this->con, $categoryId, 30);
        }

        if(sizeof($entities) == 0) {
            return;
        }

        $entitiesHtml = "";
        $previewProvider = new PreviewProvider($this->con, $this->username);
        foreach($entities as $entity) {
            // Create thumbnails and convert into html
            $entitiesHtml .= $previewProvider->createEntityPreviewSquare($entity);
        }

        return "<div class='category'>
                    <a href='category.php?id=$categoryId'>
                        <h3>$title</h3>
                    </a>
                    <div class='entities'>
                        $entitiesHtml
                    </div>
                </div>";
    }
}
