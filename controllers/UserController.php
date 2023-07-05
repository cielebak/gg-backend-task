<?php
require_once(__DIR__ . '/../models/UserModel.php');

class UserController {
    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    public function index() {
        $users = $this->userModel->getAllUsers();
        return $users;
    }

    public function addUser() {
        $this->userModel->addUser($user);
    }

    public function deleteUser($id) {
        $this->userModel->deleteUser($id);
    }
}

$userController = new UserController();
$users = $userController->index();
