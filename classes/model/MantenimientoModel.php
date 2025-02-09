<?php

class MantenimientoModel{
    
    private $db, $title, $startDate, $startTime, $endDate,$endTime, $description, $categoria;
    public $errors = []; 
    private $query;
    
    public function __construct() {
        $this->db = DataBase::getInstance();
    }
    
    public function getAll()
    {
        $this->query = "SELECT * FROM events ORDER BY startDate DESC, startTime DESC";
        
        return $this->db->executeQuery($this->query);
    }
    
    public function getOneById($id){
        $this->query = "SELECT * FROM events WHERE id like $id";
        return $this->db->executeQuery($this->query);

    }
    
    public function getBetweenDates($firstDate, $secondDate){
        $this->query = "SELECT * FROM events WHERE startDate BETWEEN '" . $firstDate . "' AND '" . $secondDate . "'";
        return $this->db->executeQuery($this->query);
    }
    
    public function __get($prop) {
        if (property_exists($this, $prop)) {
            return $this->$prop;
        }
    }
    public function __set($prop, $value) {
        if (property_exists($this, $prop)) {
            $this->$prop = $value;
        }
    }
    
    public function createEvent($data = []){
        
        // Definimos la consulta SQL
        $sql = "
    INSERT INTO events
    (title, startDate, startTime, endDate, endTime, description, categoria)
    VALUES (?, ?, ?, ?, ?, ?, ?)
    ";
        
        // Usamos la instancia de la base de datos para ejecutar la consulta
        $types = "sssssss";  // El tipo de parámetros son cadenas 
        $params = [
            $data['title'] ?? null,
            $data['startDate'] ?? null,
            $data['startTime'] ?? null,
            $data['endDate'] ?? null,
            $data['endTime'] ?? null,
            $data['description'] ?? null,
            $data['categoria'] ?? null
        ];
        
        // Ejecutamos la consulta usando executeQuery
        $this->db->executeQuery($sql, $types, $params);
    }
    
    public function updateEvent($id, $data)
    {
        $sql = "UPDATE events SET
                title = ?,
                startDate = ?,
                startTime = ?,
                endDate = ?,
                endTime = ?,
                description = ?,
                categoria = ?
            WHERE id = ?";
        
        $types = "sssssssi";
        $params = [
            $data['title'] ?? null,
            $data['startDate'] ?? null,
            $data['startTime'] ?? null,
            $data['endDate'] ?? null,
            $data['endTime'] ?? null,
            $data['description'] ?? null,
            $data['categoria'] ?? null,
            $id
        ];
        
        $this->db->executeQuery($sql, $types, $params);
    }
    
    
    
    public function deleteOne($id){
        $this->query = "DELETE FROM events WHERE id = $id";
        
        return $this->db->executeQuery($this->query);
    }
    
    
    
    
}
