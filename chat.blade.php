<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat with {{ $receiver->first_name }}</title>
    <link rel="stylesheet" href="{{ asset('style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <div>
        <button class="button-chat" onclick="myFunction()"><i class="far fa-comment-alt"></i></button>
    </div>
    <div class="wrapper-chat" id="chat">
        <section class="chat-area">
            <header>
                <a href="{{ route('home') }}" class="back-icon"><i class="fas fa-arrow-left"></i></a>
                @if ($receiver->profile_image)
                <img src="{{ asset('storage/photos/' . $receiver->profile_image) }}" alt="Profile Image" class="profile-img">
                @endif
                <div class="details">
                    <span>{{ $receiver->first_name }} {{ $receiver->last_name }}</span>
                    <p>Active now</p>
                </div>
            </header>
            <div class="chat-box">
                @include('partials.messages', ['messages' => $messages])
            </div>
            <form action="#" class="typing-area" autocomplete="off">
                @csrf
                <input type="text" name="receiver_id" value="{{ $receiver->id }}" hidden>
                <input type="text" name="message" class="input-field" placeholder="Type a message here...">
                <button><i class="fab fa-telegram-plane"></i></button>
            </form>
        </section>
    </div>
</body>
<script>
    function myFunction() {
        var chat = document.getElementById("chat");
        chat.hidden = !chat.hidden;
    }
</script>
<script src="{{ asset('js/chat.js') }}"></script>
</html>
