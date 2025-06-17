<?php
$reply = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['prompt'])) {
    $apiKey = ""; //PASTEKAN API KEY DISINI DIDALAM TANDA KUTIP  
    $prompt = trim($_POST['prompt']);

    $data = [
        "model" => "gpt-4o-mini",
        "messages" => [
            ["role" => "user", "content" => $prompt]
        ],
        "temperature" => 0.7
    ];

    $ch = curl_init("https://api.openai.com/v1/chat/completions");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer $apiKey",
        "Content-Type: application/json"
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    $response = curl_exec($ch);
    curl_close($ch);

    $result = json_decode($response, true);
    $reply = $result['choices'][0]['message']['content'] ?? "Tidak ada respon.";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Chatbot AI (OpenAI)</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .chat-container { max-width: 600px; margin: 50px auto; }
        .chat-box { background: #fff; border-radius: 8px; padding: 20px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .user-msg { background-color: #007bff; color: #fff; padding: 8px 12px; border-radius: 12px; margin-bottom: 8px; }
        .bot-msg { background-color: #e9ecef; padding: 8px 12px; border-radius: 12px; margin-bottom: 8px; }
    </style>
</head>
<body>
    <div class="chat-container">
        <div class="chat-box">
            <h4 class="mb-3">Chatbot Sederhana (OpenAI)</h4> <br>
            <h3>Recruitment Web Developer & IT Support | XIONCO 2025 | Zainul Adensyah</h3>
            <form method="POST">
                <textarea name="prompt" class="form-control mb-2" rows="3" placeholder="Tulis pertanyaan Anda..." required><?= htmlspecialchars($_POST['prompt'] ?? '') ?></textarea>
                <button type="submit" class="btn btn-primary w-100">Kirim</button>
            </form>

            <?php if (!empty($reply)): ?>
                <div class="mt-4">
                    <div class="user-msg"><strong>Anda:</strong> <?= nl2br(htmlspecialchars($_POST['prompt'])) ?></div>
                    <div class="bot-msg"><strong>Bot:</strong> <?= nl2br(htmlspecialchars($reply)) ?></div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
