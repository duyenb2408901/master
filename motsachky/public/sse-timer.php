<?php
// Thiết lập header bắt buộc cho Server-Sent Events
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
header('Connection: keep-alive');

// Giả lập đồng hồ đếm ngược từ Server gửi về Client mỗi giây
$target_minutes = 25;
$target_seconds = 0;

while (true) {
    // Xuất ra định dạng chuẩn của SSE: "data: [nội dung]\n\n"
    $time_string = sprintf("%02d:%02d", $target_minutes, $target_seconds);
    echo "data: {$time_string}\n\n";
    
    ob_flush();
    flush();
    
    if ($target_seconds == 0) {
        if ($target_minutes == 0) break;
        $target_minutes--;
        $target_seconds = 59;
    } else {
        $target_seconds--;
    }
    sleep(1); // Chờ 1 giây để gửi tiếp
}