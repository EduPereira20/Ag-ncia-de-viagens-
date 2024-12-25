<?php

class Administrador {
    private $user_admin;
    private $password_admin;
    private $name_admin;

    public function getName_admin() {
        return $this->name_admin;
    }

    public function setNameAdmin($name_admin) {
        $this->name_admin = $name_admin;
    }

    public function getUserAdmin() {
        return $this->user_admin;
    }

    public function setUserAdmin($user_admin) {
        $this->user_admin = $user_admin;
    }

    public function getPasswordAdmin() {
        return $this->password_admin;
    }

    public function setPasswordAdmin($password_admin) {
        $this->password_admin = $password_admin;
    }
}



?>