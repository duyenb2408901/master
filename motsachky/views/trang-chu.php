<?php 
// Nếu tích hợp MVC thì dùng include, nếu chạy file độc lập bạn có thể tạm đóng 2 dòng này lại
include 'partials/header.php'; 
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mọt Sách Ký - Trang Chủ</title>
    <!-- Bootstrap 5 & FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Chart.js để vẽ biểu đồ thống kê như hình mẫu -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        body { background-color: #121212; color: #e0e0e0; font-family: 'Segoe UI', sans-serif; }
        .gold-text { color: #dfb76c !important; }
        .gold-bg { background-color: #dfb76c !important; color: #121212 !important; }
        .gold-border { border-color: #dfb76c !important; }
        .card-custom { background-color: #1a1a1a; border: 1px solid #2d2d2d; border-radius: 6px; }
        
        /* Hero Section Custom (Hình image_fdd9dc.png) */
        .hero-section {
            background: linear-gradient(145deg, #161616 0%, #1c150b 100%);
            border: 1px solid #2d2d2d;
            border-radius: 8px;
            position: relative;
            overflow: hidden;
        }
        .hero-vector {
            position: absolute; right: 5%; bottom: 0; width: 35%; opacity: 0.25; pointer-events: none;
        }
        .btn-outline-gold {
            color: #dfb76c; border: 1px solid #dfb76c; background: transparent;
        }
        .btn-outline-gold:hover {
            background-color: #dfb76c; color: #121212;
        }
        
        /* Stats Widget (Hình image_fdd9dc.png) */
        .stat-box { background-color: #161616; border: 1px solid #262626; border-radius: 4px; padding: 15px; }
        .stat-icon { background-color: #221d14; color: #dfb76c; padding: 10px; border-radius: 4px; border: 1px solid #3d331d; }
        
        /* Progress Bar (Hình image_fdd6fa.png) */
        .progress-custom { background-color: #2d2d2d; height: 6px; border-radius: 3px; }
        .progress-bar-gold { background-color: #dfb76c; }
        .btn-action { background-color: #222; border: 1px solid #3a3a3a; color: #ccc; font-size: 0.8rem; padding: 4px 12px; transition: 0.2s; }
        .btn-action:hover { border-color: #dfb76c; color: #dfb76c; }
    </style>
</head>
<body>

<div class="container my-4">

    <!-- ================= SECTION 1: HERO JUMBOTRON (Hình image_fdd9dc.png) ================= -->
    <div class="hero-section p-5 mb-4 position-relative">
        <div class="row align-items-center">
            <div class="col-lg-8 z-3">
                <small class="text-uppercase text-muted tracking-wide" style="font-size: 0.75rem; letter-spacing: 2px;">Tác phẩm của tháng & Chào mừng độc giả</small>
                <h1 class="display-4 fw-bold gold-text my-3" style="font-family: 'Playfair Display', serif; font-style: italic;">Khai Phòng Tàng Thư</h1>
                <p class="text-muted fst-italic mb-4" style="max-width: 600px; font-size: 1.05rem;">
                    “Sách là chiếc tàu thám hiểm của những tâm hồn khao khát tri thức. Một bản đồ dẫn lối cho tâm hồn hiếu học người đọc.” Hôm nay bạn có những ý niệm tâm đắc nào cần ghi khắc?
                </p>
                <div class="d-flex gap-3">
                    <a href="index.php?page=viet-cam-nhan" class="btn gold-bg fw-bold px-4 py-2 text-uppercase" style="font-size: 0.85rem;">Ghi thêm sách mới</a>
                    <a href="index.php?page=luu-nhat-ky" class="btn btn-outline-gold fw-bold px-4 py-2 text-uppercase" style="font-size: 0.85rem;">Kích hoạt bấm giờ đọc</a>
                </div>
            </div>
        </div>
        <!-- Đường cong vẽ trang trí bên phải giả lập bằng SVG vector -->
        <svg class="hero-vector d-none d-lg-block" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
            <path d="M10,180 Q60,60 180,20" fill="none" stroke="#dfb76c" stroke-width="2" stroke-dasharray="4"/>
            <circle cx="180" cy="20" r="6" fill="#dfb76c"/>
        </svg>
    </div>


    <!-- ================= SECTION 2: BẢNG SỐ LIỆU TÓM TẮT (Hình image_fdd9dc.png) ================= -->
    <div class="row g-3 mb-4">
        <div class="col-md-3 col-6">
            <div class="stat-box d-flex justify-content-between align-items-center">
                <div>
                    <small class="text-muted text-uppercase d-block" style="font-size: 0.7rem;">Tủ sách tàng thư</small>
                    <span class="display-6 fw-bold text-white">6</span>
                </div>
                <div class="stat-icon"><i class="fa-solid fa-book-bookmark"></i></div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="stat-box d-flex justify-content-between align-items-center">
                <div>
                    <small class="text-muted text-uppercase d-block" style="font-size: 0.7rem;">Đã đọc xong</small>
                    <span class="display-6 fw-bold text-white">3 <span class="text-muted" style="font-size: 1.1rem;">/ 6</span></span>
                </div>
                <div class="stat-icon"><i class="fa-solid fa-graduation-cap"></i></div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="stat-box d-flex justify-content-between align-items-center">
                <div>
                    <small class="text-muted text-uppercase d-block" style="font-size: 0.7rem;">Chuỗi độc bản</small>
                    <span class="display-6 fw-bold text-white">12 <span class="gold-text" style="font-size: 0.9rem;">NGÀY</span></span>
                </div>
                <div class="stat-icon"><i class="fa-solid fa-fire"></i></div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="stat-box d-flex justify-content-between align-items-center">
                <div>
                    <small class="text-muted text-uppercase d-block" style="font-size: 0.7rem;">Thời đọc tích lũy</small>
                    <span class="display-6 fw-bold text-white">185 <span class="text-muted" style="font-size: 0.9rem;">PHÚT</span></span>
                </div>
                <div class="stat-icon"><i class="fa-solid fa-hourglass-start"></i></div>
            </div>
        </div>
    </div>


    <!-- ================= SECTION 3: BIỂU ĐỒ THỐNG KÊ (Hình image_fdd719.png) ================= -->
    <div class="row g-4 mb-5">
        <!-- Biểu đồ đường diện tích bên trái -->
        <div class="col-lg-7">
            <div class="card-custom p-4 h-100">
                <canvas id="lineChart" style="max-height: 280px;"></canvas>
            </div>
        </div>
        <!-- Biểu đồ hình tròn phân loại bên phải -->
        <div class="col-lg-5">
            <div class="card-custom p-4 h-100 d-flex flex-column justify-content-center">
                <div class="row align-items-center">
                    <div class="col-6">
                        <canvas id="donutChart" style="max-height: 200px;"></canvas>
                    </div>
                    <div class="col-6">
                        <ul class="list-unstyled mb-0" style="font-size: 0.85rem;">
                            <li class="mb-2"><i class="fa-solid fa-circle me-2" style="color: #6f42c1;"></i> Tâm lý & Kỹ năng <span class="float-end text-muted">2 quyển</span></li>
                            <li class="mb-2"><i class="fa-solid fa-circle me-2" style="color: #20c997;"></i> Khoa học & Vũ trụ <span class="float-end text-muted">1 quyển</span></li>
                            <li class="mb-2"><i class="fa-solid fa-circle me-2" style="color: #ffc107;"></i> Lịch sử & Triết học <span class="float-end text-muted">1 quyển</span></li>
                            <li class="mb-2"><i class="fa-solid fa-circle me-2" style="color: #e83e8c;"></i> Tiểu thuyết & Văn học <span class="float-end text-muted">1 quyển</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- ================= SECTION 4: TIẾN TRÌNH NGHIÊN CỨU (Hình image_fdd6fa.png) ================= -->
    <div class="mb-4">
        <div class="d-flex justify-content-between align-items-end mb-3">
            <div>
                <h4 class="gold-text mb-1" style="font-family: 'Playfair Display', serif; font-style: italic;">Tiến Trình Nghiên Cứu</h4>
                <small class="text-muted text-uppercase" style="font-size: 0.7rem; letter-spacing: 1px;">Cập nhật nhanh trang đọc của bạn</small>
            </div>
            <a href="index.php?page=tu-sach" class="text-white text-decoration-none fw-bold small text-uppercase" style="font-size: 0.75rem; letter-spacing: 1px;">Xem tất cả tàng thư <i class="fa-solid fa-chevron-right ms-1" style="font-size: 0.65rem;"></i></a>
        </div>

        <div class="row g-3">
            <!-- Sách 1 -->
            <div class="col-md-6">
                <div class="card-custom p-3">
                    <div class="d-flex gap-3">
                        <img src="https://images.unsplash.com/photo-1544949750-fa07a98d237f?auto=format&fit=crop&q=80&w=120" alt="Đắc Nhân Tâm" class="rounded border border-secondary" style="width: 75px; height: 105px; object-fit: cover;">
                        <div class="flex-grow-1">
                            <span class="badge bg-dark text-warning border border-warning px-2 py-1 mb-2" style="font-size: 0.65rem;">ĐANG ĐỌC</span>
                            <h6 class="mb-0 fw-bold">Lược Sử Loài Người (Sapiens)</h6>
                            <small class="text-muted d-block mb-2">Yuval Noah Harari</small>
                            <small class="text-muted d-block mb-1" style="font-size: 0.75rem;">310 / 560 trang <span class="float-end gold-text">55%</span></small>
                            <div class="progress progress-custom mb-3">
                                <div class="progress-bar progress-bar-gold" style="width: 55%"></div>
                            </div>
                            <div class="d-flex gap-2">
                                <button class="btn btn-action rounded"><i class="fa-solid fa-pen me-1"></i> NHẬP TRANG</button>
                                <button class="btn btn-action rounded">+10 TRANG</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sách 2 -->
            <div class="col-md-6">
                <div class="card-custom p-3">
                    <div class="d-flex gap-3">
                        <img src="https://images.unsplash.com/photo-1512820790803-83ca734da794?auto=format&fit=crop&q=80&w=120" alt="Vũ trụ" class="rounded border border-secondary" style="width: 75px; height: 105px; object-fit: cover;">
                        <div class="flex-grow-1">
                            <span class="badge bg-dark text-warning border border-warning px-2 py-1 mb-2" style="font-size: 0.65rem;">ĐANG ĐỌC</span>
                            <h6 class="mb-0 fw-bold">Vũ Trụ (Cosmos)</h6>
                            <small class="text-muted d-block mb-2">Carl Sagan</small>
                            <small class="text-muted d-block mb-1" style="font-size: 0.75rem;">120 / 480 trang <span class="float-end gold-text">25%</span></small>
                            <div class="progress progress-custom mb-3">
                                <div class="progress-bar progress-bar-gold" style="width: 25%"></div>
                            </div>
                            <div class="d-flex gap-2">
                                <button class="btn btn-action rounded"><i class="fa-solid fa-pen me-1"></i> NHẬP TRANG</button>
                                <button class="btn btn-action rounded">+10 TRANG</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- ================= SCRIPT VẼ CHART GRAPH (Hình image_fdd719.png) ================= -->
<script>
    // 1. Khởi tạo biểu đồ miền sóng nước (Line Area Chart)
    const ctxLine = document.getElementById('lineChart').getContext('2d');
    
    // Tạo màu gradient vàng nhạt đổ xuống dưới đáy như trong hình
    const goldGradient = ctxLine.createLinearGradient(0, 0, 0, 250);
    goldGradient.addColorStop(0, 'rgba(223, 183, 108, 0.3)');
    goldGradient.addColorStop(1, 'rgba(223, 183, 108, 0.0)');

    new Chart(ctxLine, {
        type: 'line',
        data: {
            labels: ['04-12', '05-02', '05-25', '06-10'],
            datasets: [{
                data: [45, 58, 32, 52],
                borderColor: '#dfb76c',
                borderWidth: 2,
                backgroundColor: goldGradient,
                fill: true,
                tension: 0.4, // Làm mượt đường cong
                pointRadius: 0 // Ẩn các điểm nút chấm tròn
            }]
        },
        options: {
            plugins: { legend: { display: false } },
            scales: {
                x: { grid: { display: false }, ticks: { color: '#777' } },
                y: { 
                    min: 0, max: 60,
                    ticks: { stepSize: 15, color: '#777' },
                    grid: { color: '#222' }
                }
            }
        }
    });

    // 2. Khởi tạo biểu đồ hình tròn khuyết tâm (Donut Chart)
    const ctxDonut = document.getElementById('donutChart').getContext('2d');
    new Chart(ctxDonut, {
        type: 'doughnut',
        data: {
            datasets: [{
                data: [2, 1, 1, 1],
                backgroundColor: ['#6f42c1', '#20c997', '#ffc107', '#e83e8c'],
                borderWidth: 2,
                borderColor: '#1a1a1a'
            }]
        },
        options: {
            cutout: '70%', // Tạo độ rỗng ở tâm
            plugins: { legend: { display: false } }
        }
    });
</script>

</body>
</html>

<?php 
include 'partials/footer.php'; 
?>