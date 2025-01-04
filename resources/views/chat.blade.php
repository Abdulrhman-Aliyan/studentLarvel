@extends('layout')

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
                    <li class="list-group-item d-flex align-items-center" onclick="selectFriend(this)">
                        <i class="fas fa-user-friends mr-2"></i>
                        <img src="https://via.placeholder.com/30" alt="Friend 1" class="img-fluid rounded-circle mr-2">
                        Friend 1
                    </li>
                    <li class="list-group-item d-flex align-items-center" onclick="selectFriend(this)">
                        <i class="fas fa-user-friends mr-2"></i>
                        <img src="https://via.placeholder.com/30" alt="Friend 2" class="img-fluid rounded-circle mr-2">
                        Friend 2
                    </li>
                    <li class="list-group-item d-flex align-items-center" onclick="selectFriend(this)">
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
                <div class="message received">Hello, how are you?</div>
                <div class="message sent">I'm good, thanks! How about you?</div>
                <div class="message received">I'm doing well, thank you!</div>
                <div class="message sent">Great to hear!</div>
                <div class="message received">What are you up to?</div>
                <div class="message sent">Just working on a project. You?</div>
                <div class="message received">Same here, just coding away.</div>
                <div class="message sent">Nice! Keep it up!</div>
                <div class="message received">Thanks, you too!</div>
                <!-- Add more dummy messages as needed -->
            </div>
            <div class="input-group mb-3" style="position: sticky; bottom: 0; background: white;">
                <input type="text" class="form-control flex-grow-1" placeholder="Type a message..." style="height: 50px; border: none;">
                <button class="btn icon-btn send-icon send-btn" type="button" style="border: none;">
                    <i class="bi bi-caret-right-fill" style="font-size: 1.5rem;"></i>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

<script>
    function selectFriend(element) {
        const friends = document.querySelectorAll('.list-group-item');
        friends.forEach(friend => friend.classList.remove('active'));
        element.classList.add('active');
    }
</script>
