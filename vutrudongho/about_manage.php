<?php
// Start session (ensure it's started only once)


// --- Security Check: Ensure Admin is Logged In ---
// IMPORTANT: Uncomment and adjust 'admin_logged_in' and 'admin_login.php' if you have an admin session check
/*
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php"); // Redirect to your admin login page
    exit();
}
*/

include './connectdb.php'; // Include DB connection
$feedback_message = ''; // For potential JS alert feedback

// --- CSRF Token Generation (Place this somewhere before the form/modal is generated) ---
// You would typically generate this token when displaying the form/modal
// For simplicity here, we generate it on every page load if not set.
// A better approach is to generate it when the modal is requested or shown.
// if (empty($_SESSION['csrf_token'])) {
//     $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
// }
// $csrf_token = $_SESSION['csrf_token'];
// Note: We will add the CSRF input field dynamically via JavaScript later

// --- Form Submission Handling (Add/Update) ---
if (isset($_GET['enableQuery']) && isset($_POST['submit'])) {
    // --- CSRF Token Validation ---
    // IMPORTANT: Uncomment this block when you implement CSRF token in the form
    /*
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        // Token mismatch - handle the error (e.g., log, display error, exit)
        unset($_SESSION['csrf_token']); // Invalidate the token
        die("Invalid CSRF token detected. Request rejected.");
    }
    // Invalidate the token after successful use to prevent reuse (optional, depends on strategy)
    // unset($_SESSION['csrf_token']);
    */


    $section = $_POST['submit']; // Section identifier (e.g., 'company_info', 'vision_mission')
    $is_update = isset($_POST['id']) && !empty($_POST['id']);
    $id = $is_update ? (int)$_POST['id'] : 0;
    $success = false;
    $message = '';

    // Define target directory for uploads
    $target_dir = "assets/img/about_us/"; // Make sure this directory exists and is writable
    if (!is_dir($target_dir)) {
        if (!mkdir($target_dir, 0777, true)) {
             // Critical error if directory cannot be created
             die("Failed to create upload directory: " . $target_dir);
        }
    }


    switch ($section) {
        // --- Company Info ---
        case 'company_info':
            $description = trim($_POST['description']);
            $current_data_sql = "SELECT banner_path, about_image_path FROM company_info LIMIT 1";
            $current_data_result = mysqli_query($con, $current_data_sql);
            // Initialize with empty strings if no data exists yet
            $current_data = $current_data_result ? mysqli_fetch_assoc($current_data_result) : ['banner_path' => '', 'about_image_path' => ''];
            if (!$current_data) $current_data = ['banner_path' => '', 'about_image_path' => '']; // Ensure array exists

            $banner_path_db = $current_data['banner_path'] ?? '';
            $about_image_path_db = $current_data['about_image_path'] ?? '';
            $old_banner_path = $banner_path_db; // Store old path for potential deletion
            $old_about_image_path = $about_image_path_db;

            // Handle Banner Upload
            if (isset($_FILES['banner']) && $_FILES['banner']['error'] == UPLOAD_ERR_OK) {
                // Basic validation (consider adding size and type checks)
                $banner_filename = time() . '_' . preg_replace("/[^a-zA-Z0-9.]/", "_", basename($_FILES["banner"]["name"])); // Sanitize filename
                $target_file_banner = $target_dir . $banner_filename;
                if (move_uploaded_file($_FILES["banner"]["tmp_name"], $target_file_banner)) {
                    $banner_path_db = $banner_filename; // Save only filename to DB
                     // Delete old file if it exists and is different
                     if ($is_update && !empty($old_banner_path) && $old_banner_path != $banner_path_db && file_exists($target_dir . $old_banner_path)) {
                         @unlink($target_dir . $old_banner_path);
                     }
                } else {
                     error_log("Failed to move uploaded banner file to " . $target_file_banner);
                     $message = 'Lỗi upload banner. Kiểm tra quyền ghi thư mục.';
                     // Decide: Stop completely or continue without banner update?
                     break; // Stop processing this case if upload fails critically
                }
            } elseif (isset($_FILES['banner']) && $_FILES['banner']['error'] != UPLOAD_ERR_NO_FILE) {
                 // Handle other upload errors
                 error_log("Banner upload error: " . $_FILES['banner']['error']);
                 $message = 'Lỗi trong quá trình upload banner (Mã lỗi: ' . $_FILES['banner']['error'] . ').';
                 break;
            }

             // Handle About Image Upload
             if (isset($_FILES['about_image']) && $_FILES['about_image']['error'] == UPLOAD_ERR_OK) {
                $about_image_filename = time() . '_about_' . preg_replace("/[^a-zA-Z0-9.]/", "_", basename($_FILES["about_image"]["name"]));
                $target_file_about = $target_dir . $about_image_filename;
                if (move_uploaded_file($_FILES["about_image"]["tmp_name"], $target_file_about)) {
                     $about_image_path_db = $about_image_filename; // Save only filename to DB
                      // Delete old file if it exists and is different
                     if ($is_update && !empty($old_about_image_path) && $old_about_image_path != $about_image_path_db && file_exists($target_dir . $old_about_image_path)) {
                         @unlink($target_dir . $old_about_image_path);
                     }
                } else {
                     error_log("Failed to move uploaded about image file to " . $target_file_about);
                     $message = 'Lỗi upload ảnh giới thiệu. Kiểm tra quyền ghi thư mục.';
                     break; // Stop processing this case
                }
             } elseif (isset($_FILES['about_image']) && $_FILES['about_image']['error'] != UPLOAD_ERR_NO_FILE) {
                 error_log("About image upload error: " . $_FILES['about_image']['error']);
                 $message = 'Lỗi trong quá trình upload ảnh giới thiệu (Mã lỗi: ' . $_FILES['about_image']['error'] . ').';
                 break;
             }


            // Check if record exists to decide INSERT or UPDATE
            $check_sql = "SELECT id FROM company_info LIMIT 1";
            $check_result = mysqli_query($con, $check_sql);

            if ($check_result && mysqli_num_rows($check_result) > 0) {
                // Update existing record
                $stmt = mysqli_prepare($con, "UPDATE company_info SET description = ?, banner_path = ?, about_image_path = ? LIMIT 1");
                if (!$stmt) {
                    error_log("Prepare failed (UPDATE company_info): " . mysqli_error($con));
                    $message = 'Lỗi chuẩn bị câu lệnh cập nhật thông tin công ty.'; break;
                }
                mysqli_stmt_bind_param($stmt, "sss", $description, $banner_path_db, $about_image_path_db);
            } else {
                // Insert new record
                $stmt = mysqli_prepare($con, "INSERT INTO company_info (description, banner_path, about_image_path) VALUES (?, ?, ?)");
                 if (!$stmt) {
                    error_log("Prepare failed (INSERT company_info): " . mysqli_error($con));
                    $message = 'Lỗi chuẩn bị câu lệnh thêm thông tin công ty.'; break;
                }
                mysqli_stmt_bind_param($stmt, "sss", $description, $banner_path_db, $about_image_path_db);
            }

            if (mysqli_stmt_execute($stmt)) {
                $message = 'Cập nhật thông tin công ty thành công!';
                $success = true;
            } else {
                error_log("Execute failed (company_info): " . mysqli_stmt_error($stmt));
                $message = 'Lỗi cập nhật thông tin công ty: ' . mysqli_stmt_error($stmt);
            }
            mysqli_stmt_close($stmt);
            break;

        // --- Vision & Mission ---
        case 'vision_mission':
            $title = trim($_POST['title']);
            $content = trim($_POST['content']);
            $type = isset($_POST['type']) ? (int)$_POST['type'] : 0; // Default to 0 if not set

            if (empty($title) || empty($content)) {
                 $message = 'Lỗi: Tiêu đề và nội dung không được để trống.';
                 break;
            }

            if ($is_update) {
                $stmt = mysqli_prepare($con, "UPDATE vision_mission SET title = ?, content = ?, type = ? WHERE id = ?");
                if (!$stmt) { $message = 'Lỗi chuẩn bị câu lệnh (Update Vision/Mission)'; error_log(mysqli_error($con)); break; }
                mysqli_stmt_bind_param($stmt, "ssii", $title, $content, $type, $id);
                $action_word = 'Cập nhật';
            } else {
                $stmt = mysqli_prepare($con, "INSERT INTO vision_mission (title, content, type) VALUES (?, ?, ?)");
                 if (!$stmt) { $message = 'Lỗi chuẩn bị câu lệnh (Insert Vision/Mission)'; error_log(mysqli_error($con)); break; }
                mysqli_stmt_bind_param($stmt, "ssi", $title, $content, $type);
                $action_word = 'Thêm';
            }

            if (mysqli_stmt_execute($stmt)) {
                $message = $action_word . ' tầm nhìn/sứ mệnh thành công!';
                $success = true;
            } else {
                $message = 'Lỗi ' . strtolower($action_word) . ' tầm nhìn/sứ mệnh: ' . mysqli_stmt_error($stmt);
                 error_log("Execute failed (vision_mission): " . mysqli_stmt_error($stmt));
            }
            mysqli_stmt_close($stmt);
            break;

        // --- Core Values ---
         case 'core_value': // Identifier used in JS/Form
            $title = trim($_POST['title']);
            $description = trim($_POST['description']);
            $icon_path = trim($_POST['icon_path']); // Assuming text input for icon path/class
            $sort_order = isset($_POST['sort_order']) ? (int)$_POST['sort_order'] : 0;

             if (empty($title) || empty($description)) {
                 $message = 'Lỗi: Tiêu đề và mô tả giá trị cốt lõi không được để trống.';
                 break;
            }

             // Handle Icon Upload if it's a file (Optional - Adapt if needed, currently assumes text path)
             /*
             $icon_path_db = $icon_path; // Default to text input
             // Logic to handle potential file upload for icon, similar to banner/about_image
             */

            if ($is_update) {
                // Fetch current icon path if needed for deletion on file upload (not implemented here)
                $stmt = mysqli_prepare($con, "UPDATE core_values SET title = ?, description = ?, icon_path = ?, sort_order = ? WHERE id = ?");
                 if (!$stmt) { $message = 'Lỗi chuẩn bị câu lệnh (Update Core Value)'; error_log(mysqli_error($con)); break; }
                // Use $icon_path_db if handling file uploads, otherwise use $icon_path
                mysqli_stmt_bind_param($stmt, "sssii", $title, $description, $icon_path, $sort_order, $id);
                $action_word = 'Cập nhật';
            } else {
                $stmt = mysqli_prepare($con, "INSERT INTO core_values (title, description, icon_path, sort_order) VALUES (?, ?, ?, ?)");
                if (!$stmt) { $message = 'Lỗi chuẩn bị câu lệnh (Insert Core Value)'; error_log(mysqli_error($con)); break; }
                mysqli_stmt_bind_param($stmt, "sssi", $title, $description, $icon_path, $sort_order);
                 $action_word = 'Thêm';
            }

            if (mysqli_stmt_execute($stmt)) {
                $message = $action_word . ' giá trị cốt lõi thành công!';
                $success = true;
            } else {
                $message = 'Lỗi ' . strtolower($action_word) . ' giá trị cốt lõi: ' . mysqli_stmt_error($stmt);
                 error_log("Execute failed (core_values): " . mysqli_stmt_error($stmt));
            }
            mysqli_stmt_close($stmt);
            break;

        // --- Brands ---
        case 'brand':
            $name = trim($_POST['name']);
            $link = trim($_POST['link']);
            // Validate URL format if a link is provided
            if (!empty($link) && !filter_var($link, FILTER_VALIDATE_URL)) {
                $message = 'Lỗi: Link thương hiệu không hợp lệ.';
                break;
            }
            $sort_order = isset($_POST['sort_order']) ? (int)$_POST['sort_order'] : 0;
            $logo_path_db = ''; // Initialize
            $old_logo_path = '';

            if (empty($name)) {
                 $message = 'Lỗi: Tên thương hiệu không được để trống.';
                 break;
            }

            // Get current logo path if updating
            if ($is_update) {
                $fetch_stmt = mysqli_prepare($con, "SELECT logo_path FROM brands WHERE id = ?");
                mysqli_stmt_bind_param($fetch_stmt, "i", $id);
                mysqli_stmt_execute($fetch_stmt);
                mysqli_stmt_bind_result($fetch_stmt, $old_logo_path);
                mysqli_stmt_fetch($fetch_stmt);
                mysqli_stmt_close($fetch_stmt);
                $logo_path_db = $old_logo_path ?? ''; // Start with the old path
            }

            // Handle Logo Upload
            if (isset($_FILES['logo']) && $_FILES['logo']['error'] == UPLOAD_ERR_OK) {
                $logo_filename = time() . '_brand_' . preg_replace("/[^a-zA-Z0-9.]/", "_", basename($_FILES["logo"]["name"]));
                $target_file = $target_dir . $logo_filename;
                if (move_uploaded_file($_FILES["logo"]["tmp_name"], $target_file)) {
                    $logo_path_db = $logo_filename; // Update with new filename
                    // Delete old file if it exists and is different
                    if ($is_update && !empty($old_logo_path) && $old_logo_path != $logo_path_db && file_exists($target_dir . $old_logo_path)) {
                        @unlink($target_dir . $old_logo_path);
                    }
                } else {
                    error_log("Failed to move uploaded brand logo to " . $target_file);
                    $message = 'Lỗi upload logo thương hiệu. Kiểm tra quyền ghi thư mục.';
                    break;
                }
            } elseif (isset($_FILES['logo']) && $_FILES['logo']['error'] != UPLOAD_ERR_NO_FILE) {
                error_log("Brand logo upload error: " . $_FILES['logo']['error']);
                $message = 'Lỗi trong quá trình upload logo thương hiệu (Mã lỗi: ' . $_FILES['logo']['error'] . ').';
                break;
            }


            if ($is_update) {
                $stmt = mysqli_prepare($con, "UPDATE brands SET name = ?, logo_path = ?, link = ?, sort_order = ? WHERE id = ?");
                if (!$stmt) { $message = 'Lỗi chuẩn bị câu lệnh (Update Brand)'; error_log(mysqli_error($con)); break; }
                mysqli_stmt_bind_param($stmt, "sssii", $name, $logo_path_db, $link, $sort_order, $id);
                $action_word = 'Cập nhật';
            } else {
                 // For insert, logo is required if uploaded, otherwise can be null/empty depending on DB schema
                 if (empty($logo_path_db) && isset($_FILES['logo']) && $_FILES['logo']['error'] == UPLOAD_ERR_NO_FILE) {
                     // Allow insert without logo if DB allows NULL or empty string
                     // $message = 'Lỗi: Logo là bắt buộc khi thêm mới thương hiệu.'; break; // Uncomment if logo is mandatory
                 }
                $stmt = mysqli_prepare($con, "INSERT INTO brands (name, logo_path, link, sort_order) VALUES (?, ?, ?, ?)");
                 if (!$stmt) { $message = 'Lỗi chuẩn bị câu lệnh (Insert Brand)'; error_log(mysqli_error($con)); break; }
                mysqli_stmt_bind_param($stmt, "sssi", $name, $logo_path_db, $link, $sort_order);
                $action_word = 'Thêm';
            }

            if (mysqli_stmt_execute($stmt)) {
                $message = $action_word . ' thương hiệu thành công!';
                $success = true;
            } else {
                $message = 'Lỗi ' . strtolower($action_word) . ' thương hiệu: ' . mysqli_stmt_error($stmt);
                error_log("Execute failed (brands): " . mysqli_stmt_error($stmt));
            }
            mysqli_stmt_close($stmt);
            break;

        // --- Team Members ---
        case 'team':
            $name = trim($_POST['name']);
            $position = trim($_POST['position']);
            $description = trim($_POST['description']);
            $sort_order = isset($_POST['sort_order']) ? (int)$_POST['sort_order'] : 0;
            $image_path_db = ''; // Initialize
            $old_image_path = '';

             if (empty($name) || empty($position) || empty($description)) {
                 $message = 'Lỗi: Tên, Chức vụ và Mô tả thành viên không được để trống.';
                 break;
            }

            // Get current image path if updating
            if ($is_update) {
                $fetch_stmt = mysqli_prepare($con, "SELECT image_path FROM team_members WHERE id = ?");
                mysqli_stmt_bind_param($fetch_stmt, "i", $id);
                mysqli_stmt_execute($fetch_stmt);
                mysqli_stmt_bind_result($fetch_stmt, $old_image_path);
                mysqli_stmt_fetch($fetch_stmt);
                mysqli_stmt_close($fetch_stmt);
                $image_path_db = $old_image_path ?? ''; // Start with old path
            }

            // Handle Team Member Image Upload
            if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
                $image_filename = time() . '_team_' . preg_replace("/[^a-zA-Z0-9.]/", "_", basename($_FILES["image"]["name"]));
                $target_file = $target_dir . $image_filename;
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    $image_path_db = $image_filename;
                    // Delete old file if it exists and is different
                    if ($is_update && !empty($old_image_path) && $old_image_path != $image_path_db && file_exists($target_dir . $old_image_path)) {
                        @unlink($target_dir . $old_image_path);
                    }
                } else {
                     error_log("Failed to move uploaded team member image to " . $target_file);
                     $message = 'Lỗi upload ảnh thành viên. Kiểm tra quyền ghi thư mục.';
                     break;
                }
            } elseif (isset($_FILES['image']) && $_FILES['image']['error'] != UPLOAD_ERR_NO_FILE) {
                 error_log("Team member image upload error: " . $_FILES['image']['error']);
                 $message = 'Lỗi trong quá trình upload ảnh thành viên (Mã lỗi: ' . $_FILES['image']['error'] . ').';
                 break;
            }

            if ($is_update) {
                $stmt = mysqli_prepare($con, "UPDATE team_members SET name = ?, position = ?, description = ?, image_path = ?, sort_order = ? WHERE id = ?");
                 if (!$stmt) { $message = 'Lỗi chuẩn bị câu lệnh (Update Team)'; error_log(mysqli_error($con)); break; }
                mysqli_stmt_bind_param($stmt, "ssssii", $name, $position, $description, $image_path_db, $sort_order, $id);
                $action_word = 'Cập nhật';
            } else {
                 // For insert, image is required if uploaded, otherwise can be null/empty
                 if (empty($image_path_db) && isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_NO_FILE) {
                     // Allow insert without image if DB allows NULL or empty string
                     // $message = 'Lỗi: Ảnh là bắt buộc khi thêm mới thành viên.'; break; // Uncomment if image is mandatory
                 }
                $stmt = mysqli_prepare($con, "INSERT INTO team_members (name, position, description, image_path, sort_order) VALUES (?, ?, ?, ?, ?)");
                 if (!$stmt) { $message = 'Lỗi chuẩn bị câu lệnh (Insert Team)'; error_log(mysqli_error($con)); break; }
                mysqli_stmt_bind_param($stmt, "ssssi", $name, $position, $description, $image_path_db, $sort_order);
                $action_word = 'Thêm';
            }

            if (mysqli_stmt_execute($stmt)) {
                $message = $action_word . ' thành viên thành công!';
                $success = true;
            } else {
                $message = 'Lỗi ' . strtolower($action_word) . ' thành viên: ' . mysqli_stmt_error($stmt);
                 error_log("Execute failed (team_members): " . mysqli_stmt_error($stmt));
            }
            mysqli_stmt_close($stmt);
            break;

        // --- Testimonials ---
        case 'testimonial':
            $customer_name = trim($_POST['customer_name']);
            $content = trim($_POST['content']);
            $location = trim($_POST['location']); // Optional field
            $sort_order = isset($_POST['sort_order']) ? (int)$_POST['sort_order'] : 0;
            $image_path_db = ''; // Initialize
            $old_image_path = '';

             if (empty($customer_name) || empty($content)) {
                 $message = 'Lỗi: Tên khách hàng và nội dung đánh giá không được để trống.';
                 break;
            }

            // Get current image path if updating
            if ($is_update) {
                $fetch_stmt = mysqli_prepare($con, "SELECT image_path FROM testimonials WHERE id = ?");
                mysqli_stmt_bind_param($fetch_stmt, "i", $id);
                mysqli_stmt_execute($fetch_stmt);
                mysqli_stmt_bind_result($fetch_stmt, $old_image_path);
                mysqli_stmt_fetch($fetch_stmt);
                mysqli_stmt_close($fetch_stmt);
                $image_path_db = $old_image_path ?? ''; // Start with old path
            }

            // Handle Testimonial Image Upload
            if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
                $image_filename = time() . '_testimonial_' . preg_replace("/[^a-zA-Z0-9.]/", "_", basename($_FILES["image"]["name"]));
                $target_file = $target_dir . $image_filename;
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    $image_path_db = $image_filename;
                     // Delete old file if it exists and is different
                    if ($is_update && !empty($old_image_path) && $old_image_path != $image_path_db && file_exists($target_dir . $old_image_path)) {
                        @unlink($target_dir . $old_image_path);
                    }
                } else {
                    error_log("Failed to move uploaded testimonial image to " . $target_file);
                    $message = 'Lỗi upload ảnh đánh giá. Kiểm tra quyền ghi thư mục.';
                    break;
                }
            } elseif (isset($_FILES['image']) && $_FILES['image']['error'] != UPLOAD_ERR_NO_FILE) {
                error_log("Testimonial image upload error: " . $_FILES['image']['error']);
                $message = 'Lỗi trong quá trình upload ảnh đánh giá (Mã lỗi: ' . $_FILES['image']['error'] . ').';
                break;
            }

            if ($is_update) {
                $stmt = mysqli_prepare($con, "UPDATE testimonials SET customer_name = ?, content = ?, location = ?, image_path = ?, sort_order = ? WHERE id = ?");
                if (!$stmt) { $message = 'Lỗi chuẩn bị câu lệnh (Update Testimonial)'; error_log(mysqli_error($con)); break; }
                mysqli_stmt_bind_param($stmt, "ssssii", $customer_name, $content, $location, $image_path_db, $sort_order, $id);
                $action_word = 'Cập nhật';
            } else {
                 // For insert, image is required if uploaded, otherwise can be null/empty
                 if (empty($image_path_db) && isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_NO_FILE) {
                    // Allow insert without image if DB allows NULL or empty string
                     // $message = 'Lỗi: Ảnh là bắt buộc khi thêm mới đánh giá.'; break; // Uncomment if image is mandatory
                 }
                $stmt = mysqli_prepare($con, "INSERT INTO testimonials (customer_name, content, location, image_path, sort_order) VALUES (?, ?, ?, ?, ?)");
                if (!$stmt) { $message = 'Lỗi chuẩn bị câu lệnh (Insert Testimonial)'; error_log(mysqli_error($con)); break; }
                mysqli_stmt_bind_param($stmt, "ssssi", $customer_name, $content, $location, $image_path_db, $sort_order);
                $action_word = 'Thêm';
            }

            if (mysqli_stmt_execute($stmt)) {
                $message = $action_word . ' đánh giá thành công!';
                $success = true;
            } else {
                $message = 'Lỗi ' . strtolower($action_word) . ' đánh giá: ' . mysqli_stmt_error($stmt);
                 error_log("Execute failed (testimonials): " . mysqli_stmt_error($stmt));
            }
            mysqli_stmt_close($stmt);
            break;

        // --- Default Case ---
        default:
            $message = 'Lỗi: Hành động không hợp lệ.';
            break;

    } // End Switch

    // Provide feedback via JavaScript alert and redirect
    // Use addslashes to prevent issues with quotes in the message
    echo "<script>
            alert('" . addslashes($message) . "');
            window.location.href = 'about_manage.php'; // Redirect back to the management page
          </script>";
    exit(); // Stop script execution after handling action

} // End of Add/Update Handling


// --- Deletion Handling ---
if (isset($_GET['action']) && $_GET['action'] == 'del' && isset($_GET['table']) && isset($_GET['id'])) {
    $table = $_GET['table'];
    $id = (int)$_GET['id'];
    // Whitelist tables allowed for deletion - IMPORTANT FOR SECURITY
    $allowed_tables = ['vision_mission', 'core_values', 'brands', 'team_members', 'testimonials' /* 'commitments' */ ];
    $success = false;
    $message = '';

    if ($id > 0 && in_array($table, $allowed_tables)) {

        // Optional: Fetch data before delete to delete associated files
        $file_path_to_delete = '';
        $column_name = ''; // Determine column name based on table
        switch ($table) {
            case 'brands': $column_name = 'logo_path'; break;
            case 'team_members': $column_name = 'image_path'; break;
            case 'testimonials': $column_name = 'image_path'; break;
            // Add cases for other tables with file uploads if necessary
        }

        if (!empty($column_name)) {
            $fetch_stmt = mysqli_prepare($con, "SELECT `{$column_name}` FROM `{$table}` WHERE id = ?");
             if($fetch_stmt){
                 mysqli_stmt_bind_param($fetch_stmt, "i", $id);
                 mysqli_stmt_execute($fetch_stmt);
                 mysqli_stmt_bind_result($fetch_stmt, $file_path_to_delete);
                 mysqli_stmt_fetch($fetch_stmt);
                 mysqli_stmt_close($fetch_stmt);
             } else {
                  error_log("Failed to prepare fetch statement for deletion file path: " . mysqli_error($con));
             }
        }

        // Proceed with deletion from database
        $stmt = mysqli_prepare($con, "DELETE FROM `{$table}` WHERE id = ?");
         if (!$stmt) {
             $message = 'Lỗi chuẩn bị câu lệnh xóa.';
              error_log("Prepare failed (DELETE {$table}): " . mysqli_error($con));
         } else {
            mysqli_stmt_bind_param($stmt, "i", $id);

            if (mysqli_stmt_execute($stmt)) {
                if (mysqli_stmt_affected_rows($stmt) > 0) {
                    $message = 'Xóa mục thành công!';
                    $success = true;
                    // Delete the associated file if found
                    if (!empty($file_path_to_delete) && file_exists($target_dir . $file_path_to_delete)) {
                        if (!@unlink($target_dir . $file_path_to_delete)) {
                            // Log error if file deletion fails, but don't necessarily fail the whole operation
                             error_log("Failed to delete associated file: " . $target_dir . $file_path_to_delete);
                             $message .= ' (Lưu ý: không thể xóa tệp tin liên quan)';
                        }
                    }
                 } else {
                     $message = 'Không tìm thấy mục để xóa hoặc đã được xóa trước đó.';
                 }
            } else {
                $message = 'Lỗi xóa mục: ' . mysqli_stmt_error($stmt);
                 error_log("Execute failed (DELETE {$table}): " . mysqli_stmt_error($stmt));
            }
            mysqli_stmt_close($stmt);
         }

    } else {
         if ($id <= 0) {
             $message = 'Yêu cầu xóa không hợp lệ: ID không hợp lệ.';
         } elseif (!in_array($table, $allowed_tables)) {
             $message = 'Yêu cầu xóa không hợp lệ: Bảng không được phép xóa.';
              error_log("Attempted deletion from disallowed table: " . $table);
         } else {
              $message = 'Yêu cầu xóa không hợp lệ.';
         }
    }

     // Provide feedback via JavaScript alert and redirect
     echo "<script>
             alert('" . addslashes($message) . "');
             window.location.href = 'about_manage.php';
           </script>";
     exit(); // Stop script execution

} // End of Deletion Handling


// --- Include Admin UI Components ---
include './sidebar.php';
include './container-header.php';

// --- Fetch Data for Display ---
$base_image_url = "./assets/img/about_us/"; // Base URL for images

// Fetch Company Info
$companyInfoResult = mysqli_query($con, "SELECT * FROM company_info LIMIT 1");
$companyInfo = $companyInfoResult && mysqli_num_rows($companyInfoResult) > 0 ? mysqli_fetch_assoc($companyInfoResult) : null;
if (!$companyInfo) $companyInfo = ['id' => null, 'description' => '', 'banner_path' => '', 'about_image_path' => '']; // Provide defaults

// Fetch Vision & Mission
$all_vision_mission = [];
$vmResult = mysqli_query($con, "SELECT * FROM vision_mission ORDER BY type DESC, id ASC");
if ($vmResult) { while($row = mysqli_fetch_assoc($vmResult)) { $all_vision_mission[$row['id']] = $row; } }

// Fetch Core Values
$all_core_values = [];
$cvResult = mysqli_query($con, "SELECT * FROM core_values ORDER BY sort_order ASC, id ASC");
if ($cvResult) { while($row = mysqli_fetch_assoc($cvResult)) { $all_core_values[$row['id']] = $row; } }

// Fetch Brands
$all_brands = [];
$brandsResult = mysqli_query($con, "SELECT * FROM brands ORDER BY sort_order ASC, id ASC");
if ($brandsResult) { while($row = mysqli_fetch_assoc($brandsResult)) { $all_brands[$row['id']] = $row; } }

// Fetch Team Members
$all_team_members = [];
$teamResult = mysqli_query($con, "SELECT * FROM team_members ORDER BY sort_order ASC, id ASC");
if ($teamResult) { while($row = mysqli_fetch_assoc($teamResult)) { $all_team_members[$row['id']] = $row; } }

// Fetch Testimonials
$all_testimonials = [];
$testimonialsResult = mysqli_query($con, "SELECT * FROM testimonials ORDER BY sort_order ASC, id ASC");
if ($testimonialsResult) { while($row = mysqli_fetch_assoc($testimonialsResult)) { $all_testimonials[$row['id']] = $row; } }

// ... Fetch data for other sections (e.g., Commitments) similarly if needed ...

?>

<script>
    // Set Sidebar and Header
    eventForSideBar(7); // Adjust index if necessary for 'About Management'
    setValueHeader("Quản Lý Giới Thiệu");

    // Delete Confirmation Dialog
    function confirmDelete(url) {
        if (confirm('Bạn có chắc chắn muốn xóa mục này không? Hành động này không thể hoàn tác.')) {
            window.location.href = url;
        }
        return false; // Prevent default link behavior if confirm is false
    }
</script>

<div class="container__product"> <!-- Main content container -->
    <!-- Tab navigation -->
    <div class="container-product__tabs">
        <button class="tab-btn active" onclick="openTab(event, 'company-info')">Thông tin công ty</button>
        <button class="tab-btn" onclick="openTab(event, 'vision-mission')">Tầm nhìn & Sứ mệnh</button>
        <button class="tab-btn" onclick="openTab(event, 'core-values')">Giá trị cốt lõi</button>
        <button class="tab-btn" onclick="openTab(event, 'brands')">Thương Hiệu</button>
        <button class="tab-btn" onclick="openTab(event, 'team')">Đội ngũ</button>
        <button class="tab-btn" onclick="openTab(event, 'testimonials')">Đánh giá</button>
        <!-- <button class="tab-btn" onclick="openTab(event, 'commitments')">Cam Kết</button> -->
        <!-- <button class="tab-btn" onclick="openTab(event, 'stores')">Cửa hàng</button> -->
    </div>

    <!-- Tab Content Area -->

    <!-- Company Info Tab -->
    <div id="company-info" class="tab-content active">
        <h3 class="tab-content__title">Thông Tin Công Ty</h3>
        <!-- Button to open modal for editing company info -->
        <button class="container-product-header__insert" onclick="displayEditModal('company_info', <?= $companyInfo['id'] ?? 0 ?>);">Chỉnh sửa thông tin</button>

        <table class="container-product__table data-table">
            <thead>
                <tr>
                    <th>Mô tả</th>
                    <th>Banner Hiện Tại</th>
                    <th>Ảnh Giới Thiệu Hiện Tại</th>
                    <th>Hành động</th>
                 </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="max-width: 400px; word-wrap: break-word; white-space: pre-wrap;"><?= !empty($companyInfo['description']) ? nl2br(htmlspecialchars($companyInfo['description'])) : '<i>Chưa có thông tin</i>' ?></td>
                    <td>
                        <?php if (!empty($companyInfo['banner_path']) && file_exists($base_image_url . $companyInfo['banner_path'])): ?>
                            <img src="<?= $base_image_url . htmlspecialchars($companyInfo['banner_path']) ?>" width="150" alt="Banner">
                        <?php else: ?>
                            <i>(Không có)</i>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if (!empty($companyInfo['about_image_path']) && file_exists($base_image_url . $companyInfo['about_image_path'])): ?>
                            <img src="<?= $base_image_url . htmlspecialchars($companyInfo['about_image_path']) ?>" width="150" alt="Ảnh giới thiệu">
                        <?php else: ?>
                            <i>(Không có)</i>
                        <?php endif; ?>
                    </td>
                     <td class="actions">
                        <span class="container-product-table__edit-icon material-symbols-outlined" title="Chỉnh sửa" style="cursor: pointer;" onclick="displayEditModal('company_info', <?= $companyInfo['id'] ?? 0 ?>);">edit</span>
                        <!-- No delete for Company Info typically -->
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Vision & Mission Tab -->
    <div id="vision-mission" class="tab-content">
         <h3 class="tab-content__title">Tầm Nhìn & Sứ Mệnh</h3>
         <button class="container-product-header__insert" onclick="displayEditModal('vision_mission');">Thêm Tầm nhìn/Sứ mệnh</button>

        <table class="container-product__table data-table">
             <thead>
                <tr>
                    <th>ID</th>
                    <th>Tiêu đề</th>
                    <th>Nội dung (ngắn)</th>
                    <th>Loại</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($all_vision_mission)) {
                    foreach($all_vision_mission as $item) {
                        $content_short = mb_substr(strip_tags($item['content']), 0, 70) . (mb_strlen(strip_tags($item['content'])) > 70 ? '...' : '');
                ?>
                <tr>
                    <td><?= $item['id'] ?></td>
                    <td><?= htmlspecialchars($item['title']) ?></td>
                    <td><?= htmlspecialchars($content_short) ?></td>
                    <td><?= isset($item['type']) && $item['type'] == 1 ? 'Tầm nhìn' : 'Sứ mệnh' ?></td>
                    <td class="actions">
                         <span class="container-product-table__edit-icon material-symbols-outlined" title="Chỉnh sửa" style="cursor: pointer;" onclick="displayEditModal('vision_mission', <?= $item['id'] ?>);">edit</span>
                         <span class="container-product-table__delete-icon material-symbols-outlined" title="Xóa" style="cursor: pointer;" onclick="confirmDelete('about_manage.php?action=del&table=vision_mission&id=<?= $item['id'] ?>');">delete</span>
                    </td>
                </tr>
                <?php
                    }
                } else {
                    echo '<tr><td colspan="5"><i>Chưa có dữ liệu Tầm nhìn/Sứ mệnh.</i></td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>

     <!-- Core Values Tab -->
    <div id="core-values" class="tab-content">
        <h3 class="tab-content__title">Giá Trị Cốt Lõi</h3>
        <button class="container-product-header__insert" onclick="displayEditModal('core_value');">Thêm Giá trị cốt lõi</button>

        <table class="container-product__table data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Icon</th>
                    <th>Tiêu đề</th>
                    <th>Mô tả (ngắn)</th>
                    <th>Thứ tự</th>
                    <th>Hành động</th>
                </tr>
            </thead>
             <tbody>
                 <?php
                 if (!empty($all_core_values)) {
                     foreach($all_core_values as $item) {
                         $description_short = mb_substr(strip_tags($item['description']), 0, 70) . (mb_strlen(strip_tags($item['description'])) > 70 ? '...' : '');
                 ?>
                 <tr>
                     <td><?= $item['id'] ?></td>
                     <td>
                         <?php if (!empty($item['icon_path'])): ?>
                             <!-- Basic check if it looks like an <i> tag (common for Font Awesome) -->
                             <?php if (strpos(trim($item['icon_path']), '<i') === 0 && strpos(trim($item['icon_path']), '</i>') !== false) : ?>
                                 <?= $item['icon_path'] // Assuming it's safe HTML like <i class="fa fa-icon"></i> ?>
                              <!-- Check if it's a likely image file path relative to assets -->
                             <?php elseif (preg_match('/\.(jpg|jpeg|png|gif|svg)$/i', $item['icon_path']) && file_exists('assets/img/icons/' . $item['icon_path'])): ?>
                                 <img src="<?= htmlspecialchars('assets/img/icons/' . $item['icon_path']) ?>" alt="Icon" style="width: 30px; height: 30px; vertical-align: middle;">
                             <!-- Check if it's a full URL -->
                              <?php elseif(filter_var($item['icon_path'], FILTER_VALIDATE_URL)): ?>
                                 <img src="<?= htmlspecialchars($item['icon_path']) ?>" alt="Icon" style="width: 30px; height: 30px; vertical-align: middle;">
                             <!-- Assume it's a CSS class name (e.g., Font Awesome class) -->
                             <?php else: ?>
                                 <span class="<?= htmlspecialchars($item['icon_path']) ?>" style="font-size: 24px; vertical-align: middle;" title="<?= htmlspecialchars($item['icon_path']) ?>"></span>
                             <?php endif; ?>
                         <?php else: ?>
                             <i>(Không có)</i>
                         <?php endif; ?>
                     </td>
                     <td><?= htmlspecialchars($item['title']) ?></td>
                     <td><?= htmlspecialchars($description_short) ?></td>
                     <td><?= htmlspecialchars($item['sort_order']) ?></td>
                     <td class="actions">
                         <span class="container-product-table__edit-icon material-symbols-outlined" title="Chỉnh sửa" style="cursor: pointer;" onclick="displayEditModal('core_value', <?= $item['id'] ?>);">edit</span>
                         <span class="container-product-table__delete-icon material-symbols-outlined" title="Xóa" style="cursor: pointer;" onclick="confirmDelete('about_manage.php?action=del&table=core_values&id=<?= $item['id'] ?>');">delete</span>
                     </td>
                 </tr>
                 <?php
                     }
                 } else {
                     echo '<tr><td colspan="6"><i>Chưa có dữ liệu Giá trị cốt lõi.</i></td></tr>';
                 }
                 ?>
            </tbody>
        </table>
    </div>

    <!-- Brands Tab -->
    <div id="brands" class="tab-content">
        <h3 class="tab-content__title">Thương Hiệu Đối Tác</h3>
        <button class="container-product-header__insert" onclick="displayEditModal('brand');">Thêm Thương hiệu</button>
        <table class="container-product__table data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên</th>
                    <th>Logo</th>
                    <th>Link</th>
                    <th>Thứ tự</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($all_brands)): ?>
                    <?php foreach($all_brands as $brand): ?>
                    <tr>
                        <td><?= $brand['id'] ?></td>
                        <td><?= htmlspecialchars($brand['name']) ?></td>
                        <td>
                            <?php if (!empty($brand['logo_path']) && file_exists($base_image_url . $brand['logo_path'])): ?>
                                <img src="<?= $base_image_url . htmlspecialchars($brand['logo_path']) ?>" width="80" alt="Logo">
                            <?php else: ?>
                                <i>(Không có)</i>
                            <?php endif; ?>
                        </td>
                        <td><?= !empty($brand['link']) ? '<a href="'.htmlspecialchars($brand['link']).'" target="_blank" rel="noopener noreferrer">'.htmlspecialchars($brand['link']).'</a>' : '<i>N/A</i>' ?></td>
                        <td><?= $brand['sort_order'] ?></td>
                        <td class="actions">
                            <span class="container-product-table__edit-icon material-symbols-outlined" title="Chỉnh sửa" style="cursor: pointer;" onclick="displayEditModal('brand', <?= $brand['id'] ?>);">edit</span>
                            <span class="container-product-table__delete-icon material-symbols-outlined" title="Xóa" style="cursor: pointer;" onclick="confirmDelete('about_manage.php?action=del&table=brands&id=<?= $brand['id'] ?>');">delete</span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="6"><i>Chưa có dữ liệu Thương hiệu.</i></td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Team Tab -->
    <div id="team" class="tab-content">
         <h3 class="tab-content__title">Đội Ngũ</h3>
         <button class="container-product-header__insert" onclick="displayEditModal('team');">Thêm Thành viên</button>
        <table class="container-product__table data-table">
             <thead>
                 <tr>
                     <th>ID</th>
                     <th>Tên</th>
                     <th>Chức vụ</th>
                     <th>Ảnh</th>
                     <th>Mô tả (ngắn)</th>
                     <th>Thứ tự</th>
                     <th>Hành động</th>
                 </tr>
             </thead>
             <tbody>
                 <?php if (!empty($all_team_members)): ?>
                     <?php foreach($all_team_members as $member):
                            $desc_short = mb_substr(strip_tags($member['description']), 0, 50) . (mb_strlen(strip_tags($member['description'])) > 50 ? '...' : '');
                     ?>
                     <tr>
                         <td><?= $member['id'] ?></td>
                         <td><?= htmlspecialchars($member['name']) ?></td>
                         <td><?= htmlspecialchars($member['position']) ?></td>
                         <td>
                             <?php if (!empty($member['image_path']) && file_exists($base_image_url . $member['image_path'])): ?>
                                 <img src="<?= $base_image_url . htmlspecialchars($member['image_path']) ?>" width="60" alt="Ảnh <?= htmlspecialchars($member['name']) ?>">
                             <?php else: ?>
                                 <i>(Không có)</i>
                             <?php endif; ?>
                         </td>
                         <td><?= htmlspecialchars($desc_short) ?></td>
                         <td><?= $member['sort_order'] ?></td>
                         <td class="actions">
                             <span class="container-product-table__edit-icon material-symbols-outlined" title="Chỉnh sửa" style="cursor: pointer;" onclick="displayEditModal('team', <?= $member['id'] ?>);">edit</span>
                             <span class="container-product-table__delete-icon material-symbols-outlined" title="Xóa" style="cursor: pointer;" onclick="confirmDelete('about_manage.php?action=del&table=team_members&id=<?= $member['id'] ?>');">delete</span>
                         </td>
                     </tr>
                     <?php endforeach; ?>
                 <?php else: ?>
                     <tr><td colspan="7"><i>Chưa có dữ liệu Đội ngũ.</i></td></tr>
                 <?php endif; ?>
             </tbody>
        </table>
    </div>

    <!-- Testimonials Tab -->
    <div id="testimonials" class="tab-content">
         <h3 class="tab-content__title">Đánh Giá Khách Hàng</h3>
         <button class="container-product-header__insert" onclick="displayEditModal('testimonial');">Thêm Đánh giá</button>
        <table class="container-product__table data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên KH</th>
                    <th>Nội dung (ngắn)</th>
                    <th>Địa điểm</th>
                    <th>Ảnh</th>
                    <th>Thứ tự</th>
                    <th>Hành động</th>
                </tr>
            </thead>
             <tbody>
                 <?php if (!empty($all_testimonials)): ?>
                     <?php foreach($all_testimonials as $testimonial):
                            $content_short = mb_substr(strip_tags($testimonial['content']), 0, 50) . (mb_strlen(strip_tags($testimonial['content'])) > 50 ? '...' : '');
                     ?>
                     <tr>
                         <td><?= $testimonial['id'] ?></td>
                         <td><?= htmlspecialchars($testimonial['customer_name']) ?></td>
                         <td><?= htmlspecialchars($content_short) ?></td>
                         <td><?= !empty($testimonial['location']) ? htmlspecialchars($testimonial['location']) : '<i>N/A</i>' ?></td>
                         <td>
                             <?php if (!empty($testimonial['image_path']) && file_exists($base_image_url . $testimonial['image_path'])): ?>
                                 <img src="<?= $base_image_url . htmlspecialchars($testimonial['image_path']) ?>" width="60" alt="Ảnh <?= htmlspecialchars($testimonial['customer_name']) ?>">
                             <?php else: ?>
                                 <i>(Không có)</i>
                             <?php endif; ?>
                         </td>
                         <td><?= $testimonial['sort_order'] ?></td>
                         <td class="actions">
                             <span class="container-product-table__edit-icon material-symbols-outlined" title="Chỉnh sửa" style="cursor: pointer;" onclick="displayEditModal('testimonial', <?= $testimonial['id'] ?>);">edit</span>
                             <span class="container-product-table__delete-icon material-symbols-outlined" title="Xóa" style="cursor: pointer;" onclick="confirmDelete('about_manage.php?action=del&table=testimonials&id=<?= $testimonial['id'] ?>');">delete</span>
                         </td>
                     </tr>
                     <?php endforeach; ?>
                 <?php else: ?>
                     <tr><td colspan="7"><i>Chưa có dữ liệu Đánh giá.</i></td></tr>
                 <?php endif; ?>
             </tbody>
        </table>
    </div>

    <!-- Placeholder for other sections like Commitments, Stores etc. -->
    <!--
    <div id="commitments" class="tab-content">
        <h3 class="tab-content__title">Cam Kết</h3>
        <button class="container-product-header__insert" onclick="displayEditModal('commitment');">Thêm Cam kết</button>
        <table class="container-product__table data-table">
            <thead><tr><th>ID</th>...<th>Hành động</th></tr></thead>
            <tbody><tr><td colspan="X">Chưa có dữ liệu.</td></tr></tbody>
        </table>
    </div>
     -->

</div> <!-- End container__product -->


<!-- Modal Structure -->
<div class="modal" id="editAddModal" style="display: none;"> <!-- Start hidden -->
    <!-- The form action includes ?enableQuery to trigger the PHP processing block -->
    <form autocomplete="off" class="modal__product" method="POST" action="about_manage.php?enableQuery=1" enctype="multipart/form-data">
        <div class="modal-product__container">
            <p class="modal-product-container__heading" id="modal-heading">Chỉnh sửa/Thêm mới</p>

            <div class="modal-product-container__content" id="modal-content">
                <!-- Form content will be loaded here by JavaScript -->
                <i>Đang tải biểu mẫu...</i>
            </div>

            <!-- Hidden fields -->
            <input type="hidden" name="id" id="modal-id" value="">
            <!-- CSRF Token Input - IMPORTANT: Value needs to be set dynamically if used -->
            <!-- <input type="hidden" name="csrf_token" value="<?php // echo htmlspecialchars($csrf_token); ?>"> -->
            <!-- The submit button's 'value' attribute holds the section identifier -->
            <button name="submit" type="submit" class="modal-product-container__btn edit" id="modal-submit-button" value="">Lưu Thay Đổi</button>

            <div class="modal-product-container__close" onclick="closeModal('editAddModal');" title="Đóng">
                <span class="material-symbols-outlined">close</span>
            </div>
        </div>
    </form>
</div>

<script>
    // --- Modal Handling ---
    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.style.display = 'none';
            // Optional: Clear form content on close to avoid stale data
            const modalContent = document.getElementById('modal-content');
            if (modalContent) modalContent.innerHTML = '';
            const modalIdInput = document.getElementById('modal-id');
            if(modalIdInput) modalIdInput.value = '';
        }
    }

    // Close modal if clicking outside the form container
    window.addEventListener('click', function(event) {
        const modal = document.getElementById('editAddModal');
        if (event.target == modal) {
             closeModal('editAddModal');
        }
    });


    // --- Tab Switching ---
    function openTab(evt, tabName) {
        var i, tabcontent, tablinks;
        // Hide all tab content
        tabcontent = document.getElementsByClassName("tab-content");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
            tabcontent[i].classList.remove("active");
        }
        // Deactivate all tab buttons
        tablinks = document.getElementsByClassName("tab-btn");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].classList.remove("active");
        }
        // Show the selected tab content and activate the button
        const currentTab = document.getElementById(tabName);
        if(currentTab){
            currentTab.style.display = "block";
            currentTab.classList.add("active");
        }
        if(evt && evt.currentTarget){
            evt.currentTarget.classList.add("active");
        }
    }

     // --- Pre-fetched data from PHP for Modal ---
     // Using JSON encode ensures data is correctly formatted for JavaScript
     const companyInfoData = <?= json_encode($companyInfo, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) ?> || {};
     const visionMissionData = <?= json_encode($all_vision_mission, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) ?> || {};
     const coreValuesData = <?= json_encode($all_core_values, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) ?> || {};
     const brandsData = <?= json_encode($all_brands, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) ?> || {};
     const teamData = <?= json_encode($all_team_members, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) ?> || {};
     const testimonialsData = <?= json_encode($all_testimonials, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) ?> || {};
     const baseImageUrl = '<?= $base_image_url ?>'; // Make base URL available to JS

    // --- Display and Populate Modal ---
    function displayEditModal(table, id = null) {
        const modal = document.getElementById('editAddModal');
        const modalContent = document.getElementById('modal-content');
        const modalHeading = document.getElementById('modal-heading');
        const modalSubmitButton = document.getElementById('modal-submit-button');
        const modalIdInput = document.getElementById('modal-id');

        if (!modal || !modalContent || !modalHeading || !modalSubmitButton || !modalIdInput) {
            console.error("Modal elements not found!");
            return;
        }

        // Clear previous content & state
        modalContent.innerHTML = '';
        modalIdInput.value = id ? id : ''; // Set ID for update, empty for add
        modalSubmitButton.value = table; // Set the section identifier for the form submit name="submit"

        let formHtml = '';
        let currentData = null;
        let isEditing = (id !== null && id > 0);

        modalHeading.textContent = isEditing ? 'Chỉnh Sửa' : 'Thêm Mới'; // Default heading

        // --- Generate Form Fields Based on Table ---
        switch(table) {
            case 'company_info':
                modalHeading.textContent = 'Chỉnh Sửa Thông Tin Công Ty';
                // Company info is usually unique, data fetched directly
                currentData = companyInfoData;
                formHtml = `
                    <div class="form-group">
                        <label class="modal-product-container-content_label" for="modal-description">Mô tả công ty *</label>
                        <textarea class="modal-product-container-content_input" name="description" id="modal-description" rows="6" required>${currentData?.description ? htmlspecialchars_decode(currentData.description) : ''}</textarea>
                    </div>
                    <div class="form-group">
                        <label class="modal-product-container-content_label">Banner Hiện Tại:</label>
                        ${currentData?.banner_path && currentData.banner_path !== '' ? `<img src="${baseImageUrl}${currentData.banner_path}" width="100" style="margin-bottom: 5px; border:1px solid #ccc; padding:2px;"><br>` : '<i>(Không có)</i><br>'}
                        <label class="modal-product-container-content_label" for="modal-banner">Tải lên banner mới (chọn nếu muốn thay đổi):</label>
                        <input type="file" name="banner" id="modal-banner" class="modal-product-container-content_input" accept="image/jpeg, image/png, image/gif">
                    </div>
                    <div class="form-group">
                        <label class="modal-product-container-content_label">Ảnh Giới Thiệu Hiện Tại:</label>
                        ${currentData?.about_image_path && currentData.about_image_path !== '' ? `<img src="${baseImageUrl}${currentData.about_image_path}" width="100" style="margin-bottom: 5px; border:1px solid #ccc; padding:2px;"><br>` : '<i>(Không có)</i><br>'}
                        <label class="modal-product-container-content_label" for="modal-about-image">Tải lên ảnh giới thiệu mới (chọn nếu muốn thay đổi):</label>
                        <input type="file" name="about_image" id="modal-about-image" class="modal-product-container-content_input" accept="image/jpeg, image/png, image/gif">
                    </div>
                     <!-- Company info often doesn't need an explicit ID sent if it's always the first row -->
                     <input type="hidden" name="id" value="${currentData?.id || '1'}">
                `;
                break;

            case 'vision_mission':
                 modalHeading.textContent = isEditing ? 'Chỉnh Sửa Tầm Nhìn/Sứ Mệnh' : 'Thêm Tầm Nhìn/Sứ Mệnh';
                 currentData = isEditing ? (visionMissionData[id] || null) : null;
                 formHtml = `
                    <div class="form-group">
                        <label class="modal-product-container-content_label" for="modal-title">Tiêu đề *</label>
                        <input type="text" class="modal-product-container-content_input" name="title" id="modal-title" value="${currentData?.title ? htmlspecialchars_decode(currentData.title) : ''}" required>
                    </div>
                     <div class="form-group">
                        <label class="modal-product-container-content_label" for="modal-content-vm">Nội dung *</label>
                        <textarea class="modal-product-container-content_input" name="content" id="modal-content-vm" rows="5" required>${currentData?.content ? htmlspecialchars_decode(currentData.content) : ''}</textarea>
                    </div>
                     <div class="form-group">
                        <label class="modal-product-container-content_label" for="modal-type">Loại *</label>
                        <select class="modal-product-container-content_input" name="type" id="modal-type" required>
                            <option value="1" ${currentData?.type == 1 ? 'selected' : ''}>Tầm nhìn</option>
                            <option value="0" ${currentData?.type == 0 ? 'selected' : ''}>Sứ mệnh</option>
                            <option value="" ${currentData === null ? 'selected' : ''} disabled>-- Chọn loại --</option>
                        </select>
                    </div>
                 `;
                 break;

             case 'core_value':
                 modalHeading.textContent = isEditing ? 'Chỉnh Sửa Giá Trị Cốt Lõi' : 'Thêm Giá Trị Cốt Lõi';
                 currentData = isEditing ? (coreValuesData[id] || null) : null;
                 formHtml = `
                    <div class="form-group">
                        <label class="modal-product-container-content_label" for="modal-title-cv">Tiêu đề *</label>
                        <input type="text" class="modal-product-container-content_input" name="title" id="modal-title-cv" value="${currentData?.title ? htmlspecialchars_decode(currentData.title) : ''}" required>
                    </div>
                    <div class="form-group">
                        <label class="modal-product-container-content_label" for="modal-description-cv">Mô tả *</label>
                        <textarea class="modal-product-container-content_input" name="description" id="modal-description-cv" rows="4" required>${currentData?.description ? htmlspecialchars_decode(currentData.description) : ''}</textarea>
                    </div>
                     <div class="form-group">
                        <label class="modal-product-container-content_label" for="modal-icon-path">Đường dẫn/Class Icon:</label>
                        <input type="text" class="modal-product-container-content_input" name="icon_path" id="modal-icon-path" value="${currentData?.icon_path ? htmlspecialchars_decode(currentData.icon_path) : ''}" placeholder="e.g., assets/img/icons/icon.png or fas fa-star or <i class='...'></i>">
                         <!-- Note: File upload for icons is not implemented in this example -->
                         <!-- <label class="modal-product-container-content_label" for="modal-icon-file">Hoặc tải lên Icon:</label>
                         <input type="file" name="icon_file" id="modal-icon-file" class="modal-product-container-content_input" accept="image/*,.svg">
                         -->
                    </div>
                    <div class="form-group">
                        <label class="modal-product-container-content_label" for="modal-sort-order">Thứ tự hiển thị *</label>
                        <input type="number" min="0" class="modal-product-container-content_input" name="sort_order" id="modal-sort-order" value="${currentData?.sort_order ?? '0'}" required>
                    </div>
                `;
                break;

            case 'brand':
                modalHeading.textContent = isEditing ? 'Chỉnh Sửa Thương Hiệu' : 'Thêm Thương Hiệu';
                currentData = isEditing ? (brandsData[id] || null) : null;
                formHtml = `
                    <div class="form-group">
                        <label class="modal-product-container-content_label" for="modal-name">Tên thương hiệu *</label>
                        <input type="text" class="modal-product-container-content_input" name="name" id="modal-name" value="${currentData?.name ? htmlspecialchars_decode(currentData.name) : ''}" required>
                    </div>
                    <div class="form-group">
                        <label class="modal-product-container-content_label">Logo hiện tại:</label>
                        ${currentData?.logo_path && currentData.logo_path !== '' ? `<img src="${baseImageUrl}${currentData.logo_path}" width="100" style="margin-bottom: 5px; border:1px solid #ccc; padding:2px;"><br>` : '<i>(Không có)</i><br>'}
                        <label class="modal-product-container-content_label" for="modal-logo">Tải lên logo mới (chọn nếu muốn thay đổi):</label>
                        <input type="file" name="logo" id="modal-logo" class="modal-product-container-content_input" accept="image/jpeg, image/png, image/gif, image/svg+xml">
                    </div>
                    <div class="form-group">
                        <label class="modal-product-container-content_label" for="modal-link">Link website (URL đầy đủ):</label>
                        <input type="url" class="modal-product-container-content_input" name="link" id="modal-link" value="${currentData?.link ? htmlspecialchars_decode(currentData.link) : ''}" placeholder="https://example.com">
                    </div>
                    <div class="form-group">
                        <label class="modal-product-container-content_label" for="modal-sort-order">Thứ tự hiển thị *</label>
                        <input type="number" min="0" class="modal-product-container-content_input" name="sort_order" id="modal-sort-order" value="${currentData?.sort_order ?? '0'}" required>
                    </div>
                `;
                break;

            case 'team':
                modalHeading.textContent = isEditing ? 'Chỉnh Sửa Thành Viên' : 'Thêm Thành Viên';
                currentData = isEditing ? (teamData[id] || null) : null;
                formHtml = `
                    <div class="form-group">
                        <label class="modal-product-container-content_label" for="modal-name">Tên thành viên *</label>
                        <input type="text" class="modal-product-container-content_input" name="name" id="modal-name" value="${currentData?.name ? htmlspecialchars_decode(currentData.name) : ''}" required>
                    </div>
                    <div class="form-group">
                        <label class="modal-product-container-content_label" for="modal-position">Chức vụ *</label>
                        <input type="text" class="modal-product-container-content_input" name="position" id="modal-position" value="${currentData?.position ? htmlspecialchars_decode(currentData.position) : ''}" required>
                    </div>
                    <div class="form-group">
                        <label class="modal-product-container-content_label">Ảnh hiện tại:</label>
                        ${currentData?.image_path && currentData.image_path !== '' ? `<img src="${baseImageUrl}${currentData.image_path}" width="80" style="margin-bottom: 5px; border:1px solid #ccc; padding:2px;"><br>` : '<i>(Không có)</i><br>'}
                        <label class="modal-product-container-content_label" for="modal-image">Tải lên ảnh mới (chọn nếu muốn thay đổi):</label>
                        <input type="file" name="image" id="modal-image" class="modal-product-container-content_input" accept="image/jpeg, image/png, image/gif">
                    </div>
                    <div class="form-group">
                        <label class="modal-product-container-content_label" for="modal-description">Mô tả *</label>
                        <textarea class="modal-product-container-content_input" name="description" id="modal-description" rows="4" required>${currentData?.description ? htmlspecialchars_decode(currentData.description) : ''}</textarea>
                    </div>
                    <div class="form-group">
                        <label class="modal-product-container-content_label" for="modal-sort-order">Thứ tự hiển thị *</label>
                        <input type="number" min="0" class="modal-product-container-content_input" name="sort_order" id="modal-sort-order" value="${currentData?.sort_order ?? '0'}" required>
                    </div>
                `;
                break;

            case 'testimonial':
                modalHeading.textContent = isEditing ? 'Chỉnh Sửa Đánh Giá' : 'Thêm Đánh Giá';
                currentData = isEditing ? (testimonialsData[id] || null) : null;
                formHtml = `
                    <div class="form-group">
                        <label class="modal-product-container-content_label" for="modal-customer-name">Tên khách hàng *</label>
                        <input type="text" class="modal-product-container-content_input" name="customer_name" id="modal-customer-name" value="${currentData?.customer_name ? htmlspecialchars_decode(currentData.customer_name) : ''}" required>
                    </div>
                    <div class="form-group">
                        <label class="modal-product-container-content_label" for="modal-content">Nội dung đánh giá *</label>
                        <textarea class="modal-product-container-content_input" name="content" id="modal-content" rows="4" required>${currentData?.content ? htmlspecialchars_decode(currentData.content) : ''}</textarea>
                    </div>
                    <div class="form-group">
                        <label class="modal-product-container-content_label" for="modal-location">Địa điểm (Tỉnh/Thành phố):</label>
                        <input type="text" class="modal-product-container-content_input" name="location" id="modal-location" value="${currentData?.location ? htmlspecialchars_decode(currentData.location) : ''}">
                    </div>
                    <div class="form-group">
                        <label class="modal-product-container-content_label">Ảnh hiện tại:</label>
                        ${currentData?.image_path && currentData.image_path !== '' ? `<img src="${baseImageUrl}${currentData.image_path}" width="80" style="margin-bottom: 5px; border:1px solid #ccc; padding:2px;"><br>` : '<i>(Không có)</i><br>'}
                        <label class="modal-product-container-content_label" for="modal-image">Tải lên ảnh mới (chọn nếu muốn thay đổi):</label>
                        <input type="file" name="image" id="modal-image" class="modal-product-container-content_input" accept="image/jpeg, image/png, image/gif">
                    </div>
                    <div class="form-group">
                        <label class="modal-product-container-content_label" for="modal-sort-order">Thứ tự hiển thị *</label>
                        <input type="number" min="0" class="modal-product-container-content_input" name="sort_order" id="modal-sort-order" value="${currentData?.sort_order ?? '0'}" required>
                    </div>
                `;
                break;

            // Add cases for 'commitment', etc. generating their respective form fields
            /*
            case 'commitment':
                 modalHeading.textContent = isEditing ? 'Chỉnh Sửa Cam Kết' : 'Thêm Cam Kết';
                 currentData = isEditing ? (commitmentsData[id] || null) : null; // Assuming commitmentsData exists
                 formHtml = `... form fields for commitment title, description, icon ...`;
                 break;
            */

            default:
                formHtml = '<p style="color: red;">Lỗi: Loại nội dung không được hỗ trợ hoặc chưa được định nghĩa.</p>';
                modalHeading.textContent = 'Lỗi';
        }

        modalContent.innerHTML = formHtml;
        modal.style.display = 'flex'; // Show the modal using flex for centering
    }

    // --- Helper function to decode HTML entities ---
    // This is crucial for correctly displaying text in form fields that might contain HTML special chars
    function htmlspecialchars_decode(str) {
        if (typeof str !== 'string') return str; // Return input if not a string
        const RARE_CHAR = '__RARE_AMPERSAND__'; // Temporary placeholder for ampersands
        const temp = document.createElement("textarea");
        // Temporarily replace ampersands to prevent double decoding issues like & becoming &
        str = str.replace(/&/g, RARE_CHAR);
        temp.innerHTML = str;
        let decoded = temp.value;
        // Restore the original ampersands
        decoded = decoded.replace(new RegExp(RARE_CHAR, 'g'), '&');
        return decoded;
    }

    // --- Initial Setup on Page Load ---
    document.addEventListener('DOMContentLoaded', function() {
       // Activate the first tab by default
       const firstTabButton = document.querySelector('.container-product__tabs .tab-btn');
       if (firstTabButton) {
           // Extract tabName from onclick attribute (a bit fragile, depends on format)
           const onclickAttr = firstTabButton.getAttribute('onclick');
           const match = onclickAttr ? onclickAttr.match(/openTab\(event, '([^']+)'\)/) : null;
           if (match && match[1]) {
               const firstTabName = match[1];
               // Ensure the content div exists before trying to display it
               const firstTabContent = document.getElementById(firstTabName);
               if(firstTabContent){
                    firstTabContent.style.display = 'block';
                    firstTabContent.classList.add('active');
                    firstTabButton.classList.add('active'); // Ensure button is also active visually
               } else {
                   console.warn(`Content div with ID '${firstTabName}' not found for the first tab.`);
                   // Hide all tabs as a fallback if the target doesn't exist
                    let tabcontent = document.getElementsByClassName("tab-content");
                    for (let i = 0; i < tabcontent.length; i++) {
                        tabcontent[i].style.display = "none";
                        tabcontent[i].classList.remove("active");
                    }
               }
           } else {
               console.warn("Could not determine first tab name from button's onclick attribute.");
           }
       } else {
           console.warn("No tab buttons found to activate the first tab.");
       }

        // --- Dynamically Add CSS Rules for Modal Form ---
        // This avoids needing separate CSS file includes just for the modal form styles
        // if they aren't already globally defined.
        const styleSheet = document.styleSheets[0] || (function() {
            const style = document.createElement('style');
            document.head.appendChild(style);
            return style.sheet;
        })();

        const cssRules = [
            `.modal .form-group { margin-bottom: 15px; }`,
            `.modal .form-group label { display: block; margin-bottom: 6px; font-weight: 500; font-size: 14px; color: #444; }`,
            `.modal .form-group .modal-product-container-content_input { width: 100%; padding: 9px 12px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; font-size: 14px; line-height: 1.5; transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out; }`,
            `.modal .form-group textarea.modal-product-container-content_input { min-height: 90px; resize: vertical; }`,
            `.modal .form-group input[type="file"].modal-product-container-content_input { padding: 5px; height: auto; background-color: #f8f9fa; border-style: dashed; }`,
            `.modal .form-group input:focus, .modal .form-group textarea:focus, .modal .form-group select:focus { border-color: #6750A4; outline: 0; box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25); }`,
            `.modal .form-group img { max-width: 120px; height: auto; display: inline-block; vertical-align: middle; margin-right: 10px; }` // Style for preview images
        ];

        cssRules.forEach(rule => {
            try {
                // Insert rule at the end of the stylesheet
                if (styleSheet.insertRule) {
                    styleSheet.insertRule(rule, styleSheet.cssRules.length);
                } else if (styleSheet.addRule) { // For older IE
                    styleSheet.addRule(selector, ruleBody, -1);
                }
            } catch (e) {
                // Ignore errors (e.g., if rule already exists or browser quirks)
                 // console.warn("Could not insert CSS rule dynamically: ", rule, e);
            }
        });
    });

</script>

<!-- Include CSS Styles -->
<style>
    /* General Page & Container Styles */
    body {
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        background-color: #f4f7f6;
        margin: 0;
        color: #333;
    }

    .container__product {
        padding: 20px 25px;
        margin: 20px;
        background-color: #ffffff; /* White background for content area */
        border-radius: 8px;
        box-shadow: 0 3px 15px rgba(0, 0, 0, 0.07);
        border: 1px solid #e9ecef;
    }

    /* Tab Navigation Styles */
    .container-product__tabs {
        display: flex;
        flex-wrap: wrap; /* Allow tabs to wrap on smaller screens */
        border-bottom: 2px solid #dee2e6;
        margin-bottom: 25px;
    }

    .tab-btn {
        padding: 12px 18px;
        border: none;
        background-color: transparent;
        cursor: pointer;
        font-size: 15px; /* Slightly smaller */
        color: #495057;
        margin-right: 5px; /* Spacing between tabs */
        margin-bottom: -2px; /* Overlap bottom border */
        border-bottom: 2px solid transparent;
        transition: color 0.2s ease-in-out, border-color 0.2s ease-in-out;
        outline: none;
        font-weight: 500;
    }

    .tab-btn:hover {
        color: #6750A4;
        border-bottom-color: #cce5ff; /* Light blue bottom border on hover */
    }

    .tab-btn.active {
        color: #6750A4;
        border-bottom-color: #6750A4;
        font-weight: 600;
    }

    /* Tab Content Styles */
    .tab-content {
        display: none; /* Hide inactive tabs */
        padding: 20px 15px; /* Adjusted padding */
        /* background-color: #ffffff; */ /* No separate background needed if container is white */
        /* border: 1px solid #e9ecef; */ /* Removed border as container has one */
        /* border-top: none; */
        /* border-radius: 0 0 6px 6px; */
        animation: fadeIn 0.4s ease-in-out;
    }

    .tab-content.active {
        display: block; /* Show active tab */
    }

    .tab-content__title {
        font-size: 20px; /* Adjusted size */
        font-weight: 600;
        color: #343a40;
        margin-top: 0;
        margin-bottom: 20px;
        padding-bottom: 12px; /* Adjusted padding */
        border-bottom: 1px solid #eee;
    }

    /* Add/Edit Button within Tabs */
    .container-product-header__insert {
        background-color: #6750A4; /* Info blue */
        color: white;
        padding: 8px 15px; /* Adjusted padding */
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 14px;
        font-weight: 500;
        margin-bottom: 20px;
        transition: background-color 0.2s ease, box-shadow 0.2s ease;
        display: inline-flex; /* Use flex for alignment */
        align-items: center;
        text-decoration: none; /* Remove underline if used as a link */
    }
     .container-product-header__insert:before { /* Optional: Add icon */
        content: 'add'; /* Material Symbols icon name */
        font-family: 'Material Symbols Outlined';
        margin-right: 6px;
        font-size: 18px;
        vertical-align: middle;
        line-height: 1;
    }


    .container-product-header__insert:hover {
        background-color: #6750A4;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    /* Data Table Styles */
    .data-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px; /* Reduced margin */
        background-color: #fff;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.06);
        border-radius: 6px;
        overflow: hidden; /* Important for rounded corners */
        border: 1px solid #e9ecef; /* Add subtle border around table */
    }

    .data-table th,
    .data-table td {
        border-bottom: 1px solid #e9ecef; /* Only bottom borders */
        padding: 12px 15px;
        text-align: left;
        font-size: 14px;
        vertical-align: middle;
    }
     .data-table td:last-child,
     .data-table th:last-child {
          /* text-align: right; */ /* Optional: align last column right */
     }
     .data-table tr td:first-child,
     .data-table tr th:first-child {
         padding-left: 20px; /* More padding for first column */
     }
      .data-table tr td:last-child,
     .data-table tr th:last-child {
         padding-right: 20px; /* More padding for last column */
     }


    .data-table thead th {
        background-color: #f8f9fa;
        font-weight: 600;
        color: #495057;
        white-space: nowrap;
        border-bottom-width: 2px; /* Thicker border below header */
    }

    .data-table tbody tr:nth-child(even) {
        /* background-color: #fdfdfe; */ /* Optional: Very light striping */
    }

    .data-table tbody tr:hover {
        background-color: #f1f5f9; /* Light blue hover */
    }
    .data-table tbody tr:last-child td {
        border-bottom: none; /* No border for last row */
    }


    /* Table Cell Specifics */
    .data-table td.actions {
        text-align: center; /* Center align action icons */
        white-space: nowrap;
        width: 1%; /* Let it take minimum necessary width */
        padding-left: 10px;
        padding-right: 10px;
    }

    .data-table td img {
        max-width: 120px;
        max-height: 60px;
        height: auto;
        display: block; /* Or inline-block if needed */
        border-radius: 4px;
        border: 1px solid #eee;
        padding: 2px;
        background-color: #fff;
    }

    .data-table i, /* Style for <i> icons */
    .data-table span[class*="fa-"], /* Style for Font Awesome spans */
    .data-table .material-symbols-outlined { /* Style for Material Symbols */
        font-size: 20px; /* Consistent icon size */
        vertical-align: middle;
        margin: 0 5px;
        cursor: pointer;
        transition: color 0.2s ease, transform 0.1s ease;
        display: inline-block; /* Ensure proper spacing and alignment */
        line-height: 1;
    }
    .data-table .material-symbols-outlined:hover {
        transform: scale(1.1); /* Slight zoom effect on hover */
    }


    .container-product-table__edit-icon { color: #ffc107; }
    .container-product-table__edit-icon:hover { color: #d39e00; }

    .container-product-table__delete-icon { color: #dc3545; }
    .container-product-table__delete-icon:hover { color: #b02a37; }

    .data-table i, .data-table em { /* Italic text for placeholders */
        color: #6c757d;
        font-style: italic;
    }
    .data-table a { /* Style links in table */
        color: #6750A4;
        text-decoration: none;
    }
    .data-table a:hover {
        text-decoration: underline;
    }


    /* Modal Styles */
    .modal {
        display: none; /* Hidden by default, shown by JS */
        position: fixed;
        z-index: 1050;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: hidden; /* Prevent body scroll when modal is open */
        background-color: rgba(0, 0, 0, 0.55); /* Slightly darker overlay */
        justify-content: center;
        align-items: center;
         animation: fadeIn 0.3s ease-out; /* Fade in background */
    }

    .modal.show { /* Class added by JS if needed */
        display: flex;
    }

    .modal__product {
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        width: 90%;
        max-width: 680px; /* Increased max width */
        position: relative;
        display: flex; /* Use flex for internal layout */
        flex-direction: column; /* Stack container vertically */
        max-height: 90vh; /* Limit height to viewport */
        animation: slideDown 0.4s ease-out;
        margin: 20px; /* Add margin for small screens */
    }

    .modal-product__container {
        padding: 25px 30px 30px 30px; /* Adjusted padding */
        display: flex;
        flex-direction: column;
        flex-grow: 1; /* Allow container to grow */
        overflow: hidden; /* Hide internal overflow initially */
        position: relative; /* For close button positioning */
    }

    .modal-product-container__heading {
        font-size: 20px;
        font-weight: 600;
        color: #333;
        margin: 0 0 20px 0; /* Reduced bottom margin */
        padding-bottom: 15px;
        border-bottom: 1px solid #e9ecef;
        flex-shrink: 0; /* Prevent heading from shrinking */
    }

    .modal-product-container__content {
        margin-bottom: 25px;
        flex-grow: 1; /* Allow content to take available space */
        overflow-y: auto; /* Add scroll *only* if content exceeds available height */
        padding-right: 10px; /* Space for scrollbar if needed */
        /* Styles added by JS: margin-bottom, label, input, textarea */
    }

    /* Modal Buttons */
    .modal-product-container__btn.edit {
        background-color: #6750A4;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 15px;
        font-weight: 500;
        transition: background-color 0.2s ease, box-shadow 0.2s ease;
        align-self: flex-end; /* Align button to the right */
        margin-top: auto; /* Push button to bottom if space allows */
        flex-shrink: 0; /* Prevent button from shrinking */
    }

    .modal-product-container__btn.edit:hover {
        background-color: #6750A4;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
    }

    .modal-product-container__close {
        position: absolute;
        top: 12px; /* Adjusted position */
        right: 15px;
        color: #6c757d;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
        line-height: 1;
        padding: 5px; /* Increase clickable area */
        transition: color 0.2s ease, transform 0.2s ease;
        z-index: 10; /* Ensure it's above content */
    }

    .modal-product-container__close:hover {
        color: #e74c3c; /* Red hover color */
        transform: rotate(90deg);
    }


    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes slideDown {
        from { transform: translateY(-25px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
</style>


<?php
// Close the database connection at the very end of the script
if (isset($con) && $con) {
    mysqli_close($con);
}
include './container-footer.php'; // Include the footer UI part
?>