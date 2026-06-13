<?php 
// Tích hợp hệ thống MVC, nạp header.php chứa navbar dùng chung
include 'partials/header.php'; 
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mọt Sách Ký - Nhật Ký Học Thư</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body { background-color: #121212; color: #e0e0e0; font-family: 'Segoe UI', sans-serif; }
        .gold-text { color: #dfb76c !important; }
        .gold-bg { background-color: #dfb76c !important; color: #121212 !important; }
        .card-custom { background-color: #161616; border: 1px solid #262626; border-radius: 6px; }
        
        /* Typography */
        .page-title { font-family: 'Playfair Display', serif; font-style: italic; }
        .section-title { font-family: 'Playfair Display', serif; font-style: italic; color: #dfb76c; font-size: 1.15rem; margin-bottom: 15px; }
        
        /* Đồng hồ đếm ngược Pomodoro */
        .timer-display { font-size: 4rem; font-weight: bold; color: #dfb76c; letter-spacing: 2px; font-family: monospace; }
        .btn-timer-mode { background: transparent; border: 1px solid #333; color: #888; font-size: 0.72rem; padding: 4px 10px; text-transform: uppercase; }
        .btn-timer-mode.active { border-color: #dfb76c; color: #dfb76c; background-color: #1c170e; }
        .btn-timer-ctrl { background-color: #dfb76c; color: #121212; border: none; width: 45px; height: 45px; border-radius: 50%; font-size: 1.2rem; transition: 0.2s; }
        .btn-timer-ctrl:hover { background-color: #cda252; }
        .btn-timer-reset { background: transparent; border: 1px solid #444; color: #aaa; width: 35px; height: 35px; border-radius: 50%; font-size: 0.9rem; }
        .btn-timer-reset:hover { border-color: #666; color: #fff; }

        /* Form nhập liệu */
        .form-label-custom { font-size: 0.7rem; font-weight: bold; text-transform: uppercase; color: #888; letter-spacing: 0.5px; margin-bottom: 6px; }
        .form-control-custom { background-color: #111; border: 1px solid #2d2d2d; color: #fff; font-size: 0.85rem; padding: 10px 12px; border-radius: 4px; }
        .form-control-custom:focus { background-color: #141414; border-color: #dfb76c; color: #fff; box-shadow: none; }
        .form-control-custom::placeholder { color: #444; font-style: italic; }
        
        /* Lịch sử nhật ký bên phải */
        .history-item { background-color: #111; border: 1px solid #222; border-radius: 4px; padding: 15px; position: relative; }
        .badge-chapter { background-color: #2c2514; color: #ff9800; font-size: 0.65rem; border: 1px solid #4a3b1a; padding: 3px 6px; border-radius: 3px; font-weight: bold; }
        .history-book-title { font-size: 0.9rem; font-weight: bold; color: #fff; font-style: italic; }
        .history-meta { font-size: 0.72rem; color: #666; margin-top: 4px; }
        .history-quote { font-size: 0.85rem; color: #b5b5b5; font-style: italic; margin-top: 10px; border-left: 2px solid #333; padding-left: 10px; }
        .btn-delete-history { background: none; border: none; color: #444; position: absolute; top: 15px; right: 15px; transition: color 0.2s; }
        .btn-delete-history:hover { color: #ea868f; }

        /* Nút lưu chính */
        .btn-submit-diary { background-color: #dfb76c; color: #121212; font-weight: bold; padding: 12px; border-radius: 4px; border: none; width: 100%; text-transform: uppercase; font-size: 0.82rem; letter-spacing: 1px; }
        .btn-submit-diary:hover { background-color: #cda252; }
    </style>
</head>
<body>

<div class="container my-4">

    <div class="mb-4">
        <h3 class="page-title gold-text mb-1">Nhật Ký Học Thư</h3>
        <small class="text-muted text-uppercase tracking-wider" style="font-size: 0.7rem; letter-spacing: 1px;">Không gian đong đếm thời giờ đọc tập trung, ghi chép tóm tắt chương sách và bồi dưỡng ý tưởng học thuật.</small>
    </div>

    <div class="row g-4">
        
        <div class="col-lg-5">
            
            <div class="card-custom p-4 text-center mb-4">
                <div class="d-flex justify-content-center gap-2 mb-3">
                    <span class="badge bg-dark border border-secondary text-muted px-2 py-1" style="font-size:0.65rem;"><i class="fa-solid fa-hourglass-half me-1"></i> PHIÊN ĐỌC ĐỒNG</span>
                </div>
                
                <div class="timer-display mb-3">25:00</div>
                
                <div class="d-flex justify-content-center gap-2 mb-4">
                    <button class="btn btn-timer-mode active rounded">25P Đọc Sách</button>
                    <button class="btn btn-timer-mode rounded">45P Nghiên Cứu Deep</button>
                    <button class="btn btn-timer-mode rounded">Giải lao 5P</button>
                </div>
                
                <div class="d-flex justify-content-center align-items-center gap-3">
                    <button class="btn-timer-ctrl"><i class="fa-solid fa-play"></i></button>
                    <button class="btn-timer-reset"><i class="fa-solid fa-rotate-right"></i></button>
                </div>
            </div>

            <div class="card-custom p-4">
                <div class="section-title text-uppercase" style="font-size: 0.8rem; letter-spacing: 1px;">
                    <i class="fa-regular fa-pen-to-square me-1"></i> Nhật Ký Học Thư
                </div>
                
                <form action="index.php?action=save-log" method="POST">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label-custom">Sách đang tàng tuyển</label>
                            <select name="bookId" class="form-select form-control-custom">
                                <option value="2">Lược Sử Loài Người (Sapiens)</option>
                                <option value="1">Đắc Nhân Tâm</option>
                                <option value="4">Vũ Trụ (Cosmos)</option>
                            </select>
                        </div>
                        
                        <div class="col-12">
                            <label class="form-label-custom">Tên chương / đoạn trích lược</label>
                            <input type="text" name="chapter" class="form-control form-control-custom" placeholder="Ví dụ: Chương 1, mục 2.5...">
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label-custom">Thời lượng (Phút)</label>
                            <input type="number" name="duration" class="form-control form-control-custom" value="30">
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label-custom">Ngày thực chép</label>
                            <input type="text" name="date" class="form-control form-control-custom" value="13/06/2026">
                        </div>
                        
                        <div class="col-12 mb-2">
                            <label class="form-label-custom">Ghi chú tinh thần học thoại</label>
                            <textarea name="content" rows="4" class="form-control form-control-custom" placeholder="Hôm nay bạn bộc lộ ý niệm tri thức gì? Trải lòng cảm ngộ chương sách này..."></textarea>
                        </div>
                        
                        <div class="col-12">
                            <button type="submit" class="btn-submit-diary d-flex align-items-center justify-content-center gap-2">
                                <i class="fa-solid fa-plus"></i> Thêm biên chép nhật ký
                            </button>
                        </div>
                    </div>
                </form>
            </div>

        </div>

        <div class="col-lg-7">
            <div class="card-custom p-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <div class="section-title text-uppercase mb-0" style="font-size: 0.9rem; letter-spacing: 1px;">Niên Giám Trực Bản Đọc</div>
                        <small class="text-muted text-uppercase" style="font-size: 0.65rem;">Danh sách lịch trình quá khứ</small>
                    </div>
                    <span class="badge bg-dark border border-secondary text-muted px-2 py-1" style="font-size: 0.65rem; letter-spacing: 0.5px;">TÍCH LŨY: 4 MỐC</span>
                </div>

                <div class="d-flex flex-column gap-3">
                    
                    <div class="history-item">
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <span class="badge badge-chapter">Chương 1 & 2</span>
                            <span class="history-book-title">Đắc Nhân Tâm</span>
                        </div>
                        <div class="history-meta">
                            <i class="fa-regular fa-calendar me-1"></i> 2026-04-12 &nbsp;&bull;&nbsp; <i class="fa-regular fa-clock me-1"></i> 45 phút
                        </div>
                        <p class="history-quote">“Đọc xong phần đầu về nghệ thuật ứng xử cơ bản. Hãy khen ngợi người khác một cách chân thành thay vì chỉ trích vô cớ.”</p>
                        <button class="btn-delete-history"><i class="fa-regular fa-trash-can"></i></button>
                    </div>

                    <div class="history-item">
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <span class="badge badge-chapter">Chương 3 & 4</span>
                            <span class="history-book-title">Lược Sử Loài Người (Sapiens)</span>
                        </div>
                        <div class="history-meta">
                            <i class="fa-regular fa-calendar me-1"></i> 2026-05-02 &nbsp;&bull;&nbsp; <i class="fa-regular fa-clock me-1"></i> 60 phút
                        </div>
                        <p class="history-quote">“Phân tích về cuộc cách mạng nhận thức. Khả năng ngôn ngữ tinh vi giúp người Sapiens xây dựng các niềm tin chung như tiền bạc, vương quốc và tôn giáo để tổ chức cộng đồng lớn.”</p>
                        <button class="btn-delete-history"><i class="fa-regular fa-trash-can"></i></button>
                    </div>

                    <div class="history-item">
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <span class="badge badge-chapter">Chương 1</span>
                            <span class="history-book-title">Vũ Trụ (Cosmos)</span>
                        </div>
                        <div class="history-meta">
                            <i class="fa-regular fa-calendar me-1"></i> 2026-05-25 &nbsp;&bull;&nbsp; <i class="fa-regular fa-clock me-1"></i> 30 phút
                        </div>
                        <p class="history-quote">“Khám phá chương về thư viện vĩ đại Alexandria. Thật ngỡ ngàng khi nhân loại từng sở hữu nền tri thức cổ đại tuyệt vời như thế trước khi bị đốt rụi.”</p>
                        <button class="btn-delete-history"><i class="fa-regular fa-trash-can"></i></button>
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
// Nạp footer chung đóng thẻ hoàn tất bố cục cấu trúc DOM
include 'partials/footer.php'; 
?>