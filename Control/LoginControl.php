<?php

class LoginControl {

  function logear() {
    $data = data_submitted();
    $sesion = null;
    if (isset($data['usnombre']) && isset($data['uspass'])) {
      $sesion = new Session();
      $sesion->iniciar($data['usnombre'], md5($data['uspass']));
      if (!$sesion->validar()) {
        $sesion = null;
      }
    }
    return $sesion;
  }
}
