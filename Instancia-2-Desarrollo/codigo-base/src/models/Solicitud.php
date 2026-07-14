<?php
require_once __DIR__ . '/Database.php';

class Solicitud {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getAll($filters = []) {
        
        $sql = 'SELECT * FROM solicitudes';

        $where = [];
        $params = [];

        if(!empty($filters['estado'])) {
            $where[] = "estado = ?";
            $params[] = $filters['estado'];
        }

        if(!empty($filters['prioridad'])) {
            $where[] = "prioridad = ?";
            $params[] = $filters['prioridad'];
        }

        if(!empty($where)) {
            $sql .= " WHERE " . implode(" AND ", $where);
        }

        $sql .= " ORDER BY created_at DESC";

        $stmt = $this->db->query($sql, $params);

        return $stmt -> fetchAll();
    }

    public function getById($id) {
        $stmt = $this->db->query('SELECT * FROM solicitudes WHERE id = ?', [$id]);
        return $stmt->fetch();
    }

    public function create($data) {
        $sql = 'INSERT INTO solicitudes (titulo, descripcion, area_solicitante, area_destino, prioridad, estado)
                VALUES (?, ?, ?, ?, ?, ?)';
        $params = [
            $data['titulo'],
            $data['descripcion'],
            $data['area_solicitante'],
            $data['area_destino'],
            $data['prioridad'] ?? 'media',
            'pendiente'
        ];
        $this->db->query($sql, $params);
        return $this->db->lastInsertId();
    }

    public function update($id, $data) {

        $solicitud = $this->getById($id);

        if(!$solicitud) {
            return false;
        }

        if($solicitud['estado'] !== 'pendiente') {
            throw new Exception('Solo pueden editarse solicitudes pendientes.');
        }

        $sql = 'UPDATE solicitudes SET titulo = ?, descripcion = ?, area_solicitante = ?,
                area_destino = ?, prioridad = ? WHERE id = ?';
        $params = [
            $data['titulo'],
            $data['descripcion'],
            $data['area_solicitante'],
            $data['area_destino'],
            $data['prioridad'],
            $id
        ];
        $stmt = $this->db->query($sql, $params);
        return $stmt->rowCount() > 0;
    }

    public function delete($id) {

        $solicitud = $this->getById($id);

        if(!$solicitud){
            return false;
        }

        if($solicitud['estado'] !== 'pendiente') {
            throw new Exception('Solo pueden eliminarse solicitudes pendientes.');
        }

        $stmt = $this->db->query('DELETE FROM solicitudes WHERE id = ?', [$id]);
        return $stmt->rowCount() > 0;
    }

    public function cambiarEstado($id, $nuevoEstado) {

        $solicitud = $this->getById($id);

        if(!$solicitud) {
            return false;
        }
        
        $transiciones = [
            'pendiente' => ['en_proceso'],
            'en proceso' => ['resuelta', 'rechazada'],
            'resuelta' => [],
            'rechazada' => []
        ];

        $estadoActual = $solicitud['estado'];

        if (!in_array($nuevoEstado, $transiciones[$estadoActual])) {
            throw new Exception('Cambio de estado no permitido.');
        }

        $stmt = $this->db->query(
            'UPDATE solicitudes SET estado = ? WHERE id = ?',
            [$nuevoEstado, $id]
        );

        return $stmt->rowCount() > 0;
    }

    public function validate($data) {
        $errors = [];
        if (empty(trim($data['titulo'] ?? ''))) {
            $errors[] = 'El título es obligatorio';
        }
        if (empty(trim($data['descripcion'] ?? ''))) {
            $errors[] = 'La descripción es obligatoria';
        }
        if (empty(trim($data['area_solicitante'] ?? ''))) {
            $errors[] = 'El área solicitante es obligatoria';
        }
        if (empty(trim($data['area_destino'] ?? ''))) {
            $errors[] = 'El área destinataria es obligatoria';
        }
        if (empty($data['prioridad'])) {
            $errors[] = 'La prioridad es obligatoria';
        }
        return $errors;
    }
}
?>
