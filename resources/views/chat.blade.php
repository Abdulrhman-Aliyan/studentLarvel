@extends('layout')

@section('content')
<!-- Include Bootstrap Icons CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css" rel="stylesheet">
<!-- Include Font Awesome CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

<style>
    .icon-btn {
        color: grey;
        transition: color 0.3s, box-shadow 0.3s, border-color 0.3s;
        transition: ease-in-out 0.2s;
    }
    .icon-btn:hover {
        color: var(--bs-primary);
        transition: ease-in-out 0.2s;
    }
    .icon-btn:active {
        color: var(--bs-primary) !important;
        box-shadow: 0 0 5px 2px var(--bs-primary);
        border: 0px solid var(--bs-primary);
        transition: ease-in-out 0.2s;
        border-radius: 50% !important;
    }
    .input-group .form-control,
    .input-group .btn {
        border-radius: 0.25rem;
    }
    .input-group {
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
    }
    .form-control {
        border-radius: 0.25rem;
    }
    .send-btn {
        border-radius: 0 0.25rem 0.25rem 0;
    }
    .container-fluid {
        height: calc(100vh - 112px); /* Adjust 56px to match your navbar height */
    }
    .row-full-height {
        height: 100%;
    }
    .message {
        margin-bottom: 10px;
        padding: 10px;
        border-radius: 10px;
        background-color: #f1f1f1;
        max-width: 45%;
        display: inline-block;
        word-wrap: break-word;
        position: relative;
    }
    .message.sent {
        background-color: var(--bs-primary);
        color: white;
        align-self: flex-end;
        margin-left: auto;
    }
    .message.received {
        align-self: flex-start;
    }
    .message.sent::after {
        content: '';
        position: absolute;
        top: 50%;
        right: -6px;
        width: 0;
        height: 0;
        border-left: 11px solid var(--bs-primary);
        border-top: 15px solid transparent;
    }
    .message.received::after {
        content: '';
        position: absolute;
        top: 50%;
        left: -6px;
        height: 0;
        border-right: 11px solid #f1f1f1;
        border-top: 15px solid transparent;
    }
    .chat-box {
        overflow-y: auto;
        -ms-overflow-style: none;  /* Internet Explorer 10+ */
        scrollbar-width: none;  /* Firefox */
        display: flex;
        flex-direction: column;
    }
    .chat-box::-webkit-scrollbar {
        display: none;  /* Safari and Chrome */
    }
</style>

<div class="container-fluid mt-5">
    <div class="row row-full-height">
        <!-- Friend Section -->
        <div class="col-md-3 d-flex flex-column align-items-center">
            <h4>Friends</h4>
            <ul class="list-group w-100">
                <!-- Example friend list items -->
                <li class="list-group-item d-flex align-items-center">
                    <i class="fas fa-user-friends mr-2"></i>
                    <img src="https://via.placeholder.com/30" alt="Friend 1" class="img-fluid rounded-circle mr-2">
                    Friend 1
                </li>
                <li class="list-group-item d-flex align-items-center">
                    <i class="fas fa-user-friends mr-2"></i>
                    <img src="https://via.placeholder.com/30" alt="Friend 2" class="img-fluid rounded-circle mr-2">
                    Friend 2
                </li>
                <li class="list-group-item d-flex align-items-center">
                    <i class="fas fa-user-friends mr-2"></i>
                    <img src="https://via.placeholder.com/30" alt="Friend 3" class="img-fluid rounded-circle mr-2">
                    Friend 3
                </li>
                <!-- Add more friends as needed -->
            </ul>
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
