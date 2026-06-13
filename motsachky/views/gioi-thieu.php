<?php 
// Tích hợp hệ thống MVC, nạp header.php chứa navbar dùng chung
include 'partials/header.php'; 
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mọt Sách Ký - Giới Thiệu Đồng Hành</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body { background-color: #121212; color: #e0e0e0; font-family: 'Segoe UI', sans-serif; min-height: 100vh; display: flex; flex-direction: column; }
        .gold-text { color: #dfb76c !important; }
        .gold-bg { background-color: #dfb76c !important; color: #121212 !important; }
        .card-custom { background-color: #161616; border: 1px solid #262626; border-radius: 6px; }
        
        /* Typography cổ điển */
        .page-title { font-family: 'Playfair Display', serif; font-style: italic; }
        .section-title { font-family: 'Playfair Display', serif; font-style: italic; color: #dfb76c; font-size: 1.15rem; margin-bottom: 15px; }

        /* Menu điều hướng phụ (Sub-tab) */
        .sub-nav-btn { background: transparent; border: none; color: #888; font-size: 0.82rem; font-weight: 500; text-transform: uppercase; padding: 8px 16px; border-radius: 4px; display: inline-flex; align-items: center; gap: 8px; transition: 0.2s; }
        .sub-nav-btn:hover, .sub-nav-btn.active { color: #dfb76c; background-color: #1c170e; }
        
        /* Khối Tuyên ngôn độc sách */
        .manifesto-section { text-align: center; padding: 50px 30px; background-color: #151515; border: 1px solid #222; border-radius: 6px; margin-bottom: 30px; }
        .manifesto-tag { font-size: 0.72rem; color: #dfb76c; font-weight: bold; letter-spacing: 2px; text-transform: uppercase; }
        .manifesto-title { font-family: 'Playfair Display', serif; font-style: italic; color: #dfb76c; font-size: 2rem; line-height: 1.5; margin: 20px 0; }
        .manifesto-desc { max-width: 700px; margin: 0 auto; color: #888; font-size: 0.85rem; line-height: 1.6; }
        .btn-outline-gold { background: transparent; border: 1px solid #dfb76c; color: #dfb76c; font-size: 0.78rem; font-weight: bold; text-transform: uppercase; padding: 10px 20px; transition: 0.2s; }
        .btn-outline-gold:hover { background-color: #dfb76c; color: #121212; }

        /* Khối tính cách / Cốt cách mọt sách */
        .feature-item { margin-bottom: 20px; padding-left: 15px; position: relative; }
        .feature-title { font-size: 0.88rem; font-weight: bold; color: #eee; margin-bottom: 4px; }
        .feature-desc { font-size: 0.8rem; color: #777; line-height: 1.5; }
        .feature-icon-arrow { color: #dfb76c; position: absolute; left: 0; top: 3px; font-size: 0.75rem; }

        /* Trích dẫn tiêu điểm tuần */
        .quote-box { background-color: #111; border: 1px solid #222; border-radius: 4px; padding: 20px; position: relative; margin-bottom: 25px; }
        .quote-icon { font-size: 2.5rem; color: #222; position: absolute; top: 10px; left: 15px; font-family: serif; line-height: 1; }
        .quote-text { font-size: 0.88rem; color: #b5b5b5; font-style: italic; line-height: 1.6; position: relative; z-index: 2; }
        .quote-author { font-size: 0.75rem; color: #dfb76c; text-align: right; font-weight: bold; margin-top: 15px; }

        /* Bảng thống kê tâm hồn */
        .stat-row { display: flex; justify-content: justify; align-items: center; padding: 12px; background-color: #111; border: 1px solid #222; border-radius: 4px; margin-bottom: 10px; font-size: 0.85rem; }
        .stat-label { color: #888; }
        .stat-value { color: #fff; font-weight: bold; margin-left: auto; }

        /* Chân trang (Footer bản quyền cục bộ) */
        .local-footer { border-top: 1px solid #222; padding: 20px 0; margin-top: auto; font-size: 0.72rem; color: #555; text-transform: uppercase; letter-spacing: 0.5px; }
    </style>
</head>
<body>

<div class="container my-4 flex-grow-1">

    <div class="d-flex flex-wrap gap-2 mb-4 border-bottom border-secondary pb-2">
        <button class="sub-nav-btn active"><i class="fa-solid fa-circle-info"></i> Giới thiệu đồng hành</button>
        <button class="sub-nav-btn"><i class="fa-regular fa-bookmark"></i> Tác phẩm khải luận (4)</button>
        <button class="sub-nav-btn"><i class="fa-regular fa-comments"></i> Góc san sẻ cảm xúc (4)</button>
    </div>

    <div class="manifesto-section">
        <div class="manifesto-tag">Tuyên ngôn đọc sách</div>
        <h2 class="manifesto-title">“Sách là tinh túy kết tinh của ngàn năm văn hiến cổ xưa, người đọc sách chính là mầm sống kết nối thế giới thực tại với lâu đài vĩnh cửu của tri thức.”</h2>
        <p class="manifesto-desc mb-4">
            Chào mừng bạn đã ghé thăm <strong>Mọt Sách Ký (Bookworm Journals)</strong>! Nơi đây không có chỗ cho những ồn ào công nghệ khô khan. Chúng tôi vun đắp một không gian tịnh tâm mộc mạc, tôn vinh thói quen viết lời phê bình, tổng duyệt cảm xúc và lưu trữ tinh hoa tri thức ẩn giấu sau những gáy sách vàng son.
        </p>
        <div class="d-flex justify-content-center gap-3">
            <a href="index.php?page=tu-sach" class="btn gold-bg fw-bold text-uppercase px-3 py-2" style="font-size:0.75rem; border-radius:3px;">Khám phá review sách</a>
            <button class="btn btn-outline-gold px-3 py-2" style="border-radius:3px;">Đọc dòng cảm nhận vụn vặt</button>
        </div>
    </div>

    <div class="row g-4">
        
        <div class="col-lg-6">
            <div class="card-custom p-4 h-100">
                <div class="section-title text-uppercase d-flex align-items-center gap-2" style="font-size: 0.85rem; letter-spacing:1px;">
                    <i class="fa-solid fa-graduation-cap"></i> Mọt Sách Cốt Cách
                </div>
                <p class="text-muted mb-4" style="font-size: 0.82rem; line-height: 1.6;">
                    Trang web được kiến thiết để đồng hành trọn vẹn cùng hành trình khai tâm của bạn. Mỗi khi một cuốn sách được thêm vào thư viện riêng tư của bạn, hành trình đó sẽ không dừng lại ở những con số trang hay lịch sử khô cứng.
                </p>

                <div class="feature-item">
                    <i class="fa-solid fa-chevron-right feature-icon-arrow"></i>
                    <div class="feature-title">Khai Thác Cảm Quan Cá Nhân</div>
                    <div class="feature-desc">Mỗi bài viết review là một cánh cửa tự bạch tâm hồn. Tự hỏi bản thân cuốn sách ấy đã thay đổi nhân sinh quan của bạn ở điểm nào.</div>
                </div>

                <div class="feature-item">
                    <i class="fa-solid fa-chevron-right feature-icon-arrow"></i>
                    <div class="feature-title">Không Gian Học Tập Nhã Nhặn</div>
                    <div class="feature-desc">Phục hưng lối tôn thờ cổ điển, sử dụng màu sắc hoàng gia ấm cúng và phong văn thanh tao quý phái để khơi gợi cảm hứng viết mỗi ngày.</div>
                </div>

                <div class="feature-item">
                    <i class="fa-solid fa-chevron-right feature-icon-arrow"></i>
                    <div class="feature-title">Bảo Tồn Di Sản Học Trình</div>
                    <div class="feature-desc">Cùng chung tay ghi dấu kỷ niệm văn thơ, chia sẻ tri thức tinh tuyển nhất cùng bạn đọc bốn phương cùng thăng hoa văn nghệ.</div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card-custom p-4 h-100 d-flex flex-column justify-content-between">
                
                <div>
                    <div class="section-title text-uppercase d-flex align-items-center gap-2" style="font-size: 0.85rem; letter-spacing:1px;">
                        <i class="fa-solid fa-quote-left"></i> Cảm Nhận Tiêu Điểm Trong Tuần
                    </div>
                    
                    <div class="quote-box">
                        <div class="quote-icon">“</div>
                        <p class="quote-text">
                            “Nhận thức sâu sắc nhất khi ta đối diện cuốn sách triết học không nằm ở chỗ ta đồng thuận hay bài xích luận điểm của tác giả, mà là khoảnh khắc ta bàng hoàng nhận thấy những nếp nhăn định kiến của bản thân bấy lâu nay bỗng nhiên nứt vỡ thành trăm mảnh nhỏ...”
                        </p>
                        <div class="quote-author">— Thu Hằng (Nhóm Trưởng Sách Ký)</div>
                    </div>

                    <div class="section-title text-uppercase mb-3" style="font-size: 0.75rem; letter-spacing:1px; color: #aaa;">
                        Thống Kê Tâm Hồn Đọc Sách:
                    </div>

                    <div class="stat-row">
                        <span class="stat-label">Bài cảm luận đã tích lũy:</span>
                        <span class="stat-value gold-text">4 tác văn</span>
                    </div>

                    <div class="stat-row">
                        <span class="stat-label">Câu châm ngôn được đồng hành:</span>
                        <span class="stat-value gold-text">4 câu từ</span>
                    </div>
                </div>

                <div class="text-center mt-3">
                    <small class="text-muted italic" style="font-size: 0.7rem; font-style: italic;">* Tôn vinh nét văn chương thanh tao, phi công nghệ phi tạp niệm.</small>
                </div>

            </div>
        </div>

    </div>
</div>

<footer class="local-footer">
    <div class="container d-flex justify-content-between flex-wrap gap-2">
        <span>© 2026 Mọt Sách Ký — Lưu giữ tinh hoa tri thức và cảm nghiệm tâm can tạo nhã</span>
        <div>
            <span class="me-3">Học giả: Thu Hằng & Minh Đăng</span>
            <span class="gold-text">Chế độ: Tàng thư kinh điển</span>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php 
// Nạp footer dùng chung hệ thống MVC
include 'partials/footer.php'; 
?>