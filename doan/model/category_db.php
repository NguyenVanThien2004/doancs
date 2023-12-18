<?php
class CategoryDB {
    public function getCategories() {
        $db = Database::getDB();
        $query = 'SELECT * FROM loaisp
                  ORDER BY idloai';
        $result = $db->query($query);
        $categories = array();
        foreach ($result as $row) {
            $category = new Category();
            $category->setID($row['idloai']);
            $category->setName($row['tenloai']);
            $categories[] = $category;
        }
        return $categories;
    }

}
?>