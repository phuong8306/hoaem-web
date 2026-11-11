<?php
require_once '../app/models/OrderModel.php';

class AccountController {
    // Middleware kiểm tra đăng nhập cho tất cả các trang cá nhân
    public function __construct() {
        if (!isset($_SESSION['user_id'])) {
            echo "<script>alert('Vui lòng đăng nhập để xem thông tin tài khoản!'); window.location.href='/auth/login';</script>";
            exit();
        }
    }

    // Hiển thị trang thông tin cá nhân kèm sổ địa chỉ
    public function profile() {
        $userId = $_SESSION['user_id'];
        $db = (new Database())->pdo;
        
        // Lấy thông tin user
        $stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        $user = $stmt->fetch();

        // Lấy danh sách địa chỉ của user
        $stmtAddr = $db->prepare("SELECT * FROM user_addresses WHERE user_id = ? ORDER BY is_default DESC, id DESC");
        $stmtAddr->execute([$userId]);
        $addresses = $stmtAddr->fetchAll();

        View::render('account/profile', [
            'title' => 'Thông tin tài khoản cá nhân',
            'user' => $user,
            'addresses' => $addresses
        ]);
    }

    // Xử lý cập nhật thông tin cá nhân, đổi mật khẩu và thêm địa chỉ trong 1 form duy nhất
    public function updateProfile() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_SESSION['user_id'];
            $name = trim($_POST['name'] ?? '');
            $phone = trim($_POST['phone'] ?? '');

            $db = (new Database())->pdo;

            // 1. Cập nhật thông tin tài khoản cơ bản (Họ tên, SĐT)
            // (Lưu ý: Bảng users của ní dùng cột 'name' hay 'fullname' thì ní chỉnh lại cho khớp, dưới đây tớ đồng bộ cột name theo code sẵn có)
            $stmt = $db->prepare("UPDATE users SET name = ?, phone = ? WHERE id = ?");
            $stmt->execute([$name, $phone, $userId]);
            $_SESSION['user_name'] = $name;

            // 2. Xử lý đổi mật khẩu nếu người dùng có nhập mật khẩu mới
            $currentPassword = $_POST['current_password'] ?? '';
            $newPassword = $_POST['new_password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            if (!empty($newPassword)) {
                $stmtUser = $db->prepare("SELECT password FROM users WHERE id = ?");
                $stmtUser->execute([$userId]);
                $userData = $stmtUser->fetch();

                if (empty($currentPassword) || empty($confirmPassword)) {
                    echo "<script>alert('Vui lòng nhập đầy đủ mật khẩu hiện tại và xác nhận mật khẩu mới!'); window.history.back();</script>";
                    exit();
                }

                if ($newPassword !== $confirmPassword) {
                    echo "<script>alert('Mật khẩu mới và xác nhận mật khẩu không khớp!'); window.history.back();</script>";
                    exit();
                }

                $dbPassword = $userData['password'] ?? '';
                $isPasswordCorrect = false;

                if (password_verify($currentPassword, $dbPassword) || $currentPassword === $dbPassword) {
                    $isPasswordCorrect = true;
                }

                if (!$isPasswordCorrect) {
                    echo "<script>alert('Mật khẩu hiện tại không chính xác!'); window.history.back();</script>";
                    exit();
                }

                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                $stmtPass = $db->prepare("UPDATE users SET password = ? WHERE id = ?");
                $stmtPass->execute([$hashedPassword, $userId]);
            }

            // 3. Xử lý thêm địa chỉ mới nếu có nhập ở trang profile
            if (!empty($_POST['new_address_detail'])) {
                $tagName = trim($_POST['new_tag_name'] ?? 'Nhà');
                $receiverName = trim($_POST['new_receiver_name'] ?? $name);
                $phoneAddr = trim($_POST['new_phone'] ?? $phone);
                $addressDetail = trim($_POST['new_address_detail']);
                $isDefault = isset($_POST['new_is_default']) ? 1 : 0;

                if ($isDefault) {
                    $db->prepare("UPDATE user_addresses SET is_default = 0 WHERE user_id = ?")->execute([$userId]);
                }

                $stmtAddr = $db->prepare("INSERT INTO user_addresses (user_id, tag_name, receiver_name, phone, address_detail, is_default) VALUES (?, ?, ?, ?, ?, ?)");
                $stmtAddr->execute([$userId, $tagName, $receiverName, $phoneAddr, $addressDetail, $isDefault]);
            }

            echo "<script>alert('Cập nhật tài khoản thành công!'); window.location.href='/account';</script>";
            exit();
        }
    }

    // Thêm địa chỉ mới
    public function addAddress() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_SESSION['user_id'];
            $tagName = trim($_POST['tag_name'] ?? 'Nhà');
            $receiverName = trim($_POST['receiver_name'] ?? '');
            $phone = trim($_POST['phone'] ?? '');
            $addressDetail = trim($_POST['address_detail'] ?? '');
            $isDefault = isset($_POST['is_default']) ? 1 : 0;

            $db = (new Database())->pdo;

            if ($isDefault) {
                $db->prepare("UPDATE user_addresses SET is_default = 0 WHERE user_id = ?")->execute([$userId]);
            }

            $stmt = $db->prepare("INSERT INTO user_addresses (user_id, tag_name, receiver_name, phone, address_detail, is_default) VALUES (?, ?, ?, ?, ?, ?)");
            if ($stmt->execute([$userId, $tagName, $receiverName, $phone, $addressDetail, $isDefault])) {
                echo "<script>alert('Thêm địa chỉ thành công!'); window.location.href='/account';</script>";
            } else {
                echo "<script>alert('Có lỗi xảy ra, vui lòng thử lại!'); window.history.back();</script>";
            }
            exit();
        }
    }

    // Hiển thị form chỉnh sửa một địa chỉ cụ thể
    public function editAddress($id = null) {
        if (!$id) {
            header('Location: /account');
            exit();
        }

        $userId = $_SESSION['user_id'];
        $db = (new Database())->pdo;

        $stmt = $db->prepare("SELECT * FROM user_addresses WHERE id = ? AND user_id = ?");
        $stmt->execute([$id, $userId]);
        $address = $stmt->fetch();

        if (!$address) {
            echo "<script>alert('Không tìm thấy địa chỉ hoặc bạn không có quyền chỉnh sửa!'); window.location.href='/account';</script>";
            exit();
        }

        View::render('account/edit_address', [
            'title' => 'Chỉnh sửa địa chỉ nhận hàng',
            'address' => $address
        ]);
    }

    // Xử lý cập nhật thông tin địa chỉ đã lưu
    public function updateAddress() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_SESSION['user_id'];
            $addressId = $_POST['address_id'] ?? null;
            $tagName = trim($_POST['tag_name'] ?? 'Nhà');
            $receiverName = trim($_POST['receiver_name'] ?? '');
            $phone = trim($_POST['phone'] ?? '');
            $addressDetail = trim($_POST['address_detail'] ?? '');
            $isDefault = isset($_POST['is_default']) ? 1 : 0;

            if (!$addressId) {
                header('Location: /account');
                exit();
            }

            $db = (new Database())->pdo;

            if ($isDefault) {
                $db->prepare("UPDATE user_addresses SET is_default = 0 WHERE user_id = ?")->execute([$userId]);
            }

            $stmt = $db->prepare("UPDATE user_addresses SET tag_name = ?, receiver_name = ?, phone = ?, address_detail = ?, is_default = ? WHERE id = ? AND user_id = ?");
            if ($stmt->execute([$tagName, $receiverName, $phone, $addressDetail, $isDefault, $addressId, $userId])) {
                echo "<script>alert('Cập nhật địa chỉ thành công!'); window.location.href='/account';</script>";
            } else {
                echo "<script>alert('Có lỗi xảy ra, vui lòng thử lại!'); window.history.back();</script>";
            }
            exit();
        }
    }

    // Xóa địa chỉ
    public function deleteAddress($id = null) {
        if ($id) {
            $userId = $_SESSION['user_id'];
            $db = (new Database())->pdo;
            $stmt = $db->prepare("DELETE FROM user_addresses WHERE id = ? AND user_id = ?");
            $stmt->execute([$id, $userId]);
        }
        header('Location: /account');
        exit();
    }

    // Hiển thị lịch sử đơn hàng của người dùng đang đăng nhập
    public function orders() {
        $userId = $_SESSION['user_id'];
        $orderModel = new OrderModel();
        $orders = $orderModel->getOrdersByUserId($userId);

        View::render('account/orders', [
            'title' => 'Lịch sử đơn hàng của bạn',
            'orders' => $orders
        ]);
    }

    // Hiển thị chi tiết một đơn hàng cụ thể
    public function orderDetail($orderId = null) {
        if (!$orderId) {
            header('Location: /account/orders');
            exit();
        }

        $orderModel = new OrderModel();
        $userId = $_SESSION['user_id'];

        $orders = $orderModel->getOrdersByUserId($userId);
        $currentOrder = null;
        foreach ($orders as $ord) {
            if ($ord['id'] == $orderId) {
                $currentOrder = $ord;
                break;
            }
        }

        if (!$currentOrder) {
            echo "<script>alert('Không tìm thấy đơn hàng hoặc bạn không có quyền xem!'); window.location.href='/account/orders';</script>";
            exit();
        }

        $items = $orderModel->getOrderItems($orderId);

        View::render('account/order_detail', [
            'title' => 'Chi tiết đơn hàng #' . $orderId,
            'order' => $currentOrder,
            'items' => $items
        ]);
    }
}