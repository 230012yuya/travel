<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // フォームから送信されたデータの取得
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    // 他の必要なフィールドも取得すること

    // 画像のアップロード処理
    $target_dir = "uploads/"; // 画像を保存するディレクトリ
    $target_file = $target_dir . basename($_FILES["profile_image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // 画像ファイルが正しいかどうかをチェック
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["profile_image"]["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            echo "ファイルが画像ではありません。";
            $uploadOk = 0;
        }
    }

    // ファイルがすでに存在するかどうかをチェック
    if (file_exists($target_file)) {
        echo "すでに同じ名前のファイルが存在します。";
        $uploadOk = 0;
    }

    // ファイルサイズが制限を超えていないかチェック
    if ($_FILES["profile_image"]["size"] > 500000) {
        echo "ファイルサイズが大きすぎます。";
        $uploadOk = 0;
    }

    // 特定のファイル形式を許可するかどうかをチェック
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo "対応しているファイル形式は JPG, JPEG, PNG, GIF のみです。";
        $uploadOk = 0;
    }

    // アップロード処理を実行する
    if ($uploadOk == 0) {
        echo "ファイルはアップロードされませんでした。";
    } else {
        if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file)) {
            echo "ファイル ". htmlspecialchars( basename( $_FILES["profile_image"]["name"])). " がアップロードされました。";
        } else {
            echo "ファイルのアップロード中にエラーが発生しました。";
        }
    }

    // ここでデータベースに保存するなどの処理を行う

    // ユーザーを別のページにリダイレクトする
    header("Location: profile.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ユーザー登録</title>
</head>
<body>
    <h2>ユーザー登録フォーム</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
        <label>ユーザー名</label><br>
        <input type="text" name="username" required><br><br>

        <label>Eメール</label><br>
        <input type="email" name="email" required><br><br>

        <label>パスワード</label><br>
        <input type="password" name="password" required><br><br>

        <label>プロフィール画像を選択</label><br>
        <input type="file" name="profile_image" accept="image/*"><br><br>

        <!-- 他の必要なフィールドを追加 -->

        <input type="submit" value="登録する">
    </form>
</body>
</html>
