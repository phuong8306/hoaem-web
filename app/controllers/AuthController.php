<?php
require_once __DIR__ . '/../models/UserModel.php';
class AuthController {
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = trim($_POST['username']);
            $password = trim($_POST['password']);

            $userModel = new UserModel();
            $user = $userModel->getUserByUsername($username);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role']; // Lưu phân quyền vào session

                if ($user['role'] == 'admin') {
                    header('Location: /admin/orders');
                } else {
                    header('Location: /');
                }
                exit();
            } else {
                echo "<script>alert('Tên đăng nhập hoặc mật khẩu không đúng!'); history.back();</script>";
            }
        } else {
            View::render('auth/login', ['title' => 'Đăng nhập hệ thống']);
        }
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = trim($_POST['username']);
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);

            $userModel = new UserModel();
            if ($userModel->register($username, $password, $email)) {
                echo "<script>alert('Đăng ký thành công!'); window.location.href='/auth/login';</script>";
            } else {
                echo "<script>alert('Tên đăng nhập hoặc email đã tồn tại!'); history.back();</script>";
            }
        } else {
            View::render('auth/register', ['title' => 'Đăng ký tài khoản']);
        }
    }

    public function logout() {
        unset($_SESSION['user_id']);
        unset($_SESSION['username']);
        unset($_SESSION['role']);
        unset($_SESSION['cart']);
        unset($_SESSION['voucher']);
        header('Location: /');
        exit();
    }
}