<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Seasonal Clothing Suggestion</title>
    <link rel="manifest" href="/manifest.json">
    <style>
        /* Root CSS Variables */
        :root {
            --bg-light: #f7f7f7;
            --bg-dark: #181818;
            --text-light: #f5f5f5;
            --text-dark: #2f2f2f;
            --accent-color: #3498db;
            --highlight-color: #f39c12;
            --button-hover-color: #2980b9;
            --card-shadow: rgba(0, 0, 0, 0.1);
            --transition-speed: 0.3s;
            --font-family: 'Roboto', sans-serif;
        }

        /* Dark Mode */
        .dark-mode {
            --bg-light: #2e2e2e;
            --text-light: #e6e6e6;
            --accent-color: #1abc9c;
            --highlight-color: #ff6347;
        }

        body {
            font-family: var(--font-family);
            background-color: var(--bg-light);
            color: var(--text-dark);
            padding: 50px 20px;
            margin: 0;
            transition: background-color var(--transition-speed), color var(--transition-speed);
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        h1, h3 {
            font-size: 2.5rem;
            color: var(--accent-color);
            margin-bottom: 30px;
            text-align: center;
            font-weight: 700;
            letter-spacing: 1px;
        }

        /* Form Section Styling */
        form {
            width: 100%;
            max-width: 550px;
            background-color: #fff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0px 6px 25px var(--card-shadow);
            text-align: left;
            transition: box-shadow var(--transition-speed);
        }

        form:hover {
            box-shadow: 0px 12px 40px rgba(0, 0, 0, 0.2);
        }

        label {
            font-size: 1.2rem;
            margin-bottom: 10px;
            font-weight: 600;
            color: var(--text-dark);
        }

        select, button {
            width: 100%;
            padding: 15px;
            font-size: 1.1rem;
            border-radius: 10px;
            border: 1px solid #ddd;
            margin: 10px 0;
            background-color: var(--accent-color);
            color: white;
            cursor: pointer;
            transition: background-color var(--transition-speed), transform var(--transition-speed);
        }

        select {
            background-color: #fff;
            color: var(--text-dark);
            border: 1px solid #ddd;
        }

        button {
            margin-top: 20px;
        }

        button:hover {
            background-color: var(--button-hover-color);
            transform: scale(1.05);
        }

        /* Image Container */
        .image-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 30px;
            margin-top: 40px;
        }

        .image-container div {
            position: relative;
            transition: transform var(--transition-speed);
        }

        .image-container img {
            width: 320px;
            height: auto;
            border-radius: 20px;
            box-shadow: 0px 8px 40px rgba(0, 0, 0, 0.2);
            transition: transform var(--transition-speed);
        }

        .image-container div:hover img {
            transform: scale(1.08);
        }

        .download-btn {
            position: absolute;
            bottom: 15px;
            left: 50%;
            transform: translateX(-50%);
            background-color: var(--highlight-color);
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color var(--transition-speed), transform var(--transition-speed);
        }

        .download-btn:hover {
            background-color: #e74c3c;
            transform: scale(1.1);
        }

        /* Tips List */
        ul {
            list-style: none;
            padding: 0;
            max-width: 700px;
            margin: 30px auto;
            text-align: left;
            font-size: 1.2rem;
            color: var(--text-dark);
        }

        ul li {
            margin: 15px 0;
            font-weight: 500;
            display: flex;
            align-items: center;
        }

        ul li::before {
            content: "✔️ ";
            margin-right: 12px;
            color: var(--accent-color);
        }

        /* Button for Theme Toggle */
        .theme-toggle-btn {
            background-color: var(--highlight-color);
            color: white;
            padding: 14px 25px;
            font-size: 1.1rem;
            border-radius: 10px;
            margin-top: 30px;
            cursor: pointer;
            transition: background-color var(--transition-speed);
        }

        .theme-toggle-btn:hover {
            background-color: #e74c3c;
        }

        /* Responsive Layout */
        @media (max-width: 768px) {
            body {
                padding: 20px;
            }

            form {
                width: 100%;
                padding: 25px;
            }

            .image-container {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>
</head>
<body>

<h1>Clothing Suggestion for <span>{{ $season }}</span></h1>

<button class="theme-toggle-btn" onclick="toggleTheme()">Toggle Theme</button>

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

@if(isset($imageUrls))
    <div class="image-container">
        @foreach($imageUrls as $img)
            <div>
                <img src="{{ $img }}" alt="Suggested outfit">
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
