<?php
// API キーを安全に格納 (例: 環境変数から取得)
require_once 'env.php';

function template()
{
    $template = '
{
        "plan": {
            "departure_point": "xxxx",
            "destination": "xxxx",
            "start_date": "xxxx-xx-xx",
            "end_date": "xxxx-xx-xx",
            "details": "xxxxxxxxxxx",
            "budget": "xxxxxx",
            "number_of_people": 2
        },
        "plan_schedule": [
            {
                "day": 1,
                "time": "xxxx-xx-xx xx:xx:xx",
                "activity": "xxxx"
            },
            {
                "day": 1,
                "time": "xxxx-xx-xx xx:xx:xx",
                "activity": "xxxx"
            },
            {
                "day": 2,
                "time": "xxxx-xx-xx xx:xx:xx",
                "activity": "xxxx"
            },
            {
                "day": 2,
                "time": "xxxx-xx-xx xx:xx:xx",
                "activity": "xxxx"
            }
        ]
    }';
    return $template;
}

// Gemini API 呼び出し関数
function callGeminiAPI($prompt, $api_key)
{
    $data = [
        'contents' => [
            [
                'parts' => [
                    ['text' => $prompt],
                ]
            ]
        ]
    ];

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

    curl_close($ch);

    return $json ?? null;
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
    $prompt = "次の条件で旅行プランを作成し、指定したJSONフォーマットのみでレスポンス（文章なし）:
    出発地点: $departure_point, 
    目的地: $destination, 
    日付: $start_date から $end_date, 
    予算: $budget 円, 
    人数: $num_people 人,
    各日のスケジュールには以下の詳細を含めてください:
    - 昼食: 具体的な店名とその場所を含める
    - 夕食: 具体的な店名とその場所を含める
    - 宿泊先: 具体的なホテルまたは旅館の名前と住所を含める
    レスポンスはテンプレートに従ってください。";
    $prompt .= PHP_EOL;
    $prompt .= "指定テンプレート:";
    $prompt .= template();
    $prompt .= PHP_EOL;
    // Gemini API 呼び出し実行
    $json = callGeminiAPI($prompt, GEMINI_API_KEY);

    // JSON を PHP の配列に変換
    if ($json) {
        $ai_plan = json_decode($json, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            // JSON データをセッションに保存して display.php にリダイレクト
            session_start();
            $_SESSION['ai_plan'] = $ai_plan;
            header('Location: display.php');
            exit();
        } else {
            $error_message = "JSON の解析中にエラーが発生しました。";
        }
    } else {
        $error_message = "API 呼び出しに失敗しました。";
    }
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
         body {
            font-family: 'Lora', serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(to right, #6a11cb, #2575fc); /* グラデーション背景 */
            background-size: cover;
            color: #fff;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .navbar {
            overflow: hidden;
            background-color: rgba(0, 0, 50, 0.8);
            padding: 0 20px;
            font-size: 18px;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }

        .navbar a {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 16px 20px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .navbar a:hover {
            background-color: #6ec1e4;
            transform: scale(1.05);
        }

        .form-container {
            max-width: 900px;
            width: 90%;
            margin: 120px auto; /* ナビゲーションバーの下に余白を追加 */
            padding: 30px;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(5px);
            color: #333;
        }

        h1 {
            text-align: center;
            color: #007BFF;
            font-size: 32px;
            margin-bottom: 20px;
            font-family: 'Roboto', sans-serif;
        }

        label {
            font-weight: bold;
            margin-bottom: 8px;
            display: block;
            color: #333;
        }

        input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-sizing: border-box;
            font-size: 16px;
            transition: border-color 0.3s;
        }

        input:focus {
            border-color: #007BFF;
            box-shadow: 0 0 8px rgba(0, 123, 255, 0.5);
            outline: none;
        }

        button {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #28a745, #218838);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            cursor: pointer;
            transition: background 0.3s, transform 0.2s;
        }

        button:hover {
            background: linear-gradient(135deg, #218838, #28a745);
            transform: translateY(-3px);
        }

        @media (max-width: 768px) {
            .form-container {
                max-width: 100%;
                padding: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="navbar">
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
        <label for="departure_point">出発地点:</label>
        <input type="text" id="departure_point" name="departure_point" required>
        <label for="destination">目的地:</label>
        <input type="text" id="destination" name="destination" required>
        <label for="start_date">開始日:</label>
        <input type="date" id="start_date" name="start_date" required>
        <label for="end_date">終了日:</label>
        <input type="date" id="end_date" name="end_date" required>
        <label for="budget">予算 (円):</label>
        <input type="number" id="budget" name="budget" required>
        <label for="num_people">人数:</label>
        <input type="number" id="num_people" name="num_people" required>
        <button type="submit">プランを作成</button>
    </form>

    <?php if (!empty($error_message)): ?>
        <p style="color: red; text-align: center;"><?= htmlspecialchars($error_message) ?></p>
    <?php endif; ?>
        <!-- Gemini の結果 -->
        <?php if (isset($ai_plan)): ?>
            <h2>生成された旅行プラン</h2>
            <pre><?= htmlspecialchars(json_encode($ai_plan, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)) ?></pre>
        <?php endif; ?>
    </div>
    <script>
        // ログアウト確認ダイアログ
        function confirmLogout() {
            var confirmation = confirm("本当にログアウトしますか？");
            if (confirmation) {
                window.location.href = "logout.php"; // OKが押された場合はログアウト
            }
        }
    </script>
</body>
</html>