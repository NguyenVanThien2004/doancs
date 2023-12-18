<?php 
class Search {
    private $searchword;

    public function __construct($searchword) {
        $this->searchword = $searchword;
    }

    public function getSearchWord() {
        return $this->searchword;
    }

    public function setSearchWord($searchword) {
        $this->searchword = $searchword;
    }

}
?>