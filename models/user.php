<?php

//models\user.php

Class User {

    private int $id;
    private string $username;
    private string $role;
    private string $created_at;

    public function __construct($data=[]) {
        $this->id = $data['id'];
        $this->username = $data['username'];
        $this->role = $data['role'] ?? 'viewer';
        $this->created_at = $data['created_at'] ?? '';
    }

    public function __get($name) {
        return $this->$name; 
    }

}//class
 