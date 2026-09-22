<h3>Attachments</h3>
@if ($task->attachments)
    <ul>
        @foreach ($task->attachments as $attachment)
            <li><a href="{{ asset($attachment->path) }}" target="_blank">{{ $attachment->name. "- (".$attachment->size." kb)" }}</a></li>
        @endforeach
    </ul>
@endif
