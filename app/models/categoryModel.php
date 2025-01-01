<?php

class categoryModel extends DModel
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getAllCategory($table_categories)
    {
        $sql = "
                SELECT *
                FROM
                    $table_categories
                ORDER BY $table_categories.category_id ASC
            ";
        return $this->db->select($sql);
    }

    public function getCategoryByCategoryId($table_categories, $category_id)
    {
        $sql = "
                SELECT *
                FROM
                    $table_categories
                WHERE
                    $table_categories.category_id = $category_id
                LIMIT 1
            ";
        return $this->db->select($sql);
    }
}
