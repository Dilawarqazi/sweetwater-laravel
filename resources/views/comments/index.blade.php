<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comments Report</title>
</head>
<body>
    <h1>Comments Report</h1>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif
    
    <form method="POST" action="{{ route('comments.update_ship_dates') }}">
        @csrf
        <button type="submit">Update Ship Dates</button>
    </form>

    @foreach ($groupedComments as $category => $comments)
        <h2>{{ $category }}</h2>
        <ul>
            @forelse ($comments as $comment)
                <li>{{ trim($comment) }}</li>
            @empty
                <li>No comments in this category.</li>
            @endforelse
        </ul>
    @endforeach

</body>
</html>
