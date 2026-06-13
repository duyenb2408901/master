<?php 
// Kết hợp hệ thống MVC, nạp header.php chứa navbar dùng chung
include 'partials/header.php'; 
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mọt Sách Ký - Khai Bản Khải Sách</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body { background-color: #121212; color: #e0e0e0; font-family: 'Segoe UI', sans-serif; }
        .gold-text { color: #dfb76c !important; }
        .gold-bg { background-color: #dfb76c !important; color: #121212 !important; }
        .gold-border { border-color: #dfb76c !important; }
        .card-custom { background-color: #161616; border: 1px solid #262626; border-radius: 6px; }
        
        /* Typography */
        .page-title { font-family: 'Playfair Display', serif; font-style: italic; }
        .section-title { font-size: 0.85rem; color: #dfb76c; font-weight: bold; letter-spacing: 1px; text-transform: uppercase; margin-bottom: 12px; }
        
        /* Form Inputs */
        .form-label-custom { font-size: 0.75rem; font-weight: 600; text-transform: uppercase; color: #dfb76c; letter-spacing: 0.5px; margin-bottom: 6px; }
        .form-label-custom span { color: #ea868f; } /* Dấu sao bắt buộc */
        .form-control-custom { background-color: #111111; border: 1px solid #2d2d2d; color: #fff; font-size: 0.85rem; padding: 10px 12px; border-radius: 4px; }
        .form-control-custom:focus { background-color: #141414; border-color: #dfb76c; color: #fff; box-shadow: none; }
        .form-control-custom::placeholder { color: #444; font-style: italic; }
        
        /* Bìa sách mẫu có sẵn */
        .cover-option-card { background-color: #111; border: 1px solid #262626; border-radius: 4px; padding: 8px; cursor: pointer; text-align: center; transition: 0.2s; }
        .cover-option-card:hover, .cover-option-card.active { border-color: #dfb76c; background-color: #1c170e; }
        .cover-thumb { width: 45px; height: 65px; object-fit: cover; border-radius: 2px; margin-bottom: 6px; }
        .cover-title { font-size: 0.65rem; color: #aaa; display: block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        
        /* Vùng kéo thả file upload */
.upload-dropzone { border: 1px dashed #3d331d; background-color: #111; border-radius: 4px; padding: 20px; text-align: center; cursor: pointer; transition: 0.2s; }
        .upload-dropzone:hover { border-color: #dfb76c; background-color: #1a150e; }
        
        /* Khu vực hiển thị phòng vệ bảo mật (Hình 2) */
        .security-badge { font-size: 0.65rem; font-weight: bold; padding: 2px 5px; border-radius: 3px; margin-right: 6px; display: inline-block; }
        .bg-xss { background-color: #d63384; color: #fff; }
        .bg-sqli { background-color: #fd7e14; color: #fff; }
        .bg-csrf { background-color: #6f42c1; color: #fff; }
        .security-desc { font-size: 0.72rem; color: #777; line-height: 1.4; margin-bottom: 0; }
        
        /* Đánh giá sao */
        .star-rating { color: #dfb76c; font-size: 1.1rem; display: flex; gap: 4px; cursor: pointer; }
        
        /* Nút Submit chính */
        .btn-submit-main { background-color: #dfb76c; color: #121212; font-weight: bold; letter-spacing: 1px; padding: 12px; border-radius: 4px; border: none; transition: 0.2s; width: 100%; text-transform: uppercase; font-size: 0.9rem; }
        .btn-submit-main:hover { background-color: #cda252; color: #121212; }
    </style>
</head>
<body>

<div class="container my-4">

    <div class="mb-4">
        <h3 class="page-title gold-text mb-1">Khai Bản Khải Sách</h3>
        <small class="text-muted text-uppercase tracking-wider" style="font-size: 0.7rem; letter-spacing: 1px;">Chép tay bổ sung tác phẩm mới vào thư lâm tàng thư độc bản của bạn</small>
    </div>

    <form action="index.php?action=save-book" method="POST" enctype="multipart/form-data">
        
        <div class="row g-4">
            
            <div class="col-lg-7">
                <div class="card-custom p-4">
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label-custom">Tên tác phẩm <span>*</span></label>
                            <input type="text" name="title" class="form-control form-control-custom" placeholder="Ví dụ: Đắc Nhân Tâm..." required>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label-custom">Tác giả <span>*</span></label>
                            <input type="text" name="author" class="form-control form-control-custom" placeholder="Ví dụ: Dale Carnegie..." required>
                        </div>
                        
                        <div class="col-12">
                            <label class="form-label-custom">Giới thiệu vắn tắt tác phẩm</label>
                            <textarea name="description" rows="3" class="form-control form-control-custom" placeholder="Vài dòng tóm tắt thông tin cuốn sách, bối cảnh ra đời..."></textarea>
                        </div>
                        
                        <div class="col-12">
                            <label class="form-label-custom">Cảm nhận và đánh giá ban đầu</label>
                            <textarea name="review" rows="3" class="form-control form-control-custom" placeholder="Điểm ấn tượng nhất, động cơ hay lý do bạn bắt đầu tìm đọc cuốn sách này..."></textarea>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label-custom">Chọn chủ đề</label>
                            <select name="genreId" class="form-select form-control-custom">
                                <option value="1">Tâm lý & Kỹ năng</option>
                                <option value="2">Khoa học & Vũ trụ</option>
                                <option value="3">Lịch sử & Triết học</option>
                                <option value="4">Tiểu thuyết & Văn học</option>
                                <option value="5">Kinh tế & Đầu tư</option>
                            </select>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label-custom">Tình trạng khởi đọc</label>
                            <select name="status" class="form-select form-control-custom">
                                <option value="READING">Đang tiến trình đọc</option>
                                <option value="COMPLETED">Đã đọc xong</option>
                                <option value="PLANNING">Ước đọc (Chờ)</option>
                            </select>
                        </div>
                        
                        <div class="col-md-4">
                            <label class="form-label-custom">Tổng số trang</label>
                            <input type="number" name="pagesTotal" class="form-control form-control-custom" value="300">
                        </div>
                        
                        <div class="col-md-4">
                            <label class="form-label-custom">Số trang đã đọc</label>
                            <input type="number" name="pagesRead" class="form-control form-control-custom" value="0">
                        </div>
                        
                        <div class="col-md-4">
                            <label class="form-label-custom">Thẩm định (Sao)</label>
                            <div class="star-rating py-2">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-lg-5">
                <div class="card-custom p-4 h-100 d-flex flex-column justify-content-between">
                    
                    <div>
                        <div class="section-title">Bìa Sách Độc Bản</div>
                        <small class="text-muted d-block mb-2 text-uppercase" style="font-size: 0.65rem;">Chọn từ mẫu có sẵn</small>
                        
                        <div class="row g-2 mb-3">
                            <div class="col-3">
                                <div class="cover-option-card active">
                                    <img src="https://images.unsplash.com/photo-1544949750-fa07a98d237f?auto=format&fit=crop&q=80&w=120" class="cover-thumb" alt="Sample 1">
                                    <span class="cover-title">Lam Linh Nhã</span>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="cover-option-card">
                                    <img src="https://images.unsplash.com/photo-1512820790803-83ca734da794?auto=format&fit=crop&q=80&w=120" class="cover-thumb" alt="Sample 2">
                                    <span class="cover-title">Tĩnh Vân Sâm</span>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="cover-option-card">
                                    <img src="https://images.unsplash.com/photo-1543002588-bfa74002ed7e?auto=format&fit=crop&q=80&w=120" class="cover-thumb" alt="Sample 3">
                                    <span class="cover-title">Đất Vàng Cổ</span>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="cover-option-card">
                                    <img src="https://images.unsplash.com/photo-1451187580459-43490279c0fa?auto=format&fit=crop&q=80&w=120" class="cover-thumb" alt="Sample 4">
                                    <span class="cover-title">Vũ Trụ Thần Bí</span>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <small class="text-muted text-uppercase" style="font-size: 0.65rem;">Hoặc tải ảnh từ thiết bị</small>
                            <span class="badge bg-dark text-warning border border-secondary" style="font-size: 0.6rem;">NÂNG CAO</span>
                        </div>
                        
                        <div class="upload-dropzone text-center mb-4">
                            <i class="fa-solid fa-cloud-arrow-up text-muted fa-xl mb-2 d-block"></i>
                            <span class="text-white small d-block fw-bold mb-1">Chọn hoặc Kéo ảnh thả vào</span>
                            <span class="text-muted d-block" style="font-size: 0.65rem;">JPEG, PNG, WEBP tỷ lệ bìa</span>
                            <input type="file" name="cover_image" class="d-none" id="fileInput" accept="image/*">
                        </div>
                    </div>

                    <div class="border-top border-secondary pt-3 mt-auto">
                        <div class="section-title d-flex align-items-center gap-2">
                            <i class="fa-solid fa-shield-halved"></i> Mô hình phòng vệ an ninh
                        </div>
                        
                        <div class="bg-dark p-3 border border-secondary rounded mb-3">
                            <div class="d-flex align-items-start mb-2">
                                <span class="security-badge bg-xss">XSS</span>
                                <p class="security-desc">Mã HTML lạ chèn vào tên sách/tác giả được React/PHP mã hóa thành Text-Nodes an toàn trước bối cảnh hiển thị.</p>
                            </div>
                            <div class="d-flex align-items-start mb-2">
                                <span class="security-badge bg-sqli">SQLi</span>
                                <p class="security-desc">Các chuỗi bẫy nháy đơn <code>' OR '1'='1</code> sẽ được cô lập trong tham số giữ chỗ Parametrized của PDO.</p>
                            </div>
                            <div class="d-flex align-items-start">
                                <span class="security-badge bg-csrf">CSRF</span>
                                <p class="security-desc">token = <code>mstk_2026_csrf_prod_key2</code></p>
                            </div>
                        </div>

                        <input type="hidden" name="csrf_token" value="mstk_2026_csrf_prod_key2">

                        <button type="submit" class="btn-submit-main d-flex align-items-center justify-content-center gap-2">
                            <i class="fa-solid fa-link"></i> Liên kết sách vào CSDL
                        </button>
                    </div>

                </div>
            </div>

        </div>
    </form>

</div>

<script>
    // Xử lý sự kiện click vào dropzone để kích hoạt mở hộp thoại chọn file
    document.querySelector('.upload-dropzone').addEventListener('click', () => {
        document.getElementById('fileInput').click();
    });
</script>

</body>
</html>

<?php 
// Nạp footer chung đóng thẻ body và html hoàn tất trang web
include 'partials/footer.php'; 
?>