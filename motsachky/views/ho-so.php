<?php
// 1. Khởi động phiên làm việc và bảo mật Session chống Hijacking
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Giả lập hoặc kết nối CSDL thực tế bằng PDO
$host = 'localhost';
$dbname = 'mot_sach_ky';
$username_db = 'root';
$password_db = '';
$pdo = null;

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username_db, $password_db, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    // Nếu chưa cấu hình DB, hệ thống sẽ chạy chế độ Demo an toàn để hiển thị giao diện
}

// Khởi tạo các biến thông báo lỗi / thành công
$error = '';
$success = '';

// Khởi tạo Token CSRF nếu chưa có để bảo vệ biểu mẫu mẫu chống tấn công giả mạo
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// 2. XỬ LÝ HÀNH ĐỘNG HẬU ĐÀI (POST METHODS)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Kiểm tra Token CSRF đề phòng lỗ hổng bảo mật cố ý giả mạo
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $error = 'Mã xác thực bảo mật (CSRF Token) không hợp lệ!';
    } else {
        $action = $_POST['action'] ?? '';

        // --- XỬ LÝ ĐĂNG KÝ TÀI KHOẢN ---
        if ($action === 'register') {
            $reg_user = trim($_POST['username'] ?? '');
            $reg_email = trim($_POST['email'] ?? '');
            $reg_pass = $_POST['password'] ?? '';

            if (empty($reg_user) || empty($reg_email) || empty($reg_pass)) {
                $error = 'Vui lòng điền đầy đủ tất cả các trường đăng ký!';
            } elseif (!filter_var($reg_email, FILTER_VALIDATE_EMAIL)) {
                $error = 'Định dạng Email không hợp lệ!';
            } elseif (strlen($reg_pass) < 6) {
                $error = 'Mật khẩu phải chứa ít nhất từ 6 ký tự trở lên!';
            } elseif ($pdo) {
                // Kiểm tra trùng lặp bằng Prepared Statement chặn hoàn toàn SQL Injection
                $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
                $stmt->execute([$reg_user, $reg_email]);
                if ($stmt->fetch()) {
                    $error = 'Tên tài khoản hoặc Email này đã tồn tại trên hệ thống!';
                } else {
                    // Mã hóa mật khẩu bằng thuật toán băm bảo mật cao BCRYPT
                    $hashed_password = password_hash($reg_pass, PASSWORD_BCRYPT);
                    $stmt = $pdo->prepare("INSERT INTO users (username, email, password, fullname, bio) VALUES (?, ?, ?, ?, ?)");
                    $stmt->execute([$reg_user, $reg_email, $hashed_password, 'Bùi Võ Quốc Bảo', 'Kỹ thuật Phần mềm B2208000 // ĐH Cần Thơ']);
                    $success = 'Đăng ký tài khoản thành công! Bạn có thể đăng nhập ngay.';
                }
            } else {
                // Chế độ chạy giả lập khi chưa kết nối CSDL thực tế
                $_SESSION['user'] = [
                    'username' => htmlspecialchars($reg_user),
                    'email' => htmlspecialchars($reg_email),
                    'fullname' => 'Bùi Võ Quốc Bảo',
                    'bio' => 'Kỹ thuật Phần mềm B2208000 // ĐH Cần Thơ'
                ];
                $success = 'Chế độ Demo: Đăng ký và Đăng nhập giả lập thành công!';
            }
        }

        // --- XỬ LÝ ĐĂNG NHẬP TÀI KHOẢN ---
        if ($action === 'login') {
            $login_input = trim($_POST['login_input'] ?? '');
            $login_pass = $_POST['password'] ?? '';

            if (empty($login_input) || empty($login_pass)) {
                $error = 'Vui lòng nhập tài khoản/email và mật khẩu!';
            } elseif ($pdo) {
                // Hỗ trợ đăng nhập linh hoạt bằng cả Username hoặc Email chặn SQL Injection
                $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
                $stmt->execute([$login_input, $login_input]);
                $user = $stmt->fetch();

                if ($user && password_verify($login_pass, $user['password'])) {
                    // Tái tạo lại Session ID nhằm chống lỗi tấn công Session Fixation
                    session_regenerate_id(true);
                    $_SESSION['user'] = $user;
                } else {
                    $error = 'Tài khoản hoặc mật khẩu xác thực không chính xác!';
                }
            } else {
                // Chế độ giả lập đăng nhập nhanh phục vụ việc hiển thị giao diện tức thì
                if (($login_input === 'admin' || $login_input === 'bao@gmail.com') && $login_pass === '123456') {
                    $_SESSION['user'] = [
                        'username' => 'bao_bui',
                        'email' => 'bao@gmail.com',
                        'fullname' => 'Bùi Võ Quốc Bảo',
                        'bio' => 'Kỹ thuật Phần mềm B2208000 // ĐH Cần Thơ'
                    ];
                } else {
                    $error = 'Tài khoản Demo thử nghiệm là: admin / Mật khẩu: 123456';
                }
            }
        }
    }
}

// --- XỬ LÝ ĐĂNG XUẤT ---
if (isset($_GET['act']) && $_GET['act'] === 'logout') {
    $_SESSION = [];
    session_destroy();
    header('Location: index.php?page=ho-so');
    exit;
}

// Nạp file giao diện header dùng chung của hệ thống MVC
include 'partials/header.php';
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Mọt Sách Ký - Hồ Sơ Cá Nhân</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body { background-color: #121212; color: #e0e0e0; font-family: 'Segoe UI', sans-serif; }
        .gold-text { color: #dfb76c !important; }
        .gold-bg { background-color: #dfb76c !important; color: #121212 !important; }
        .card-custom { background-color: #161616; border: 1px solid #262626; border-radius: 6px; }
        
        /* Cấu trúc Form Đăng nhập / Đăng ký */
        .auth-container { max-width: 450px; margin: 60px auto; }
        .form-control-custom { background-color: #111; border: 1px solid #2d2d2d; color: #fff; font-size: 0.85rem; padding: 11px 14px; border-radius: 4px; }
        .form-control-custom:focus { background-color: #141414; border-color: #dfb76c; color: #fff; box-shadow: none; }
        .auth-tab-btn { background: transparent; border: none; color: #666; font-size: 1rem; font-weight: bold; padding: 10px 20px; text-transform: uppercase; }
        .auth-tab-btn.active { color: #dfb76c; border-bottom: 2px solid #dfb76c; }

        /* CSS Giao diện Dashboard chính chủ theo ảnh thiết kế */
        .profile-avatar-box { background-color: #dfb76c; color: #121212; width: 65px; height: 65px; border-radius: 4px; font-size: 1.8rem; font-weight: bold; display: flex; align-items: center; justify-content: center; font-family: 'Playfair Display', serif; }
        .profile-title-name { font-size: 1.25rem; font-weight: bold; color: #fff; }
        .profile-sub-title { font-size: 0.8rem; color: #888; margin-top: 2px; }
        .profile-badge-info { font-size: 0.78rem; color: #aaa; margin-top: 10px; display: flex; gap: 15px; }

        /* Các mục thành tích & huy chương đạt được */
        .badge-grid-item { background-color: #111; border: 1px solid #222; border-radius: 4px; padding: 15px; display: flex; gap: 15px; align-items: flex-start; }
        .badge-icon-wrap { background-color: #1a160e; border: 1px solid #3d331d; color: #dfb76c; width: 42px; height: 42px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0; }
        .badge-content-title { font-size: 0.85rem; font-weight: bold; color: #eee; display: flex; align-items: center; gap: 6px; }
        .badge-content-desc { font-size: 0.75rem; color: #666; line-height: 1.4; margin-top: 2px; }
        
        /* Tiến độ phần trăm mục tiêu năm */
        .progress-custom-bg { background-color: #222; height: 6px; border-radius: 10px; overflow: hidden; }
        .progress-custom-bar { background-color: #dfb76c; height: 100%; border-radius: 10px; }
    </style>
</head>
<body>

<div class="container my-5">
    
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger border-0 bg-danger bg-opacity-10 text-danger rounded-1 mx-auto mb-4 style-msg" style="max-width: 800px; font-size:0.85rem;">
            <i class="fa-solid fa-triangle-exclamation me-2"></i> <?php echo $error; ?>
        </div>
    <?php endif; ?>
    <?php if (!empty($success)): ?>
        <div class="alert alert-success border-0 bg-success bg-opacity-10 text-success rounded-1 mx-auto mb-4 style-msg" style="max-width: 800px; font-size:0.85rem;">
            <i class="fa-solid fa-circle-check me-2"></i> <?php echo $success; ?>
        </div>
    <?php endif; ?>

    <?php if (!isset($_SESSION['user'])): ?>
        <div class="card-custom auth-container p-4 shadow-sm">
            <div class="d-flex justify-content-center gap-3 mb-4 border-bottom border-secondary pb-2">
                <button type="button" class="auth-tab-btn active" onclick="switchAuthTab('login')">Đăng Nhập</button>
                <button type="button" class="auth-tab-btn" onclick="switchAuthTab('register')">Đăng Ký</button>
            </div>

            <form id="form-login" action="" method="POST">
                <input type="hidden" name="action" value="login">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                
                <div class="mb-3">
                    <label class="form-label text-muted small text-uppercase fw-bold" style="font-size:0.7rem;">Tên tài khoản hoặc Email</label>
                    <input type="text" name="login_input" class="form-control form-control-custom" placeholder="Nhập tên đăng nhập hoặc email..." required>
                </div>
                <div class="mb-4">
                    <label class="form-label text-muted small text-uppercase fw-bold" style="font-size:0.7rem;">Mật khẩu mã khóa</label>
                    <input type="password" name="password" class="form-control form-control-custom" placeholder="Nhập mật khẩu kiểm tra..." required>
                </div>
                <button type="submit" class="btn gold-bg w-100 text-uppercase fw-bold py-2" style="font-size:0.8rem; letter-spacing:0.5px;">Xác thực quyền hạn</button>
            </form>

            <form id="form-register" action="" method="POST" class="d-none">
                <input type="hidden" name="action" value="register">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                
                <div class="mb-3">
                    <label class="form-label text-muted small text-uppercase fw-bold" style="font-size:0.7rem;">Tên tài khoản độc giả (Username)</label>
                    <input type="text" name="username" class="form-control form-control-custom" placeholder="Ví dụ: bao_bui, hung_sach..." required>
                </div>
                <div class="mb-3">
                    <label class="form-label text-muted small text-uppercase fw-bold" style="font-size:0.7rem;">Thư điện tử liên kết (Email)</label>
                    <input type="email" name="email" class="form-control form-control-custom" placeholder="QuocBao@example.com..." required>
                </div>
                <div class="mb-4">
                    <label class="form-label text-muted small text-uppercase fw-bold" style="font-size:0.7rem;">Mật khẩu khởi tạo</label>
                    <input type="password" name="password" class="form-control form-control-custom" placeholder="Tối thiểu từ 6 ký tự bảo mật..." required>
                </div>
                <button type="submit" class="btn gold-bg w-100 text-uppercase fw-bold py-2" style="font-size:0.8rem; letter-spacing:0.5px;">Thiết lập tài khoản</button>
            </form>
            
            <div class="text-center mt-3 text-muted" style="font-size:0.72rem;">
                <i class="fa-solid fa-shield-halved text-warning"></i> Chế độ Sandbox: Nhập <b class="text-white">admin</b> / <b class="text-white">123456</b> để vào thẳng giao diện.
            </div>
        </div>

    <?php else: ?>
        <?php
            // Đề phòng lỗ hổng XSS bằng hàm xử lý thanh lọc dữ liệu đầu ra toàn diện htmlspecialchars
            $u_fullname = htmlspecialchars($_SESSION['user']['fullname'] ?? 'Mọt Sách Học Giả');
            $u_bio = htmlspecialchars($_SESSION['user']['bio'] ?? 'Thành viên tàng thư các');
        ?>
        
        <div class="card-custom p-4 mb-4 position-relative shadow-sm">
            <div class="d-flex align-items-center gap-3">
                <div class="profile-avatar-box">B</div>
                <div>
                    <div class="profile-title-name"><?php echo $u_fullname; ?> <span class="text-muted fw-normal" style="font-size:0.78rem; font-style:italic;">[Sửa đổi]</span></div>
                    <div class="profile-sub-title"><?php echo $u_bio; ?></div>
                    <div class="profile-badge-info">
                        <span><i class="fa-solid fa-book-open gold-text me-1"></i> Tác tuyển sở hữu: <strong class="text-white">6 quyển</strong></span>
                        <span><i class="fa-regular fa-clock gold-text me-1"></i> Học trình tích lũy: <strong class="text-white">185 phút</strong></span>
                    </div>
                </div>
            </div>
            <div class="position-absolute" style="top: 25px; right: 25px; display: flex; gap: 10px;">
                <a href="data.ts" download class="btn gold-bg fw-bold text-uppercase d-flex align-items-center gap-2 px-3 py-2" style="font-size: 0.72rem; border-radius: 4px;">
                    <i class="fa-solid fa-download"></i> Sao lưu tủ sách (JSON)
                </a>
                <a href="index.php?page=ho-so&act=logout" class="btn btn-outline-danger fw-bold text-uppercase d-flex align-items-center px-3 py-2" style="font-size: 0.72rem; border-radius: 4px;">
                    <i class="fa-solid fa-right-from-bracket me-1"></i> Thoát
                </a>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-4">
                <div class="card-custom p-4 h-100 text-center d-flex flex-column justify-content-center py-5">
                    <div class="d-flex justify-content-between align-items-center mb-4 border-bottom border-secondary pb-2">
                        <span class="text-muted text-uppercase tracking-wider font-monospace" style="font-size: 0.72rem;"><i class="fa-regular fa-compass me-1"></i> Mục Tiêu Năm</span>
                        <a href="#" class="text-muted text-uppercase text-decoration-none small" style="font-size:0.68rem; letter-spacing:0.5px;">Đặt Lại</a>
                    </div>
                    
                    <div class="gold-text my-3" style="font-size: 3.5rem; font-weight: bold; font-family: 'Playfair Display', serif;">25%</div>
                    
                    <p class="text-white px-2 mb-4" style="font-size: 0.82rem; line-height: 1.6;">
                        Đã hoàn thành <strong class="gold-text">3 tác phẩm</strong> trong tổng niên giám chỉ tiêu <strong class="text-decoration-underline">12 quyển</strong> của năm nay!
                    </p>
                    
                    <div class="progress-custom-bg mb-4 mx-2">
                        <div class="progress-custom-bar" style="width: 25%;"></div>
                    </div>
                    
                    <div class="text-muted italic px-2 mt-2" style="font-size: 0.7rem; font-style: italic;">
                        Bạn cần vượt qua thêm 9 tuyển thư để chạm tới vạch hoàn thành!
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card-custom p-4 h-100">
                    <div class="d-flex justify-content-between align-items-center mb-4 border-bottom border-secondary pb-2">
                        <span class="text-muted text-uppercase tracking-wider font-monospace" style="font-size: 0.72rem;"><i class="fa-solid fa-award me-1"></i> Huy Chương Đạt Được</span>
                        <span class="text-muted text-uppercase small font-monospace" style="font-size:0.65rem; letter-spacing: 0.5px;">Bản Ghi Danh Vọng</span>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="badge-grid-item">
                                <div class="badge-icon-wrap"><i class="fa-solid fa-book"></i></div>
                                <div>
                                    <div class="badge-content-title">Mọt Sách Tập Sự <i class="fa-solid fa-circle-check text-success" style="font-size: 0.75rem;"></i></div>
                                    <div class="badge-content-desc">Thêm ít nhất 3 cuốn sách vào tủ ký họa thành công. <br><span class="text-muted">Yêu cầu: Sở hữu >= 3 đầu sách</span></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="badge-grid-item">
                                <div class="badge-icon-wrap"><i class="fa-solid fa-graduation-cap"></i></div>
                                <div>
                                    <div class="badge-content-title">Học Giả Bách Khoa <i class="fa-solid fa-circle-check text-success" style="font-size: 0.75rem;"></i></div>
                                    <div class="badge-content-desc">Thêm sách thuộc ít nhất 3 chủ đề thể loại khác nhau. <br><span class="text-muted">Yêu cầu: Sở hữu >= 3 thể loại</span></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="badge-grid-item">
                                <div class="badge-icon-wrap"><i class="fa-regular fa-clock"></i></div>
                                <div>
                                    <div class="badge-content-title">Kẻ Trộm Thời Gian <i class="fa-solid fa-circle-check text-success" style="font-size: 0.75rem;"></i></div>
                                    <div class="badge-content-desc">Ghi chép nhật ký hành trình đọc sách tích lũy trên 120... <br><span class="text-muted">Yêu cầu: Tích lũy >= 120 phút đọc</span></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="badge-grid-item">
                                <div class="badge-icon-wrap"><i class="fa-solid fa-feather-pointed"></i></div>
                                <div>
                                    <div class="badge-content-title">Kiên Trì Đoạt Chí <i class="fa-solid fa-circle-check text-success" style="font-size: 0.75rem;"></i></div>
                                    <div class="badge-content-desc">Đọc trọn vẹn và đánh dấu hoàn thành 3 cuốn sách. <br><span class="text-muted">Yêu cầu: Hoàn thành >= 3 sách</span></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="badge-grid-item">
                                <div class="badge-icon-wrap"><i class="fa-solid fa-pen-fancy"></i></div>
                                <div>
                                    <div class="badge-content-title">Khơi Thông Bể Khổ <i class="fa-solid fa-circle-check text-success" style="font-size: 0.75rem;"></i></div>
                                    <div class="badge-content-desc">Viết ít nhất 5 dòng cảm hứng nổi bật trong thư viện... <br><span class="text-muted">Yêu cầu: Có >= 5 câu trích dẫn yêu thích</span></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="badge-grid-item">
                                <div class="badge-icon-wrap"><i class="fa-solid fa-user-shield"></i></div>
                                <div>
                                    <div class="badge-content-title">Kỹ Sư An Toàn <i class="fa-solid fa-circle-check text-success" style="font-size: 0.75rem;"></i></div>
                                    <div class="badge-content-desc">Thử nghiệm cơ chế ngăn chặn tấn công XSS hoặc... <br><span class="text-muted">Yêu cầu: Chọc phá Lab bảo mật hệ thống</span></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    <?php endif; ?>

</div>

<script>
function switchAuthTab(type) {
    const btnLogin = document.querySelectorAll('.auth-tab-btn')[0];
    const btnRegister = document.querySelectorAll('.auth-tab-btn')[1];
    const formLogin = document.getElementById('form-login');
    const formRegister = document.getElementById('form-register');

    if (type === 'login') {
        btnLogin.classList.add('active');
        btnRegister.classList.remove('active');
        formLogin.classList.remove('none', 'd-none');
        formRegister.classList.add('d-none');
    } else {
        btnRegister.classList.add('active');
        btnLogin.classList.remove('active');
        formRegister.classList.remove('none', 'd-none');
        formLogin.classList.add('d-none');
    }
}
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php 
// Nạp tệp tin footer dùng chung để giữ kết cấu giao diện nguyên vẹn
include 'partials/footer.php'; 
?>