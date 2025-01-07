<?php

require __DIR__ . '/../vendor/autoload.php';

// Manually configure the database connection for standalone script
use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;

$capsule->addConnection([
    'driver' => 'mysql',
    'host' => env('DB_HOST', '127.0.0.1'),
    'database' => env('DB_DATABASE', 'forge'),
    'username' => env('DB_USERNAME', 'forge'),
    'password' => env('DB_PASSWORD', ''),
    'charset' => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix' => '',
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();

use Pusher\Pusher;

// Pusher configuration
$options = [
    'cluster' => 'ap2',
    'useTLS' => true
];

$pusher = new Pusher(
    'c9be7f6bf30ca36c9855',
    'ed83f45272a225867e2d',
    '1922132',
    $options
);

// Check if a message is being sent
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message'])) {
    $message = $_POST['message'];
    $recipientId = $_POST['recipient_id'];
    $senderId = $_POST['sender_id']; // Assuming sender_id is also sent in the request
    $data = ['message' => $message, 'recipient_id' => $recipientId, 'sender_id' => $senderId];

    // Save the message to the database
    Capsule::table('messages')->insert([
        'sender_id' => $senderId,
        'recipient_id' => $recipientId,
        'content' => $message,
        'created_at' => now(),
        'updated_at' => now()
    ]);

    // Log message submission
    error_log("Message sent: " . $message);

    // Trigger the event
    $pusher->trigger('private-chat.' . $recipientId, 'App\\Events\\MessageSent', $data);

    header('Content-Type: application/json');
    echo json_encode(['status' => 'Message Sent!']);
    exit;
}

// Check if a message is being received
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['recipient_id'])) {
    $recipientId = $_GET['recipient_id'];

    // Fetch messages from the database
    $messages = Capsule::table('messages')
        ->where('recipient_id', $recipientId)
        ->orWhere('sender_id', $recipientId)
        ->orderBy('created_at', 'asc')
        ->get();

    header('Content-Type: application/json');
    echo json_encode($messages);
    exit;
}

?>

<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script>
    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('c9be7f6bf30ca36c9855', {
        cluster: 'ap2',
        encrypted: true
    });

    var recipientId = <?php echo json_encode($_GET['recipient_id'] ?? null); ?>;
    var currentUserId = <?php echo json_encode($_GET['user_id'] ?? null); ?>; // Pass the user ID from the frontend
    if (recipientId) {
        var channel = pusher.subscribe('private-chat.' + recipientId);
        channel.bind('pusher:subscription_succeeded', function() {
            console.log('Subscribed to private-chat successfully');
        });
        channel.bind('App\\Events\\MessageSent', function(data) {
            console.log('Message received:', data.message);
            // Log message reception
            console.log('Message received from:', data.sender_id);
            // Use addMessage function to append the new message to the chat box
            addMessage(data.message, { id: data.sender_id });
        });
    }

    function addMessage(message, user) {
        const chatBox = document.querySelector('.chat-box');
        const messageElement = document.createElement('div');
        messageElement.classList.add('message', user.id === currentUserId ? 'sent' : 'received');
        messageElement.innerHTML = `<span>${message}</span>`;
        chatBox.appendChild(messageElement);
        chatBox.scrollTop = chatBox.scrollHeight;
    }
</script>