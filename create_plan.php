<?php
// API キーを安全に格納 (例: 環境変数から取得)
require_once 'env.php';

// Gemini API 呼び出し関数
function callGeminiAPI($prompt, $api_key)
{
    // API 呼び出しのためのデータ
    // $data = [
    //     'prompt' => $prompt,
    //     'max_tokens' => 1024,  // 必要に応じて調整
    // ];

    $data = [
        'contents' => [
            [
                'parts' => [
                    ['text' => $prompt],
                ]
            ]
        ]
    ];

    // $url = "https://generativelanguage.googleapis.com/v1beta2/models/gemini-1.5-chat:generate?key=" . $api_key;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=" . $api_key);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json'
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        echo json_encode(['error' => curl_error($ch)]);
    } else {
        $response_data = json_decode($response, true);
        if (isset($response_data['candidates'][0]['content']['parts'][0]['text'])) {
            $text = $response_data['candidates'][0]['content']['parts'][0]['text'];
            $json = str_replace(['```json', '```'], '', $text);
        }
    }

    // cURLセッションの終了
    curl_close($ch);

    return $json;
}


// フォームが送信されたときにデータを受け取る
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $departure_point = htmlspecialchars($_POST['departure_point']);
    $destination = htmlspecialchars($_POST['destination']);
    $start_date = htmlspecialchars($_POST['start_date']);
    $end_date = htmlspecialchars($_POST['end_date']);
    $budget = htmlspecialchars($_POST['budget']);
    $num_people = htmlspecialchars($_POST['num_people']);

    // API 呼び出しのためのプロンプト作成
    $prompt = "次の条件で旅行プランを作成し、JSONフォーマットのみでレスポンス（文章なし）
            出発地点: $departure_point, 
            目的地: $destination, 
            日付: $start_date から $end_date, 
            予算: $budget, 
            人数: $num_people";

    // API 呼び出し実行(JSON)
    $json = callGeminiAPI($prompt, GEMINI_API_KEY);

    // JSONをPHPの配列に変換
    $ai_plan = json_decode($json, true);
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>旅行プラン作成</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <style>
        /* CSS スタイル */
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f9ff;
            color: #333;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .navbar {
            overflow: hidden;
            background-color: rgba(50, 50, 70, 0.9);
            padding: 0 15px;
            font-size: 18px;
        }

        .navbar a {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
            font-weight: bold;
            transition: transform 0.3s ease, background-color 0.3s ease, color 0.3s ease;
        }

        .navbar a:hover {
            background-color: #ffb6b9;
            color: #fff;
            transform: scale(1.05);
        }

        .form-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 30px;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #ff6b6b;
        }

        label {
            font-weight: bold;
            margin-bottom: 5px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin: 5px 0 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        button {
            width: 100%;
            padding: 15px;
            background-color: #ff6b6b;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #ff3b3b;
        }

        .error-message {
            color: red;
            text-align: center;
            font-size: 16px;
        }
    </style>
</head>

<body>
    <div class="navbar" id="myNavbar">
        <a href="home.php">ホーム</a>
        <a href="create_plan.php">旅行プラン作成</a>
        <a href="display.php">旅行プラン表示</a>
        <a href="profile.php">プロフィール</a>
        <a href="view_plans.php">過去の旅行プラン</a>
        <a href="javascript:void(0);" onclick="confirmLogout()">ログアウト</a>
    </div>
    <div class="form-container">
        <h1>旅行プラン作成</h1>
        <form action="create_plan.php" method="post">
            <div>
                <label for="departure_point">出発地点:</label>
                <input type="text" id="departure_point" name="departure_point" required>
            </div>
            <div>
                <label for="destination">目的地:</label>
                <input type="text" id="destination" name="destination" required>
            </div>
            <div>
                <label for="start_date">開始日:</label>
                <input type="date" id="start_date" name="start_date" required>
            </div>
            <div>
                <label for="end_date">終了日:</label>
                <input type="date" id="end_date" name="end_date" required>
            </div>
            <div>
                <label for="budget">予算 (円):</label>
                <input type="number" id="budget" name="budget" required>
            </div>
            <div>
                <label for="num_people">人数:</label>
                <input type="number" id="num_people" name="num_people" required>
            </div>
            <button type="submit">プランを作成</button>
        </form>

        <?php if (isset($error_message)): ?>
            <p class="error-message"><?= htmlspecialchars($error_message) ?></p>
        <?php endif; ?>

        <!-- Gemini の結果 -->
        <?php if (isset($json)): ?>
            <div>
                <?= $json ?>
            </div>

            <div>
                <?php var_dump($ai_plan); ?>
            </div>
        <?php endif ?>
    </div>
</body>

</html>