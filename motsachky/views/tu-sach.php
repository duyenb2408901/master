<?php 
// Nếu tích hợp hệ thống MVC, file này sẽ tự nạp header.php chứa navbar dùng chung
include 'partials/header.php'; 
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mọt Sách Ký - Tủ Kỳ Bản Sách</title>
    <!-- Bootstrap 5 & FontAwesome Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body { background-color: #121212; color: #e0e0e0; font-family: 'Segoe UI', sans-serif; }
        .gold-text { color: #dfb76c !important; }
        .gold-bg { background-color: #dfb76c !important; color: #121212 !important; }
        .card-custom { background-color: #1a1a1a; border: 1px solid #2d2d2d; border-radius: 6px; }
        
        /* Tiêu đề trang */
        .page-title { font-family: 'Playfair Display', serif; font-style: italic; }
        
        /* Bộ lọc Sidebar */
        .filter-title { font-size: 0.9rem; font-weight: bold; letter-spacing: 1px; color: #dfb76c; }
       
.form-label-custom { font-size: 0.75rem; text-transform: uppercase; color: #777; letter-spacing: 0.5px; margin-bottom: 5px; }
        .form-control-custom { background-color: #161616; border: 1px solid #333; color: #fff; font-size: 0.85rem; }
        .form-control-custom:focus { background-color: #1c1c1c; border-color: #dfb76c; color: #fff; box-shadow: none; }
        
        /* Book Card Style */
        .book-card { background-color: #161616; border: 1px solid #262626; border-radius: 4px; padding: 15px; position: relative; }
        .book-cover-container { position: relative; width: 85px; height: 120px; flex-shrink: 0; }
        .book-cover { width: 100%; height: 100%; object-fit: cover; border-radius: 3px; border: 1px solid #333; }
        .rating-badge { position: absolute; bottom: 4px; right: 4px; background: rgba(0,0,0,0.75); color: #dfb76c; font-size: 0.65rem; padding: 2px 5px; border-radius: 2px; font-weight: bold; }
        
        /* Nhãn trạng thái & Thể loại */
        .genre-badge { font-size: 0.65rem; padding: 3px 8px; border-radius: 3px; font-weight: 500; display: inline-block; }
        .status-btn { font-size: 0.75rem; padding: 3px 10px; border-radius: 4px; font-weight: 500; border: none; display: inline-flex; align-items: center; gap: 5px; }
        
        /* Tiến trình */
        .progress-custom { background-color: #262626; height: 4px; border-radius: 2px; }
        .progress-bar-gold { background-color: #dfb76c; }
        
        /* Nút xóa */
        .btn-delete { color: #555; position: absolute; top: 15px; right: 15px; transition: color 0.2s; background: none; border: none; padding: 0; }
        .btn-delete:hover { color: #ea868f; }
    </style>
</head>
<body>

<div class="container my-4">

    <!-- ================= THANH TIÊU ĐỀ TRÊN ĐẦU (Hình image_fdd354.png) ================= -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="page-title gold-text mb-1">Tủ Kỳ Bản Sách</h3>
            <small class="text-muted text-uppercase tracking-wider" style="font-size: 0.7rem; letter-spacing: 1px;">Danh mục tàng thư biệt bộ, ghi chú cảm xúc tri thức độc bản của bạn</small>
        </div>
        <a href="index.php?page=viet-cam-nhan" class="btn gold-bg fw-bold px-3 py-2 text-uppercase d-flex align-items-center gap-2" style="font-size: 0.8rem; border-radius: 4px;">
            <i class="fa-solid fa-circle-plus"></i> Khai kỳ sách mới
        </a>
    </div>

    <!-- ================= BỐ CỤC CHÍNH: BỘ LỌC & DANH SÁCH SÁCH ================= -->
    <div class="row g-4">
        
        <!-- CỘT TRÁI: BỘ SÀNG LỌC BẢN THƯ (Sidebar Filter) -->
        <div class="col-lg-3">
            <div class="card-custom p-4">
                <div class="filter-title mb-4 text-uppercase d-flex align-items-center gap-2">
                    <i class="fa-solid fa-filter"></i> Sàng lọc bản thư
                </div>
                
                <!-- Tra cứu tên sách -->
                <div class="mb-4">
                    <label class="form-label-custom">Tra cứu tên sách, tác giả</label>
                    <div class="position-relative">
                        <input type="text" class="form-control form-control-custom ps-4" placeholder="Nhập từ cần tìm...">
                        <i class="fa-solid fa-magnifying-glass text-muted position-absolute top-50 start-2 translate-middle-y" style="font-size: 0.75rem; left: 10px !important;"></i>
                    </div>
                </div>

                <!-- Chủ đề thể loại -->
                <div class="mb-4">
                    <label class="form-label-custom">Chủ đề thể loại</label>
                    <select class="form-select form-control-custom">
                        <option selected>Tất cả thể loại</option>
                        <option>Tâm lý & Kỹ năng</option>
                        <option>Khoa học & Vũ trụ</option>
                        <option>Lịch sử & Triết học</option>
                        <option>Tiểu thuyết & Văn học</option>
                        <option>Kinh tế & Đầu tư</option>
                    </select>
                </div>

                <!-- Tình trạng đọc -->
                <div class="mb-2">
                    <label class="form-label-custom">Tình trạng đọc</label>
                    <select class="form-select form-control-custom mb-3">
                        <option selected>Tất cả tình trạng</option>
                        <option>Đang đọc</option>
                        <option>Đã đọc xong</option>
                        <option>Ước đọc (Chờ)</option>
                    </select>
                </div>
                
                <div class="form-check small text-muted">
                    <input class="form-check-input bg-dark border-secondary" type="checkbox" id="dangdoc" checked>
                    <label class="form-check-label" for="dangdoc">Dang đọc ▮</label>
                </div>
            </div>
        </div>

        <!-- CỘT PHẢI: LƯỚI TÀNG THƯ DANH SÁCH (6 quyển sách như hình) -->
        <div class="col-lg-9">
            <div class="row g-3">
                
                <!-- Quyển 1: Đắc Nhân Tâm -->
                <div class="col-md-6">
                    <div class="book-card d-flex gap-3 align-items-start">
                        <div class="book-cover-container">
                            <img src="https://images.unsplash.com/photo-1544949750-fa07a98d237f?auto=format&fit=crop&q=80&w=120" class="book-cover" alt="Đắc Nhân Tâm">
                            <span class="rating-badge"><i class="fa-solid fa-star me-1" style="font-size:0.6rem;"></i>5.0</span>
                        </div>
                        <div class="flex-grow-1">
                            <span class="genre-badge mb-2" style="background-color: #221d14; color: #dfb76c; border: 1px solid #3d331d;">Tâm lý & Kỹ năng</span>
                            <h6 class="mb-1 fw-bold text-white text-truncate" style="max-width: 220px;">Đắc Nhân Tâm</h6>
                            <small class="text-muted d-block mb-3">Dale Carnegie</small>
                            <span class="status-btn bg-success-subtle text-success"><i class="fa-regular fa-circle-check"></i> Đã đọc xong</span>
                        </div>
                        <button class="btn-delete"><i class="fa-regular fa-trash-can"></i></button>
                    </div>
                    <div class="mt-2 px-1 d-flex justify-content-between align-items-center" style="font-size: 0.75rem; color: #666;">
                        <span>320 / 320 trang</span>
                        <span>100%</span>
                    </div>
                    <div class="progress progress-custom mt-1"><div class="progress-bar progress-bar-gold" style="width: 100%"></div></div>
                </div>

                <!-- Quyển 2: Lược Sử Loài Người -->
                <div class="col-md-6">
                    <div class="book-card d-flex gap-3 align-items-start">
                        <div class="book-cover-container">
                            <img src="https://images.unsplash.com/photo-1512820790803-83ca734da794?auto=format&fit=crop&q=80&w=120" class="book-cover" alt="Sapiens">
                            <span class="rating-badge"><i class="fa-solid fa-star me-1" style="font-size:0.6rem;"></i>5.0</span>
                        </div>
                        <div class="flex-grow-1">
                            <span class="genre-badge mb-2" style="background-color: #1a231a; color: #7cb342; border: 1px solid #2e4c1e;">Lịch sử & Triết học</span>
                            <h6 class="mb-1 fw-bold text-white text-truncate" style="max-width: 220px;">Lược Sử Loài Người (Sapiens)</h6>
                            <small class="text-muted d-block mb-3">Yuval Noah Harari</small>
                            <span class="status-btn" style="background-color: #272115; color: #ffb300;"><i class="fa-solid fa-circle-notch fa-spin" style="font-size:0.65rem;"></i> Đang đọc: 55%</span>
                        </div>
                        <button class="btn-delete"><i class="fa-regular fa-trash-can"></i></button>
                    </div>
                    <div class="mt-2 px-1 d-flex justify-content-between align-items-center" style="font-size: 0.75rem; color: #666;">
                        <span>310 / 560 trang</span>
                        <span>55%</span>
                    </div>
                    <div class="progress progress-custom mt-1"><div class="progress-bar progress-bar-gold" style="width: 55%"></div></div>
                </div>

                <!-- Quyển 3: Nhà Giả Kim -->
                <div class="col-md-6">
                    <div class="book-card d-flex gap-3 align-items-start">
                        <div class="book-cover-container">
                            <img src="https://images.unsplash.com/photo-1543002588-bfa74002ed7e?auto=format&fit=crop&q=80&w=120" class="book-cover" alt="Nhà giả kim">
                            <span class="rating-badge"><i class="fa-solid fa-star me-1" style="font-size:0.6rem;"></i>4.0</span>
                        </div>
                        <div class="flex-grow-1">
                            <span class="genre-badge mb-2" style="background-color: #1a1f2c; color: #8bc34a; border: 1px solid #1f382b;">Tiểu thuyết & Văn học</span>
                            <h6 class="mb-1 fw-bold text-white text-truncate" style="max-width: 220px;">Nhà Giả Kim</h6>
                            <small class="text-muted d-block mb-3">Paulo Coelho</small>
                            <span class="status-btn bg-success-subtle text-success"><i class="fa-regular fa-circle-check"></i> Đã đọc xong</span>
                        </div>
                        <button class="btn-delete"><i class="fa-regular fa-trash-can"></i></button>
                    </div>
                    <div class="mt-2 px-1 d-flex justify-content-between align-items-center" style="font-size: 0.75rem; color: #666;">
                        <span>220 / 220 trang</span>
                        <span>100%</span>
                    </div>
                    <div class="progress progress-custom mt-1"><div class="progress-bar progress-bar-gold" style="width: 100%"></div></div>
                </div>

                <!-- Quyển 4: Vũ Trụ (Cosmos) -->
                <div class="col-md-6">
                    <div class="book-card d-flex gap-3 align-items-start">
                        <div class="book-cover-container">
                            <img src="https://images.unsplash.com/photo-1451187580459-43490279c0fa?auto=format&fit=crop&q=80&w=120" class="book-cover" alt="Vũ trụ">
                            <span class="rating-badge"><i class="fa-solid fa-star me-1" style="font-size:0.6rem;"></i>5.0</span>
                        </div>
                        <div class="flex-grow-1">
                            <span class="genre-badge mb-2" style="background-color: #16242c; color: #00bcd4; border: 1px solid #143547;">Khoa học & Vũ trụ</span>
                            <h6 class="mb-1 fw-bold text-white text-truncate" style="max-width: 220px;">Vũ Trụ (Cosmos)</h6>
                            <small class="text-muted d-block mb-3">Carl Sagan</small>
                            <span class="status-btn" style="background-color: #272115; color: #ffb300;"><i class="fa-solid fa-circle-notch fa-spin" style="font-size:0.65rem;"></i> Đang đọc: 25%</span>
                        </div>
                        <button class="btn-delete"><i class="fa-regular fa-trash-can"></i></button>
                    </div>
                    <!-- Thanh tiến trình ẩn/mờ theo hình hoặc hiện tương ứng % -->
                    <div class="mt-2 px-1 d-flex justify-content-between align-items-center" style="font-size: 0.75rem; color: #666;">
                        <span>120 / 480 trang</span>
                        <span>25%</span>
                    </div>
                    <div class="progress progress-custom mt-1"><div class="progress-bar progress-bar-gold" style="width: 25%"></div></div>
                </div>

                <!-- Quyển 5: Nghĩ Giàu Và Làm Giàu -->
                <div class="col-md-6">
                    <div class="book-card d-flex gap-3 align-items-start">
                        <div class="book-cover-container">
                            <img src="https://images.unsplash.com/photo-1589829545856-d10d557cf95f?auto=format&fit=crop&q=80&w=120" class="book-cover" alt="Think & Grow Rich">
                            <span class="rating-badge"><i class="fa-solid fa-star me-1" style="font-size:0.6rem;"></i>4.8</span>
                        </div>
                        <div class="flex-grow-1">
                            <span class="genre-badge mb-2" style="background-color: #2c2514; color: #ff9800; border: 1px solid #4a3b1a;">Kinh tế & Đầu tư</span>
                            <h6 class="mb-1 fw-bold text-white text-truncate" style="max-width: 220px;">Nghĩ Giàu Và Làm Giàu</h6>
                            <small class="text-muted d-block mb-3">Napoleon Hill</small>
                            <span class="status-btn text-muted" style="background-color: #222;"><i class="fa-regular fa-clock"></i> Ước đọc (Chờ)</span>
                        </div>
                        <button class="btn-delete"><i class="fa-regular fa-trash-can"></i></button>
                    </div>
                </div>

                <!-- Quyển 6: Tuổi Trẻ Đáng Giá Bao Nhiêu -->
                <div class="col-md-6">
                    <div class="book-card d-flex gap-3 align-items-start">
                        <div class="book-cover-container">
                            <img src="https://images.unsplash.com/photo-1516979187457-637abb4f9353?auto=format&fit=crop&q=80&w=120" class="book-cover" alt="Tuổi trẻ đáng giá bao nhiêu">
                            <span class="rating-badge"><i class="fa-solid fa-star me-1" style="font-size:0.6rem;"></i>5.0</span>
                        </div>
                        <div class="flex-grow-1">
                            <span class="genre-badge mb-2" style="background-color: #221d14; color: #dfb76c; border: 1px solid #3d331d;">Tâm lý & Kỹ năng</span>
                            <h6 class="mb-1 fw-bold text-white text-truncate" style="max-width: 220px;">Tuổi Trẻ Đáng Giá Bao Nhiêu?</h6>
                            <small class="text-muted d-block mb-3">Rosie Nguyễn</small>
                            <span class="status-btn bg-success-subtle text-success"><i class="fa-regular fa-circle-check"></i> Đã đọc xong</span>
                        </div>
                        <button class="btn-delete"><i class="fa-regular fa-trash-can"></i></button>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php 
// Nạp footer chung đóng thẻ body và html
include 'partials/footer.php'; 
?>