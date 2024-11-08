<?php 
require_once 'App\Traits\ValidarRam.php';

use App\Traits\ValidarRam;

class Ram {

    use ValidarRam;

    private $porcentaje_promocion;
    private $porcentaje_regular;
    private $nota_promocion;
    private $nota_regular;
    private $id_institucion;

    public function __construct($porcentaje_promocion, $porcentaje_regular, $nota_promocion, $nota_regular, $id_institucion) {

        $this->porcentaje_promocion = $porcentaje_promocion;
        $this->porcentaje_regular = $porcentaje_regular;
        $this->nota_promocion = $nota_promocion;
        $this->nota_regular = $nota_regular;
        $this->id_institucion = $id_institucion;
    }


    public function getPorcentajePromocion() {
        return $this->porcentaje_promocion;
    }

    public function getPorcentajeRegular() {
        return $this->porcentaje_regular;
    }

    public function getNotaPromocion() {
        return $this->nota_promocion;
    }

    public function getNotaRegular() {
        return $this->nota_regular;
    }

    
    public function getIdInstitucion() {
        return $this->id_institucion;
    }


    public function setPorcentajePromocion($porcentaje_promocion) {
        $this->porcentaje_promocion = $porcentaje_promocion;
    }

    public function setPorcentajeRegular($porcentaje_regular) {
        $this->porcentaje_regular = $porcentaje_regular;
    }

    public function setNotaPromocion($nota_promocion) {
        $this->nota_promocion = $nota_promocion;
    }

    public function setNotaRegular($nota_regular) {
        $this->nota_regular = $nota_regular;
    }

    public function setIdInstitucion($id_institucion) {
        $this->id_institucion = $id_institucion;
    }

    public function crearRam($conn) {
        $porcentaje_promocion = $this->getPorcentajePromocion();
        $porcentaje_regular = $this->getPorcentajeRegular();
        $nota_promocion = $this->getNotaPromocion();
        $nota_regular = $this->getNotaRegular();
        $id_institucion = $this->getIdInstitucion();
    
        $query = "INSERT INTO ram (id_institucion, porcentaje_promocion, porcentaje_regular, nota_promocion, nota_regular) 
        VALUES (:id_institucion, :porcentaje_promocion, :porcentaje_regular, :nota_promocion, :nota_regular)";
    
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id_institucion', $id_institucion);
        $stmt->bindParam(':porcentaje_promocion', $porcentaje_promocion);
        $stmt->bindParam(':porcentaje_regular', $porcentaje_regular);
        $stmt->bindParam(':nota_promocion', $nota_promocion);
        $stmt->bindParam(':nota_regular', $nota_regular);
    
        if ($stmt->execute()) {
            return true; 
        } else {
            
            return false; 
        }
    }
    
    
    public static  function obtenerDatosRam($conn, $idInstitucion) {
        $query = "SELECT * FROM ram WHERE id_institucion = :id_institucion";

        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id_institucion', $idInstitucion, PDO::PARAM_INT);
        $stmt->execute();
        
        return  $stmt->fetch(PDO::FETCH_ASSOC);
    
    }
    

    public function editarRam($conn) {
        $porcentaje_promocion = $this->getPorcentajePromocion();
        $porcentaje_regular = $this->getPorcentajeRegular();
        $nota_promocion = $this->getNotaPromocion();
        $nota_regular = $this->getNotaRegular();
        $id_institucion = $this->getIdInstitucion(); 
    
        $query = "UPDATE ram 
                SET porcentaje_promocion = :porcentaje_promocion, 
                    porcentaje_regular = :porcentaje_regular, 
                    nota_promocion = :nota_promocion, 
                    nota_regular = :nota_regular 
                WHERE id_institucion = :id_institucion";
    
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':porcentaje_promocion', $porcentaje_promocion);
        $stmt->bindParam(':porcentaje_regular', $porcentaje_regular);
        $stmt->bindParam(':nota_promocion', $nota_promocion);
        $stmt->bindParam(':nota_regular', $nota_regular);
        $stmt->bindParam(':id_institucion', $id_institucion);

        return $stmt->execute();
    }
    
}
?>
