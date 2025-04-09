<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Seasonal Clothing Suggestion</title>
    <link rel="manifest" href="/manifest.json">
    <style>
        :root {
            --bg: #f5f5f5;
            --text: #333;
            --accent: #007BFF;
        }

        .dark-mode {
            --bg: #1e1e1e;
            --text: #f0f0f0;
            --accent: #66ccff;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            text-align: center;
            padding: 30px;
            background-color: var(--bg);
            color: var(--text);
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        h1, h3 {
            margin-bottom: 20px;
        }

        select, button {
            padding: 10px 15px;
            font-size: 16px;
            border-radius: 8px;
            border: none;
            margin: 10px;
            background-color: var(--accent);
            color: white;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        select {
            background-color: white;
            color: var(--text);
            border: 1px solid #ccc;
        }

        button:hover {
            background-color: #0056b3;
        }

        .image-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            margin-top: 30px;
        }

        .image-container img {
            width: 280px;
            height: auto;
            border-radius: 10px;
            box-shadow: 0px 6px 20px rgba(0, 0, 0, 0.2);
        }

        .download-btn {
            margin-top: 10px;
            background-color: #28a745;
        }

        .download-btn:hover {
            background-color: #218838;
        }

        ul {
            list-style: none;
            padding: 0;
            text-align: left;
            max-width: 500px;
            margin: 20px auto;
        }

        ul li::before {
            content: "✔️ ";
            margin-right: 5px;
            color: var(--accent);
        }
    </style>
</head>
<body>
<h1>Clothing Suggestion for <span>{{ $season }}</span></h1>

<button onclick="toggleTheme()">Toggle Theme</button>

<form method="POST" action="/">
    @csrf
    <div>
        <label for="season">Choose a season:</label>
        <select name="season" id="season">
            <option value="Winter" {{ $season == 'Winter' ? 'selected' : '' }}>Winter</option>
            <option value="Spring" {{ $season == 'Spring' ? 'selected' : '' }}>Spring</option>
            <option value="Summer" {{ $season == 'Summer' ? 'selected' : '' }}>Summer</option>
            <option value="Autumn" {{ $season == 'Autumn' ? 'selected' : '' }}>Autumn</option>
        </select>
    </div>

    <div>
        <label for="gender">Gender:</label>
        <select name="gender" id="gender">
            <option value="Unisex" {{ $gender == 'Unisex' ? 'selected' : '' }}>Unisex</option>
            <option value="Male" {{ $gender == 'Male' ? 'selected' : '' }}>Male</option>
            <option value="Female" {{ $gender == 'Female' ? 'selected' : '' }}>Female</option>
        </select>
    </div>

    <div>
        <label for="occasion">Occasion:</label>
        <select name="occasion" id="occasion">
            <option value="Casual" {{ $occasion == 'Casual' ? 'selected' : '' }}>Casual</option>
            <option value="Formal" {{ $occasion == 'Formal' ? 'selected' : '' }}>Formal</option>
            <option value="Party" {{ $occasion == 'Party' ? 'selected' : '' }}>Party</option>
        </select>
    </div>

    <button type="submit">Get Suggestions</button>
</form>

<button onclick="startListening()">🎤 Speak Season</button>

@if(isset($imageUrls))
    <div class="image-container">
        @foreach($imageUrls as $img)
            <div>
                <img src="{{ $img }}" alt="Suggested outfit">
                <br>
                <a href="{{ $img }}" download>
                    <button class="download-btn">Download</button>
                </a>
            </div>
        @endforeach
    </div>
@endif

@if(isset($tips))
    <h3>Tips for {{ $season }}</h3>
    <ul>
        @foreach($tips as $tip)
            <li>{{ $tip }}</li>
        @endforeach
    </ul>
@endif

<script>
    function toggleTheme() {
        document.body.classList.toggle("dark-mode");
    }

    function startListening() {
        const recognition = new webkitSpeechRecognition();
        recognition.lang = 'en-US';
        recognition.onresult = function(event) {
            const spoken = event.results[0][0].transcript.toLowerCase();
            const seasons = ['winter', 'spring', 'summer', 'autumn'];
            const match = seasons.find(s => spoken.includes(s));
            if (match) {
                document.getElementById('season').value = match.charAt(0).toUpperCase() + match.slice(1);
            }
        };
        recognition.start();
    }

    window.onload = function () {
        if (!document.getElementById('season').value) {
            navigator.geolocation.getCurrentPosition(async (position) => {
                const lat = position.coords.latitude;
                const month = new Date().getMonth() + 1;

                let season;
                if ((lat > 0 && [12, 1, 2].includes(month)) || (lat < 0 && [6, 7, 8].includes(month))) {
                    season = 'Winter';
                } else if ([3, 4, 5].includes(month)) {
                    season = 'Spring';
                } else if ([6, 7, 8].includes(month)) {
                    season = 'Summer';
                } else {
                    season = 'Autumn';
                }

                document.getElementById('season').value = season;
            });
        }
    }
</script>
</body>
</html>
