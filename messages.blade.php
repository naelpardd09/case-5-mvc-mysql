@foreach($messages as $message)
<div class="chat-message {{ $message->sender_id == Auth::id() ? 'sent' : 'received' }}">
    <p>{{ $message->message }}</p>
    <small>{{ $message->created_at->format('Y-m-d H:i:s') }}</small>
</div>
@endforeach
