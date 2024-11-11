<?php
session_start();

$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "travel";

$conn = new mysqli($servername, $db_username, $db_password, $dbname);

if ($conn->connect_error) {
    die("接続失敗: " . $conn->connect_error);
}

$user = $_POST['name'];
$email = $_POST['email'];
$pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
$profile_image = $_FILES['profile_image']['name'];  // 画像ファイルの名前

// 画像のアップロード処理
if ($profile_image) {
    $target_dir = "uploads/";
if (!is_dir($target_dir)) {
    mkdir($target_dir, 0777, true); // ディレクトリが存在しない場合は作成
}

    $target_file = $target_dir . basename($profile_image);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // 画像の検証（拡張子とサイズ）
    $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
    $max_size = 5 * 1024 * 1024; // 最大5MB

    if (in_array($imageFileType, $allowed_extensions) && $_FILES['profile_image']['size'] <= $max_size) {
        if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $target_file)) {
            // 画像をアップロードしたら、そのパスを保存
            $profile_image = basename($profile_image);
        } else {
            echo "画像のアップロードに失敗しました。";
            exit;
        }
    } else {
        echo "無効な画像ファイルまたはファイルサイズが大きすぎます。";
        exit;
    }
}

$sql = "INSERT INTO user (name, email, password, profile_image) VALUES ('$user', '$email', '$pass', '$profile_image')";

if ($conn->query($sql) === TRUE) {
    $_SESSION['loggedin'] = true;
    $_SESSION['name'] = $user;
    $_SESSION['profile_image'] = $profile_image;  // セッションに画像を保存
    header("Location: home.php");
} else {
    echo "エラー: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
