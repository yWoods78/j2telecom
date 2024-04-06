<?php
class Usuario {
    private $login;
    private $senha;
    private $isadmin;

    public function __construct($login, $senha, $isadmin) {
        $this->login = $login;
        $this->senha = $senha;
        $this->isadmin = $isadmin;
    }

    public function getLogin() {
        return $this->login;
    }

    public function getSenha() {
        return $this->senha;
    }

    public function getisadmin() {
        return $this->isadmin;
    }
}

