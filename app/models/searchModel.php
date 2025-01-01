<?php

class searchModel extends DModel
{

    public function __construct()
    {
        parent::__construct();
    }

    public function searchBooksByTerm($term)
    {
        $sql = "SELECT 
                    b.book_id,
                    b.title, 
                    b.price,
                    b.author,
                    b.stock,
                    b.description,
                    i.path AS image_path
                FROM 
                    books b
                LEFT JOIN 
                    images i ON b.book_id = i.book_id
                WHERE b.title LIKE '%$term%' OR b.description LIKE '%$term%';
                ORDER BY b.stock DESC
            ";
        return $this->db->select($sql);
    }
}
