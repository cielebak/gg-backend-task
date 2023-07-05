<?php

class UserModel {
    private $filePath;

    public function __construct() {
        $this->filePath = __DIR__ . '/../dataset/users.json';
    }

    public function getAllUsers() {
        $usersData = file_get_contents($this->filePath);
        $users = json_decode($usersData, true);
        return $users;
    }
}

$userModel = new UserModel();
$users = $userModel->getAllUsers();
