<?php
// Telegram Bot Configuration
$bot_token = $_ENV['BOT_TOKEN']; // Environment variable for security
$api_url = "https://api.telegram.org/bot" . $bot_token;

// Get incoming webhook data
$update = json_decode(file_get_contents("php://input"), true);

// Function to send messages
function sendMessage($chat_id, $text, $bot_token) {
    $url = "https://api.telegram.org/bot{$bot_token}/sendMessage";
    $data = [
        'chat_id' => $chat_id,
        'text' => $text,
        'parse_mode' => 'HTML'
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

// Function to send photo
function sendPhoto($chat_id, $photo_url, $caption, $bot_token) {
    $url = "https://api.telegram.org/bot{$bot_token}/sendPhoto";
    $data = [
        'chat_id' => $chat_id,
        'photo' => $photo_url,
        'caption' => $caption
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

// Process incoming messages
if (isset($update['message'])) {
    $message = $update['message'];
    $chat_id = $message['chat']['id'];
    $user_id = $message['from']['id'];
    $username = $message['from']['username'] ?? 'User';
    $text = $message['text'] ?? '';
    
    // Command handling
    switch (true) {
        case $text === '/start':
            $welcome_text = "🤖 <b>Welcome to AI Expert Bot!</b>\n\n";
            $welcome_text .= "Hello <b>@{$username}</b>! I'm an AI-powered assistant.\n\n";
            $welcome_text .= "<b>Available Commands:</b>\n";
            $welcome_text .= "• /help - Show this help message\n";
            $welcome_text .= "• /ai - Get AI tips\n";
            $welcome_text .= "• /prompt - Get prompting advice\n";
            $welcome_text .= "• /earnings - Monetization tips\n";
            $welcome_text .= "• /about - About this bot\n\n";
            $welcome_text .= "💡 Just send me any message and I'll respond!";
            sendMessage($chat_id, $welcome_text, $bot_token);
            break;
            
        case $text === '/help':
            $help_text = "🔧 <b>Bot Commands Help</b>\n\n";
            $help_text .= "<b>Basic Commands:</b>\n";
            $help_text .= "• /start - Welcome message\n";
            $help_text .= "• /help - This help menu\n\n";
            $help_text .= "<b>AI Commands:</b>\n";
            $help_text .= "• /ai - AI expertise tips\n";
            $help_text .= "• /prompt - Prompting techniques\n";
            $help_text .= "• /earnings - Money-making strategies\n\n";
            $help_text .= "<b>Info Commands:</b>\n";
            $help_text .= "• /about - Bot information\n";
            $help_text .= "• /contact - Contact developer";
            sendMessage($chat_id, $help_text, $bot_token);
            break;
            
        case $text === '/ai':
            $ai_text = "🧠 <b>AI Expertise Tips</b>\n\n";
            $ai_text .= "1. <b>Stay Updated:</b> Follow latest AI research\n";
            $ai_text .= "2. <b>Practice Daily:</b> Use ChatGPT, Claude, Gemini\n";
            $ai_text .= "3. <b>Learn Prompting:</b> Master prompt engineering\n";
            $ai_text .= "4. <b>Build Projects:</b> Create AI-powered solutions\n";
            $ai_text .= "5. <b>Join Communities:</b> Network with AI experts\n\n";
            $ai_text .= "💰 <b>Monetization Ideas:</b>\n";
            $ai_text .= "• Freelance AI consulting\n";
            $ai_text .= "• Create AI courses\n";
            $ai_text .= "• Build AI tools/bots\n";
            $ai_text .= "• Content creation services";
            sendMessage($chat_id, $ai_text, $bot_token);
            break;
            
        case $text === '/prompt':
            $prompt_text = "✍️ <b>Advanced Prompting Techniques</b>\n\n";
            $prompt_text .= "<b>1. Be Specific:</b>\n";
            $prompt_text .= "❌ 'Write content'\n";
            $prompt_text .= "✅ 'Write a 500-word blog about AI in healthcare'\n\n";
            $prompt_text .= "<b>2. Use Context:</b>\n";
            $prompt_text .= "• Set role: 'You are an expert...'\n";
            $prompt_text .= "• Provide examples\n";
            $prompt_text .= "• Define output format\n\n";
            $prompt_text .= "<b>3. Chain of Thought:</b>\n";
            $prompt_text .= "• Ask for step-by-step reasoning\n";
            $prompt_text .= "• Use 'Think step by step'\n\n";
            $prompt_text .= "<b>4. Iterate & Refine:</b>\n";
            $prompt_text .= "• Test different approaches\n";
            $prompt_text .= "• Refine based on outputs";
            sendMessage($chat_id, $prompt_text, $bot_token);
            break;
            
        case $text === '/earnings':
            $earnings_text = "💰 <b>AI Monetization Strategies</b>\n\n";
            $earnings_text .= "<b>Quick Start (₹10k-50k/month):</b>\n";
            $earnings_text .= "• Fiverr AI services\n";
            $earnings_text .= "• Upwork consulting\n";
            $earnings_text .= "• Content writing with AI\n\n";
            $earnings_text .= "<b>Medium Term (₹50k-2L/month):</b>\n";
            $earnings_text .= "• Create online courses\n";
            $earnings_text .= "• Build SaaS tools\n";
            $earnings_text .= "• AI automation services\n\n";
            $earnings_text .= "<b>Long Term (₹2L+/month):</b>\n";
            $earnings_text .= "• AI consultancy firm\n";
            $earnings_text .= "• Product development\n";
            $earnings_text .= "• Training & workshops\n\n";
            $earnings_text .= "🚀 <b>Start Today:</b> Pick one strategy and execute!";
            sendMessage($chat_id, $earnings_text, $bot_token);
            break;
            
        case $text === '/about':
            $about_text = "ℹ️ <b>About AI Expert Bot</b>\n\n";
            $about_text .= "🤖 <b>Version:</b> 1.0\n";
            $about_text .= "🏗️ <b>Built with:</b> PHP + Vercel\n";
            $about_text .= "⚡ <b>Powered by:</b> Telegram Bot API\n";
            $about_text .= "🇮🇳 <b>Developed in:</b> India\n\n";
            $about_text .= "This bot helps AI enthusiasts learn, grow, and monetize their expertise.\n\n";
            $about_text .= "🎯 <b>Purpose:</b> Empowering AI learners\n";
            $about_text .= "💡 <b>Focus:</b> Practical AI knowledge\n";
            $about_text .= "🚀 <b>Goal:</b> Help you earn with AI skills";
            sendMessage($chat_id, $about_text, $bot_token);
            break;
            
        default:
            // Echo user message with AI-powered response
            if (!empty($text) && $text[0] !== '/') {
                $response_text = "🤖 <b>AI Assistant Response:</b>\n\n";
                $response_text .= "You said: <i>\"{$text}\"</i>\n\n";
                
                // Simple AI-like responses based on keywords
                if (stripos($text, 'hello') !== false || stripos($text, 'hi') !== false) {
                    $response_text .= "Hello @{$username}! 👋 I'm here to help you with AI expertise and earning strategies. Try /ai for tips!";
                } elseif (stripos($text, 'help') !== false) {
                    $response_text .= "I can help you with AI, prompting, and monetization strategies. Use /help to see all commands!";
                } elseif (stripos($text, 'money') !== false || stripos($text, 'earn') !== false) {
                    $response_text .= "Great question about earning! Check /earnings for detailed monetization strategies with AI.";
                } elseif (stripos($text, 'ai') !== false || stripos($text, 'artificial') !== false) {
                    $response_text .= "AI is the future! Use /ai to get expert tips and /prompt for advanced prompting techniques.";
                } else {
                    $response_text .= "Interesting message! I'm an AI expert bot. Try these commands:\n• /ai - AI tips\n• /earnings - Money strategies\n• /prompt - Prompting guides";
                }
                
                sendMessage($chat_id, $response_text, $bot_token);
            }
            break;
    }
}

// Return OK status to Telegram
http_response_code(200);
echo "OK";
?>
