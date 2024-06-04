<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Chat</title>
    <link rel="stylesheet" href="{{ asset('style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <div class="wrapper">
        <section class="users">
            <header>
                <div class="content">
                    @csrf
                    @if ($user->profile_image)
                    <img src="{{ asset('storage/photos/' . $user->profile_image) }}" alt="Profile Image">
                    @endif
                    <div class="details">
                        <span>{{ $user->first_name }} {{ $user->last_name }}</span>
                    </div>
                </div>
                <a href="{{ route('logout') }}" class="logout">Logout</a>
            </header>
            <div class="search">
                <span class="text">Select a user to start chat</span>
                <input type="text" placeholder="Enter name to search...">
                <button><i class="fas fa-search"></i></button>
            </div>
            <div class="users-list">
                <!-- User list will be populated here via AJAX -->
            </div>
        </section>
    </div>
    <script src="{{ asset('js/users.js') }}"></script>
</body>

</html>
