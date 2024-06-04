<!-- resources/views/partials/user-list.blade.php -->
@foreach($users as $otherUser)
<div class="user-item">
    <a href="{{ route('chat', $otherUser->id) }}">
        @if ($otherUser->profile_image)
        <img src="{{ asset('storage/photos/' . $otherUser->profile_image) }}" alt="Profile Image">
        @endif
        <div class="details">
            <span>{{ $otherUser->first_name }} {{ $otherUser->last_name }}</span>
        </div>
    </a>
</div>
@endforeach
