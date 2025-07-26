<?php
// Get bot token from environment variable
$bot_token = $_ENV['BOT_TOKEN'] ?? getenv('BOT_TOKEN');

if (!$bot_token) {
    http_response_code(500);
    die('Bot token not configured');
}

// Get incoming update
$update = json_decode(file_get_contents("php://input"), true);

// Function to send message
function sendMessage($chat_id, $text, $token) {
    $url = "https://api.telegram.org/bot{$token}/sendMessage";
    $data = [
        'chat_id' => $chat_id,
        'text' => $text
    ];
    
    $options = [
        'http' => [
            'header' => "Content-type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => http_build_query($data)
        ]
    ];
    
    return file_get_contents($url, false, stream_context_create($options));
}

// Process message
if (isset($update['message'])) {
    $message = $update['message'];
    $chat_id = $message['chat']['id'];
    $text = $message['text'] ?? '';
    
    if ($text === '/start') {
        sendMessage($chat_id, "🤖 Hello! I'm your AI Expert Bot. Send me any message!", $bot_token);
    } elseif ($text === '/help') {
        sendMessage($chat_id, "Available commands:\n/start - Start bot\n/help - Show help\n/ai - AI tips", $bot_token);
    } elseif ($text === '/ai') {
        sendMessage($chat_id, "💡 AI Expert Tips:\n1. Master prompting\n2. Stay updated\n3. Practice daily\n4. Build projects", $bot_token);
    } else {
        sendMessage($chat_id, "You said: " . $text . "\n\nTry /help for commands!", $bot_token);
    }
}

// Return OK to Telegram
http_response_code(200);
echo "OK";
?>
