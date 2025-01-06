@extends('layout')

@section('head')
    <script src="https://js.pusher.com/8.3.0/pusher.min.js"></script>
    <script>
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('855d5672d0118b36d4a5', {
            cluster: 'ap2'
        });

        var channel = pusher.subscribe('chat-channel');
        channel.bind('message-sent', function(data) {
            if (data.user.id === selectedFriendId || data.user.id === {{ auth()->id() }}) {
                addMessage(data.message, data.user);
            }
            console.log('Received message:', data.message);
        });

        let selectedFriendId = null;

        function addMessage(message, user) {
            const chatBox = document.querySelector('.chat-box');
            const messageElement = document.createElement('div');
            messageElement.classList.add('message', user.id === {{ auth()->id() }} ? 'sent' : 'received');
            messageElement.innerHTML = `<span>${message}</span>`;
            chatBox.appendChild(messageElement);
            chatBox.scrollTop = chatBox.scrollHeight;
        }

        function loadMessages(friendId) {
            fetch(`/messages/${friendId}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    const chatBox = document.querySelector('.chat-box');
                    chatBox.innerHTML = ''; // Clear existing messages
                    if (data.length > 0) {
                        data.forEach(message => {
                            addMessage(message.message, { id: message.sender_id });
                        });
                    } else {
                        chatBox.innerHTML = '<div class="no-friend-selected">No messages found</div>';
                    }
                })
                .catch(error => {
                    console.error('Error loading messages:', error);
                    const chatBox = document.querySelector('.chat-box');
                    chatBox.innerHTML = '<div class="no-friend-selected">Failed to load messages</div>';
                });
        }

        document.addEventListener('DOMContentLoaded', function() {
            console.log('Page loaded');
            const chatBox = document.querySelector('.chat-box');
            chatBox.innerHTML = '<div class="no-friend-selected">No friend selected</div>';
            fetchColleagues(); // Fetch colleagues on page load

            // Fetch and log all messages and their senders
            fetch('/messages/all')
                .then(response => response.json())
                .then(data => {
                    console.log('All messages and their senders:', data);
                })
                .catch(error => console.error('Error fetching all messages:', error));
        });

        function displayColleagues(data) {
            const friendsList = $('.friends-list .list-group');
            friendsList.empty();

            $.each(data, function (index, colleagueData) {
                const colleague = colleagueData.colleague;
                const subjectBadges = colleagueData.shared_subjects.map(subject =>
                    `<div class="m-1 badge bg-dark d-none">${subject}</div>` // Initially hide badges
                ).join('');

                const listItem = $(`
                    <li class="list-group-item d-flex align-items-center" onclick="selectFriend(this, ${colleague.id})">
                        <i class="fas fa-user-friends mr-2"></i>
                        <span>${colleague.name}</span>
                        <div class="d-flex flex-wrap w-100">
                            ${subjectBadges}
                        <div>
                    </li>
                `);

                listItem.hover(function() {
                    $(this).find('.badge').removeClass('d-none'); // Show badges on hover
                    $(this).addClass('expanded'); // Add 'expanded' class for size increase
                }, function() {
                    $(this).find('.badge').addClass('d-none'); // Hide badges on hover out
                    $(this).removeClass('expanded'); // Remove 'expanded' class
                });

                friendsList.append(listItem);

                // Select the first friend fetched
                if (index === 0) {
                    selectFriend(listItem[0], colleague.id);
                }
            });
        }

        function selectFriend(element, friendId) {
            const friends = document.querySelectorAll('.list-group-item');
            friends.forEach(friend => friend.classList.remove('active'));
            element.classList.add('active');
            selectedFriendId = friendId;
            loadMessages(friendId); // Load messages for the selected friend
        }

    </script>

    @vite(['resources/js/app.js'])
@endsection

@section('content')
<!-- Include Bootstrap Icons CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css" rel="stylesheet">
<!-- Include Font Awesome CSS -->
<link href="{{ asset('css/style.css') }}" rel="stylesheet">

<div class="container-fluid mt-5">
    <div class="row row-full-height">
        <!-- Friend Section -->
        <div class="col-md-3 d-flex flex-column align-items-center">
            <h4>Friends</h4>
            <div class="friends-list flex-grow-1 border rounded mb-3 w-100">
                <ul class="list-group w-100">
                    <!-- Example friend list items -->
                    <li class="list-group-item d-flex align-items-center" onclick="selectFriend(this, 1)">
                        <i class="fas fa-user-friends mr-2"></i>
                        <img src="https://via.placeholder.com/30" alt="Friend 1" class="img-fluid rounded-circle mr-2">
                        Friend 1
                    </li>
                    <li class="list-group-item d-flex align-items-center" onclick="selectFriend(this, 2)">
                        <i class="fas fa-user-friends mr-2"></i>
                        <img src="https://via.placeholder.com/30" alt="Friend 2" class="img-fluid rounded-circle mr-2">
                        Friend 2
                    </li>
                    <li class="list-group-item d-flex align-items-center" onclick="selectFriend(this, 3)">
                        <i class="fas fa-user-friends mr-2"></i>
                        <img src="https://via.placeholder.com/30" alt="Friend 3" class="img-fluid rounded-circle mr-2">
                        Friend 3
                    </li>
                    <!-- Add more friends as needed -->
                </ul>
            </div>
        </div>

        <!-- Messages Section -->
        <div class="col-md-9 d-flex flex-column h-100">
            <h4>Messages</h4>
            <div class="chat-box flex-grow-1 border rounded p-3 mb-3">
                <!-- Dummy messages -->
                <div class="message received"><span>Hello, how are you?</span></div>
                <div class="message sent"><span>I'm good, thanks! How about you?</span></div>
                <div class="message received"><span>I'm doing well, thank you!</span></div>
                <div class="message sent"><span>Great to hear!</span></div>
                <div class="message received"><span>What are you up to?</span></div>
                <div class="message sent"><span>Just working on a project. You?</span></div>
                <div class="message received"><span>Same here, just coding away.</span></div>
                <div class="message sent"><span>Nice! Keep it up!</span></div>
                <div class="message received"><span>Thanks, you too!</span></div>
                <!-- Add more dummy messages as needed -->
            </div>
            <div class="input-group mb-3" style="position: sticky; bottom: 0; background: white;">
                <input type="text" class="form-control flex-grow-1" placeholder="Type a message..." style="height: 50px; border: none;" id="messageInput">
                <button class="btn icon-btn send-icon send-btn" type="button" style="border: none;" onclick="sendMessage()">
                    <i class="bi bi-caret-right-fill" style="font-size: 1.5rem;"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function selectFriend(element, friendId) {
        const friends = document.querySelectorAll('.list-group-item');
        friends.forEach(friend => friend.classList.remove('active'));
        element.classList.add('active');
        selectedFriendId = friendId;
        loadMessages(friendId); // Load messages for the selected friend
    }

    // AJAX call to fetch colleagues and their shared subjects
    function fetchColleagues() {
        console.log('Fetching colleagues...');
        const studentId = {{ auth()->id() }}; // The student ID to fetch colleagues for
        $.ajax({
            url: `/students/${studentId}/colleagues-with-shared-subjects`,
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // CSRF token for security
            },
            success: function (data) {
                console.log('Colleagues with Shared Subjects:', data);
                displayColleagues(data);  // Display the fetched colleagues in the list
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error('Error fetching colleagues:', textStatus, errorThrown);
            }
        });
    }

    // Trigger the function to fetch and display colleagues
    fetchColleagues();

    function sendMessage() {
        const messageInput = document.getElementById('messageInput');
        const message = messageInput.value;

        if (message.trim() === '' || selectedFriendId === null) return;

        fetch(`/send-message/${selectedFriendId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ message })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'Message Sent!') {
                messageInput.value = '';
                addMessage(message, { id: {{ auth()->id() }} }); // Add the sent message to the chat box
            } else {
                console.error('Error:', data);
            }
        })
        .catch(error => console.error('Error:', error));
    }
</script>
@endsection

