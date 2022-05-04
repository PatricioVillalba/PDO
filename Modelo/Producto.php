<?php
class Producto{
    private $idproducto;
    private $pronombre;
    private $proautor;
    private $prodetalle;
    private $procantstock;
    private $proprecio;
    private $proeditorial;
    private $proanio;
    private $proimagen;
    private $prodeshabilitado;
    private $mensajeoperacion;
    
    public function __construct(){
        $this->idproducto="";
        $this->pronombre="";
        $this->proautor="";
        $this->prodetalle="";
        $this->procantstock="";
        $this->proprecio="";
        $this->proeditorial="";
        $this->proanio="";
        $this->proimagen="";
        $this->prodeshabilitado="";
        $this->mensajeoperacion="";
    }

    public function setear($id,$nombre,$autor,$detalle,$stock,$precio,$editorial,$anio,$proimagen,$prodeshabilitado){

        $this->setIDProducto($id);
        $this->setProNombre($nombre);
        $this->setProAutor($autor);
        $this->setProDetalle($detalle);
        $this->setProCantStock($stock);
        $this->setProPrecio($precio);
        $this->setProEditorial($editorial);
        $this->setProAnio($anio);
        $this->setProdeshabilitado($prodeshabilitado);
    }

    public function getIDProducto(){
        return $this->idproducto;
    }
    public function setIDProducto($valor){
        $this->idproducto=$valor;
    }

    public function getProNombre(){
        return $this->pronombre;
    }
    public function setProNombre($valor){
        $this->pronombre=$valor;
    }

    public function getProDetalle(){
        return $this->prodetalle;
    }
    public function setProDetalle($valor){
        $this->prodetalle=$valor;
    }

    public function getProCantStock(){
        return $this->procantstock;
    }
    public function setProCantStock($valor){
        $this->procantstock=$valor;
    }

    public function getmensajeoperacion(){
        return $this->mensajeoperacion;
    }
    public function setmensajeoperacion($valor){
        $this->mensajeoperacion=$valor;
    }

    public function getProAutor(){
        return $this->proautor;
    }
    public function setProAutor($valor){
        $this->proautor=$valor;
    }

    public function getProPrecio(){
        return $this->proprecio;
    }
    public function setProPrecio($valor){
        $this->proprecio=$valor;
    }

    public function getProEditorial(){
        return $this->proeditorial;
    }
    public function setProEditorial($valor){
        $this->proeditorial=$valor;
    }

    public function getProAnio(){
        return $this->proanio;
    }
    public function setProAnio($valor){
        $this->proanio=$valor;
    }

    public function getProImagen(){
        return $this->proimagen;
    }
    public function setProImagen($valor){
        $this->proimagen=$valor;
    }
    public function getProdeshabilitado(){
        return $this->prodeshabilitado;
    }
    public function setProdeshabilitado($valor){
        $this->prodeshabilitado=$valor;
    }
    /** 
     * 
    */
    public function cargar(){
        $resp = false;
        $base=new BaseDatos();
        $sql="SELECT * FROM producto WHERE idproducto = ".$this->getIDProducto()."";
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if($res>-1){
                if($res>0){
                    $row = $base->Registro();
                    $this->setear($row['idproducto'], $row['pronombre'],$row['proautor'],$row['prodetalle'],$row['procantstock'],$row['proprecio'],$row['proeditorial'],$row['proanio'],$row['proimagen'],$row['prodeshabilitado']);
                }
            }
        } else {
            $this->setmensajeoperacion("Producto->listar: ".$base->getError());
        }
        return $resp;
    }

    public function insertar(){
        $resp = false;
        $base = new BaseDatos();
        $sql  = " INSERT INTO producto(pronombre,proautor,prodetalle,procantstock,proprecio,proeditorial,proanio,proimagen,prodeshabilitado)  
                  VALUES('" . $this->getProNombre() . "','" . $this->getProAutor() . "','" . $this->getProDetalle() . "'," . $this->getProCantStock() . "," .
                            $this->getProPrecio() . ",'" . $this->getProEditorial() . "'," . $this->getProAnio() . ",'" . $this->getProImagen() . "'," . $this->getProdeshabilitado() . ");";
        if ($base->Iniciar()) {

            if ($elid=$base->Ejecutar($sql)) {
                $this->setIDProducto($elid);
                $resp = true;
            } else {
                $this->setmensajeoperacion("Producto->insertar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("Producto->insertar: " . $base->getError());
        }
        return $resp;
    }

    /**
     * 
     */
    public function modificar(){
        $resp = false;
        $base=new BaseDatos();
        $sql="UPDATE producto SET pronombre='".$this->getProNombre()."',proautor='".$this->getProAutor()."',prodetalle='".$this->getProDetalle()."',procantstock=".$this->getProCantStock().", proprecio=".$this->getProPrecio().",proeditorial='".$this->getProEditorial()."',proanio=".$this->getProAnio().",proimagen='".$this->getProImagen()."',prodeshabilitado='".$this->getProdeshabilitado()."' WHERE idproducto=".$this->getIDProducto().";";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $resp = true;
            }
        } else {
            $this->setmensajeoperacion("Producto->modificar: ".$base->getError());
        }
        return $resp;
    }

    /**
     */
    public function eliminar(){
        $resp = false;
        $base=new BaseDatos();
        $sql="DELETE FROM producto WHERE idproducto=".$this->getIDProducto();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                return true;
            } else {
                $this->setmensajeoperacion("Producto->eliminar: ".$base->getError());
            }
        } else {
            $this->setmensajeoperacion("Producto->eliminar: ".$base->getError());
        }
        return $resp;
    }

    public static function listar($parametro=""){
        $arreglo = array();
        $base=new BaseDatos();
        $sql="SELECT * FROM producto ";
        if ($parametro!="") {
            $sql.='WHERE '.$parametro;
        }
        $res = $base->Ejecutar($sql);
        if($res>-1){
            if($res>0){
                while ($row = $base->Registro()){
                    $obj= new Producto();
                    $obj->setear($row['idproducto'], $row['pronombre'],$row['proautor'],$row['prodetalle'],$row['procantstock'],$row['proprecio'],$row['proeditorial'],$row['proanio'],$row['proimagen'],$row['prodeshabilitado']);
                    array_push($arreglo, $obj);
                }               
            }            
        } else {
            // $this->setmensajeoperacion("Producto->listar: ".$base->getError());
        }
        return $arreglo;
    }
}
