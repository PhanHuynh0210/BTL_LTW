<?php
if(isset($_FILES["image"])) {
    $target_dir = "uploads/";
    $image_name = basename($_FILES["image"]["name"]);
    $target_file = $target_dir . $image_name;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Kiểm tra phải ảnh không
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if($check === false) {
        echo "Tập tin không phải là hình ảnh.";
        exit;
    }

    // Giới hạn loại file
    $allowed_types = ["jpg", "jpeg", "png", "gif"];
    if(!in_array($imageFileType, $allowed_types)) {
        echo "Chỉ hỗ trợ các định dạng ảnh JPG, JPEG, PNG, GIF.";
        exit;
    }

    // Lưu ảnh
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        echo "Ảnh " . htmlspecialchars($image_name) . " đã được tải lên thành công.<br>";
        echo "<img src='$target_file' width='300'/>";
    } else {
        echo "Có lỗi xảy ra khi tải ảnh.";
    }
} else {
    echo "Chưa có ảnh được chọn để tải.";
}
?>
