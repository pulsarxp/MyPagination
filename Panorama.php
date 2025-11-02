<?php
class Panorama {
    private $db;
    
    public function __construct(Database $db) {
        $this->db = $db;
    }
    
    public function getCategories() {
        $sql = "SELECT DISTINCT category FROM " . DB_TABLE . " WHERE category IS NOT NULL";
        return $this->db->query($sql)->fetchAll();
    }
    
    public function getPanoramas($page = 1, $category = null, $perPage = 10) {
        $offset = ($page - 1) * $perPage;
        $params = [];
        $whereClause = "";
        
        if ($category) {
            $whereClause = "WHERE category = :category";
            $params[':category'] = $category;
        }
        
        $sql = "SELECT * FROM " . DB_TABLE . " $whereClause ORDER BY ID DESC LIMIT " . (int)$offset . ", " . (int)$perPage;
        
        return $this->db->query($sql, $params)->fetchAll();
    }
    
    public function getTotalPages($category = null, $perPage = 10) {
        $params = [];
        $whereClause = "";
        
        if ($category) {
            $whereClause = "WHERE category = :category";
            $params[':category'] = $category;
        }
        
        $sql = "SELECT COUNT(*) as total FROM " . DB_TABLE . " $whereClause";
        $result = $this->db->query($sql, $params)->fetch();

        $totalRecords = (int)($result['total'] ?? 0);

        return max(1, (int)ceil($totalRecords / $perPage));
    }
    
    public function addPanorama($data) {
        $sql = "INSERT INTO " . DB_TABLE . " (name, url, comment, cam_type, category) 
                VALUES (:name, :url, :comment, :cam_type, :category)";
                
        $params = [
            ':name' => $data['name'],
            ':url' => $data['url'],
            ':comment' => $data['comment'],
            ':cam_type' => $data['cam_type'],
            ':category' => $data['category']
        ];
        
        return $this->db->query($sql, $params);
    }
    
    public function getCameraImage($camType) {
        $images = [
            'g' => 'images/gear.png',
            'm' => 'images/mavic.png',
            'i' => 'images/insta360.png'
        ];
        
        return $images[$camType] ?? 'images/nikon.png';
    }
} 