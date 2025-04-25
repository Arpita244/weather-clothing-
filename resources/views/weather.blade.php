<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Seasonal Clothing Suggestion</title>
  <link rel="manifest" href="/manifest.json">
  <style>
    :root {
      --bg-light: #f7f7f7;
      --bg-dark: #121212;
      --text-light: #f5f5f5;
      --text-dark: #2f2f2f;
      --accent-color: #3498db;
      --highlight-color: #f39c12;
      --button-hover-color: #2980b9;
      --card-shadow: rgba(0, 0, 0, 0.1);
      --transition-speed: 0.3s;
      --font-family: 'Segoe UI', sans-serif;
    }

    .dark-mode {
      --bg-light: #1c1c1c;
      --text-light: #e6e6e6;
      --accent-color: #1abc9c;
      --highlight-color: #ff6347;
      --button-hover-color: #16a085;
    }

    body {
      font-family: var(--font-family);
      background-color: var(--bg-light);
      color: var(--text-dark);
      padding: 40px 20px;
      margin: 0;
      transition: all var(--transition-speed) ease-in-out;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    h1, h3 {
      font-size: 2.3rem;
      text-align: center;
      margin-bottom: 25px;
      color: var(--accent-color);
    }

    form {
      width: 100%;
      max-width: 600px;
      background: #fff;
      padding: 30px;
      border-radius: 16px;
      box-shadow: 0 4px 25px var(--card-shadow);
      margin-bottom: 40px;
    }

    form div {
      margin-bottom: 20px;
    }

    label {
      font-weight: 600;
      margin-bottom: 8px;
      display: block;
      color: var(--text-dark);
    }

    select, button {
      width: 100%;
      padding: 12px 16px;
      font-size: 1rem;
      border-radius: 10px;
      border: 1px solid #ccc;
      transition: all var(--transition-speed);
    }

    select {
      background-color: #fff;
      color: var(--text-dark);
    }

    button {
      margin-top: 20px;
      background-color: var(--accent-color);
      color: white;
      border: none;
      font-weight: 600;
      cursor: pointer;
    }

    button:hover {
      background-color: var(--button-hover-color);
      transform: scale(1.05);
    }

    .theme-toggle-btn {
      background-color: var(--highlight-color);
      padding: 12px 24px;
      font-size: 1rem;
      border-radius: 10px;
      cursor: pointer;
      border: none;
      color: white;
      margin-bottom: 40px;
      transition: background-color var(--transition-speed);
    }

    .theme-toggle-btn:hover {
      background-color: #e74c3c;
    }

    .image-container {
      display: flex;
      flex-wrap: wrap;
      gap: 25px;
      justify-content: center;
      margin-bottom: 30px;
    }

    .image-container div {
      background-color: white;
      border-radius: 16px;
      overflow: hidden;
      box-shadow: 0px 10px 25px rgba(0,0,0,0.15);
      transition: transform var(--transition-speed);
      max-width: 320px;
      position: relative;
      padding-bottom: 10px;
    }

    .image-container div:hover {
      transform: translateY(-5px);
    }

    .image-container img {
      width: 100%;
      height: auto;
      display: block;
    }

    .download-btn, .share-btn {
      display: block;
      width: 80%;
      margin: 10px auto 0;
      padding: 10px;
      text-align: center;
      border: none;
      border-radius: 8px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease-in-out;
    }

    .download-btn {
      background-color: var(--highlight-color);
      color: white;
    }

    .download-btn:hover {
      background-color: #e74c3c;
    }

    .share-btn {
      background: linear-gradient(to right, #00c6ff, #0072ff);
      color: white;
      margin-top: 8px;
    }

    .share-btn:hover {
      box-shadow: 0 0 10px #00c6ff;
    }

    ul {
      max-width: 700px;
      padding-left: 0;
      list-style: none;
    }

    ul li {
      background: #fff;
      margin: 10px 0;
      padding: 12px 20px;
      border-radius: 12px;
      box-shadow: 0 3px 10px rgba(0,0,0,0.1);
      display: flex;
      align-items: center;
      font-weight: 500;
    }

    ul li::before {
      content: '✔️';
      margin-right: 10px;
      color: var(--accent-color);
    }

    @media (max-width: 768px) {
      form {
        padding: 20px;
      }

      h1 {
        font-size: 2rem;
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
        <button class="share-btn" onclick="shareImage('{{ $img }}')">📤 Share</button>
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

  function shareImage(imgUrl) {
    if (navigator.share) {
      navigator.share({
        title: 'Check out this outfit suggestion!',
        text: 'Here’s an outfit suggestion I found perfect for the season!',
        url: imgUrl
      }).then(() => {
        console.log('Shared successfully');
      }).catch((err) => {
        console.error('Share failed:', err);
      });
    } else {
      alert('Sorry, your browser does not support the Share feature.');
    }
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
