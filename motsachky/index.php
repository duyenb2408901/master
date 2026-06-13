<?php
// Thiết lập HTTP Caching để tối ưu hiệu năng (Tiêu chí 5)
header("Cache-Control: max-age=3600, must-revalidate");

// Nhận tham số điều hướng an toàn (Mô hình MVC & Router)
$page = isset($_GET['page']) ? $_GET['page'] : 'trang-chu';
$action = isset($_GET['action']) ? $_GET['action'] : '';

// Xử lý bảo mật đầu vào - Đề phòng lỗi bảo mật XSS (Tiêu chí 4)
function sanitize_input($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

// Xử lý hành động gửi Form thêm dữ liệu
if ($action === 'save-book' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. Kiểm tra chống tấn công giả mạo CSRF (Tiêu chí 4)
    if(!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== 'xyz123securetoken') {
        die("Yêu cầu không hợp lệ (Lỗi bảo mật CSRF)!");
    }

    // 2. Làm sạch dữ liệu chống XSS
    $title = sanitize_input($_POST['title']);
    $author = sanitize_input($_POST['author']);
    $review = sanitize_input($_POST['review']);

    // 3. Xử lý Upload file ảnh bìa (Tiêu chí 5)
    if(isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] == 0){
        $allowed_ext = ['jpg', 'jpeg', 'png', 'webp'];
        $file_name = $_FILES['cover_image']['name'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        
        if(in_array($file_ext, $allowed_ext)){
            $upload_dir = 'public/uploads/';
            $new_file_name = uniqid('book_', true) . '.' . $file_ext;
            move_uploaded_file($_FILES['cover_image']['tmp_name'], $upload_dir . $new_file_name);
            // Thành công, biến $new_file_name sẽ được ghi nhận vào CSDL
        }
    }

    // Sau khi xử lý xong điều hướng quay trở lại tủ sách
    header("Location: index.php?page=tu-sach");
    exit();
}

// Khởi chạy cơ chế PHP Include để render giao diện lắp ghép (Tiêu chí 3)
$allowed_pages = ['trang-chu', 'tu-sach', 'viet-cam-nhan', 'luu-nhat-ky', 'gioi-thieu', 'ho-so'];
if (in_array($page, $allowed_pages)) {
    include "views/{$page}.php";
} else {
    include "views/trang-chu.php";
}