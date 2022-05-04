
<?php
class AbmProducto
{
    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
     * @param array $param
     * @return Producto
     */

    private function cargarObjeto($param)
    {   
        $obj = null;
        if (
            array_key_exists('idproducto', $param)      and     array_key_exists('pronombre', $param)   and
            array_key_exists('proautor', $param)        and     array_key_exists('prodetalle', $param)  and
            array_key_exists('procantstock', $param)    and     array_key_exists('proprecio', $param)   and
            array_key_exists('proeditorial', $param)    and     array_key_exists('proanio', $param)     and
            array_key_exists('proimagen', $param)       and     array_key_exists('prodeshabilitado', $param)
        ) {
            $obj = new Producto();
            $obj->setear(
                $param['idproducto'],
                $param['pronombre'],
                $param['proautor'],
                $param['prodetalle'],
                $param['procantstock'],
                $param['proprecio'],
                $param['proeditorial'],
                $param['proanio'],
                $param['proimagen'],
                $param['prodeshabilitado'] 
            );
        }
        return $obj;
    }

    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves
     * @param array $param
     * @return Producto
     */
    private function cargarObjetoConClave($param)
    {
        $obj = null;
        if (isset($param['idproducto'])) {
            $obj = new Producto();
            $obj->setear($param['idproducto'], null, null, null, null, null, null, null, null, null);
        }
        return $obj;
    }

    /**
     * Corrobora que dentro del arreglo asociativo estan seteados los campos claves
     * @param array $param
     * @return boolean
     */

    private function seteadosCamposClaves($param)
    {
        $resp = false;
        if (isset($param['idproducto']))
            $resp = true;
        return $resp;
    }

    /**
     * 
     * @param array $param
     */
    public function alta($param)
    {
        $resp = false;
        $param['idproducto'] = null;
        $param['proimagen'] = "";
        $param['prodeshabilitado'] = 1;
        $unObjProducto = $this->cargarObjeto($param);
        if ($unObjProducto != null and $unObjProducto->insertar()) {
            $img = $this->guardarImagenes($unObjProducto->getIDProducto());
            $resp = $unObjProducto;
        }
        return $resp;
    }

    public function baja($param)
    {
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            $obj = $this->cargarObjetoConClave($param);
            if ($obj != null && $obj->eliminar()) {
                $resp = true;
            }
        }

        return $resp;
    }

    /*+*
     * permite modificar un objeto
     * @param array $param
     * @return boolean
     */
    public function modificacion($param)
    {
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            $unObjProducto = $this->cargarObjeto($param);
            if ($unObjProducto != null and $unObjProducto->modificar()) {
                $this->modificarImagen($unObjProducto, $param);
            }
        }

        return $unObjProducto;
    }

    public function modificacionEstado($param)
    {
        $resp = false;
        $array['idproducto'] = $param['idproducto'];
        $producto = $this->buscar($array);
        $producto[0]->setProdeshabilitado($param['prodeshabilitado']);
        $producto[0]->modificar();
        return $resp;
    }

    /**
     * permite buscar un objeto
     * @param array $param
     * @return boolean
     */
    public function buscar($param)
    {
        $where = " true ";
        if ($param <> NULL) {
            if (isset($param['idproducto']))
                $where .= " and idproducto =" . $param['idproducto'] . "";
            if (isset($param['pronombre']))
                $where .= " and pronombre ='" . $param['pronombre'] . "'";
            if (isset($param['prodetalle']))
                $where .= " and prodetalle ='" . $param['prodetalle'] . "'";
            if (isset($param['procantstock']))
                $where .= " and procantstock ='" . $param['procantstock'] . "'";
            if (isset($param['prodeshabilitado']))
                $where .= " and prodeshabilitado ='" . $param['prodeshabilitado'] . "'";
        }
        $arreglo = Producto::listar($where);
        return $arreglo;
    }

    public function modificarImagen($unObjProducto, $param)
    {
        //verifico si la carpeta existe
        if (!array_key_exists('mantenerfotoInput', $param)) {
            if (array_key_exists("unaimagen", $_FILES)) {
                $resp = false;
                $dir = '../../Vista/archivos/Productos/' . md5($unObjProducto->getIDProducto()) . '/'; // carpeta para guardar imagen

                if (file_exists($dir)) {
                    $files = glob($dir . '*');
                    foreach ($files as $file) {
                        if (is_file($file))
                            unlink($file); //elimino el fichero
                    }
                }
                $this->guardarImagenes($unObjProducto->getIDProducto());
            }
        }
    }

    public function guardarImagenes($idPro)
    {
        $exito = true;
        if ($_FILES['unaimagen']['name'][0] != '') {

            $dir = '../../Vista/archivos/Productos/' . md5($idPro) . '/'; // carpeta para guardar imagen

            if (!file_exists($dir)) {
                mkdir($dir, 0777, true);
            }

            $i = 0;
            // probar while si quiere uardar varias fotos
            // while ($i < count($_FILES['unaimagen']['name'])) {
            if ($_FILES['unaimagen']['error'] <= 0) {
                if (!copy($_FILES['unaimagen']['tmp_name'], $dir . $_FILES['unaimagen']['name'])) {
                    $exito = 4;
                }
            } else {
                $exito = 5;
            }
            $i++;
            // }
        }
        return $exito;
    }
}
?>