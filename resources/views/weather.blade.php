<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seasonal Clothing Suggestion</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #74ebd5, #acb6e5);
            text-align: center;
            padding: 30px;
        }

        h1 {
            font-size: 28px;
            color: #333;
        }

        select, button {
            padding: 10px;
            font-size: 16px;
            border-radius: 8px;
            border: none;
            margin-top: 10px;
        }

        select {
            background-color: #fff;
            cursor: pointer;
        }

        button {
            background-color: #ff6b6b;
            color: white;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background-color: #ff4757;
        }

        .image-container {
            margin-top: 20px;
        }

        img {
            width: 400px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body>
    <h1>Clothing Suggestion for <span>{{ $season }}</span></h1>
    
    <form method="POST" action="/">
        @csrf
        <label for="season">Choose a season:</label>
        <select name="season" id="season">
            <option value="Winter" {{ $season == 'Winter' ? 'selected' : '' }}>Winter</option>
            <option value="Spring" {{ $season == 'Spring' ? 'selected' : '' }}>Spring</option>
            <option value="Summer" {{ $season == 'Summer' ? 'selected' : '' }}>Summer</option>
            <option value="Autumn" {{ $season == 'Autumn' ? 'selected' : '' }}>Autumn</option>
        </select>
        <button type="submit">Generate Clothing Image</button>
    </form>

    @if(isset($imageUrl))
        <div class="image-container">
            <h2>AI-Generated Clothing Image:</h2>
            <p>Suggested Clothing: {{ $clothingPrompt }}</p>
            <img src="{{ $imageUrl }}" alt="Clothing suggestion">
        </div>
    @endif
</body>
</html>
