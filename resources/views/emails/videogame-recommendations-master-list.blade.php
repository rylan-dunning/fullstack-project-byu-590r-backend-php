<!DOCTYPE html>
<html>
<head>
    <title>Video Game Recommendations</title>
</head>
<body>
    <h1>Check Out These New Games!</h1>
    
    <p>Hi there! Here are some recently added video games you might enjoy:</p>
    
    <ul>
        @foreach($games as $game)
            <li>
                <strong>{{ $game->title }}</strong> ({{ $game->year }})
                @if($game->esrbRating)
                    - Rated {{ $game->esrbRating->code }}
                @endif
                <p>{{ $game->description }}</p>
            </li>
        @endforeach
    </ul>
    
    <p>Visit our website to learn more about these games!</p>
    
    <p>Thanks,<br>
    The Video Games Team</p>
</body>
</html>