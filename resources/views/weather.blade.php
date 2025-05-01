<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Weather-Based Clothing Suggestions</title>
  <link rel="manifest" href="/manifest.json">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <style>
    :root {
      --primary-color: #4A90E2;
      --secondary-color: #F39C12;
      --accent-color: #2ECC71;
      --background-color: #F5F7FA;
      --card-bg: #FFFFFF;
      --text-color: #2C3E50;
      --light-text: #95A5A6;
      --error-color: #E74C3C;
      --success-color: #27AE60;
      --border-radius: 12px;
      --box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      --transition: all 0.3s ease;
    }

    .dark-mode {
      --background-color: #1a1a1a;
      --card-bg: #2d2d2d;
      --text-color: #FFFFFF;
      --light-text: #95A5A6;
      --box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
    }

    body {
      font-family: 'Poppins', sans-serif;
      background-color: var(--background-color);
      color: var(--text-color);
      margin: 0;
      padding: 20px;
      transition: var(--transition);
    }

    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 20px;
      background: var(--card-bg);
      border-radius: var(--border-radius);
      box-shadow: var(--box-shadow);
      margin-bottom: 40px;
    }

    h1 {
      font-size: 2rem;
      color: var(--primary-color);
      margin: 0;
    }

    .auth-buttons {
      display: flex;
      gap: 12px;
    }

    .auth-btn {
      padding: 10px 20px;
      border-radius: var(--border-radius);
      border: none;
      cursor: pointer;
      font-weight: 600;
      transition: var(--transition);
      text-decoration: none;
    }

    .login-btn {
      background-color: var(--primary-color);
      color: white;
    }

    .register-btn {
      background-color: var(--secondary-color);
      color: white;
    }

    .auth-btn:hover {
      transform: translateY(-2px);
      box-shadow: var(--box-shadow);
    }

    .container {
      display: grid;
      grid-template-columns: 1fr 1.5fr;
      gap: 30px;
      max-width: 1400px;
      margin: 0 auto;
    }

    .form-section, .suggestions-section {
      background: var(--card-bg);
      padding: 30px;
      border-radius: var(--border-radius);
      box-shadow: var(--box-shadow);
    }

    .form-group {
      margin-bottom: 24px;
    }

    label {
      display: block;
      font-weight: 500;
      margin-bottom: 8px;
      color: var(--text-color);
    }

    input[type="text"],
    select {
      width: 100%;
      padding: 12px 16px;
      border: 1px solid var(--light-text);
      border-radius: var(--border-radius);
      background: var(--card-bg);
      color: var(--text-color);
      font-size: 1rem;
      transition: var(--transition);
    }

    input[type="text"]:focus,
    select:focus {
      outline: none;
      border-color: var(--primary-color);
      box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.1);
    }

    button {
      width: 100%;
      padding: 14px;
      background-color: var(--primary-color);
      color: white;
      border: none;
      border-radius: var(--border-radius);
      font-weight: 600;
      cursor: pointer;
      transition: var(--transition);
    }

    button:hover {
      background-color: #357ABD;
      transform: translateY(-2px);
    }

    .weather-info {
      margin-top: 30px;
      padding: 20px;
      background: rgba(74, 144, 226, 0.1);
      border-radius: var(--border-radius);
    }

    .weather-info h4 {
      color: var(--primary-color);
      margin-bottom: 15px;
    }

    .weather-info p {
      margin: 10px 0;
      color: var(--text-color);
    }

    .image-container {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
      gap: 25px;
      margin-top: 30px;
    }

    .outfit-card {
      background: var(--card-bg);
      border-radius: var(--border-radius);
      overflow: hidden;
      box-shadow: var(--box-shadow);
      transition: var(--transition);
    }

    .outfit-card:hover {
      transform: translateY(-5px);
    }

    .outfit-image {
      width: 100%;
      height: 300px;
      object-fit: cover;
    }

    .outfit-info {
      padding: 15px;
    }

    .outfit-actions {
      display: flex;
      gap: 10px;
      padding: 15px;
      border-top: 1px solid rgba(0, 0, 0, 0.1);
    }

    .action-btn {
      flex: 1;
      padding: 8px;
      border: none;
      border-radius: var(--border-radius);
      font-size: 0.9rem;
      cursor: pointer;
      transition: var(--transition);
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 5px;
    }

    .heart-button {
      background: none;
      border: none;
      font-size: 1.5rem;
      cursor: pointer;
      color: var(--light-text);
      transition: var(--transition);
      padding: 5px;
      width: auto;
    }

    .heart-button.active {
      color: var(--error-color);
    }

    .heart-button:hover {
      transform: scale(1.1);
      background: none;
    }

    .tips-section {
      margin-top: 30px;
      padding: 20px;
      background: rgba(46, 204, 113, 0.1);
      border-radius: var(--border-radius);
    }

    .tips-section h4 {
      color: var(--accent-color);
      margin-bottom: 15px;
    }

    .tips-list {
      list-style: none;
      padding: 0;
    }

    .tips-list li {
      margin-bottom: 10px;
      padding: 12px;
      background: var(--card-bg);
      border-radius: var(--border-radius);
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .tips-list li::before {
      content: "💡";
    }

    @media (max-width: 768px) {
      .container {
        grid-template-columns: 1fr;
      }
      
      .header {
        flex-direction: column;
        gap: 20px;
        text-align: center;
      }

      .image-container {
        grid-template-columns: 1fr;
      }
    }
  </style>
</head>
<body>

<div class="header">
  <h1>Weather-Based Clothing Suggestions</h1>
  
  <div class="auth-buttons">
    @auth
      <a href="{{ route('home') }}" class="auth-btn login-btn">
        <i class="fas fa-user"></i> My Profile
      </a>
    @else
      <a href="{{ route('login') }}" class="auth-btn login-btn">
        <i class="fas fa-sign-in-alt"></i> Login
      </a>
      <a href="{{ route('register') }}" class="auth-btn register-btn">
        <i class="fas fa-user-plus"></i> Register
      </a>
    @endauth
  </div>

  <label class="theme-toggle">
    <input type="checkbox" id="theme-toggle" onclick="toggleTheme()">
    <span class="slider"></span>
  </label>
</div>

<div class="container">
  <div class="form-section">
    <form method="POST" action="/">
      @csrf
      <div class="form-group">
        <label for="city">
          <i class="fas fa-map-marker-alt"></i> Enter City
        </label>
        <input type="text" name="city" id="city" value="{{ $city }}" placeholder="e.g., New York" required>
      </div>

      <div class="form-group">
        <label for="gender">
          <i class="fas fa-user"></i> Gender
        </label>
        <select name="gender" id="gender">
          <option value="Male" {{ $gender == 'Male' ? 'selected' : '' }}>Male</option>
          <option value="Female" {{ $gender == 'Female' ? 'selected' : '' }}>Female</option>
        </select>
      </div>

      <div class="form-group">
        <label for="occasion">
          <i class="fas fa-calendar-alt"></i> Occasion
        </label>
        <select name="occasion" id="occasion">
          <option value="Casual" {{ $occasion == 'Casual' ? 'selected' : '' }}>Casual</option>
          <option value="Formal" {{ $occasion == 'Formal' ? 'selected' : '' }}>Formal</option>
          <option value="Party" {{ $occasion == 'Party' ? 'selected' : '' }}>Party</option>
        </select>
      </div>

      <button type="submit">
        <i class="fas fa-search"></i> Get Suggestions
      </button>
    </form>

    @if(isset($temperature))
      <div class="weather-info">
        <h4><i class="fas fa-cloud-sun"></i> Current Weather in {{ $city }}</h4>
        <p><i class="fas fa-temperature-high"></i> Temperature: {{ $temperature }}°C</p>
        <p><i class="fas fa-cloud"></i> Weather: {{ $weatherDescription }}</p>
        <p><i class="fas fa-tint"></i> Humidity: {{ $humidity }}%</p>
        <p><i class="fas fa-calendar-day"></i> Suggested Season: {{ $season }}</p>
      </div>
    @endif
  </div>

  <div class="suggestions-section">
    <h3>Suggested Outfits</h3>
    <div class="image-container">
      @if(isset($imageUrls))
        @foreach($imageUrls as $img)
          <div class="outfit-card">
            <img src="{{ $img }}" alt="Suggested outfit" class="outfit-image">
            <div class="outfit-info">
              <p>{{ $suggestedOutfit }}</p>
            </div>
            <div class="outfit-actions">
              <button class="action-btn" onclick="window.open('{{ $img }}', '_blank')">
                <i class="fas fa-download"></i> Download
              </button>
              <button class="action-btn" onclick="shareImage('{{ $img }}')">
                <i class="fas fa-share-alt"></i> Share
              </button>
              <button class="heart-button {{ isset($heartedOutfits) && $heartedOutfits->contains('image_url', $img) ? 'active' : '' }}" 
                      onclick="toggleHeart(this)" 
                      data-outfit="{{ $suggestedOutfit }}" 
                      data-weather="{{ $weather ?? '' }}" 
                      data-temperature="{{ $temperature ?? '' }}"
                      data-image-url="{{ $img }}"
                      @if(isset($heartedOutfits))
                        @foreach($heartedOutfits as $heartedOutfit)
                          @if($heartedOutfit->image_url === $img)
                            data-outfit-id="{{ $heartedOutfit->id }}"
                          @endif
                        @endforeach
                      @endif>
                ♥
              </button>
            </div>
          </div>
        @endforeach
      @endif
    </div>

    @if(isset($tips))
      <div class="tips-section">
        <h4><i class="fas fa-lightbulb"></i> Tips for {{ $season }}</h4>
        <ul class="tips-list">
          @foreach($tips as $tip)
            <li>{{ $tip }}</li>
          @endforeach
        </ul>
      </div>
    @endif
  </div>
</div>

<script>
  function toggleTheme() {
    document.body.classList.toggle('dark-mode');
    localStorage.setItem('theme', document.body.classList.contains('dark-mode') ? 'dark' : 'light');
  }

  // Check for saved theme preference
  if (localStorage.getItem('theme') === 'dark') {
    document.body.classList.add('dark-mode');
    document.getElementById('theme-toggle').checked = true;
  }

  function shareImage(imgUrl) {
    if (navigator.share) {
      navigator.share({
        title: 'Check out this outfit suggestion!',
        text: 'Here\'s an outfit suggestion I found perfect for the weather!',
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

  function toggleHeart(button) {
    const isHearted = button.classList.contains('active');
    const outfitData = {
      outfit_description: button.dataset.outfit,
      weather_condition: button.dataset.weather,
      temperature: button.dataset.temperature,
      image_url: button.dataset.imageUrl,
      _token: document.querySelector('meta[name="csrf-token"]').content
    };

    if (isHearted && button.dataset.outfitId) {
      outfitData.outfit_id = button.dataset.outfitId;
    }

    fetch(isHearted ? '/unheart-outfit' : '/heart-outfit', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
      },
      body: JSON.stringify(outfitData)
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        button.classList.toggle('active');
        if (!isHearted && data.outfit) {
          button.dataset.outfitId = data.outfit.id;
        }
        const message = isHearted ? 'Outfit removed from favorites' : 'Outfit saved to favorites!';
        showNotification(message, data.success);
      } else {
        showNotification(data.message || 'Failed to update outfit preference', false);
      }
    })
    .catch(error => {
      console.error('Error:', error);
      showNotification('Failed to update outfit preference', false);
    });
  }

  function showNotification(message, isSuccess) {
    const notification = document.createElement('div');
    notification.className = `notification ${isSuccess ? 'success' : 'error'}`;
    notification.style.cssText = `
      position: fixed;
      bottom: 20px;
      right: 20px;
      padding: 15px 25px;
      background: ${isSuccess ? 'var(--success-color)' : 'var(--error-color)'};
      color: white;
      border-radius: var(--border-radius);
      box-shadow: var(--box-shadow);
      animation: slideIn 0.3s ease-out;
      z-index: 1000;
    `;
    notification.textContent = message;
    document.body.appendChild(notification);

    setTimeout(() => {
      notification.style.animation = 'slideOut 0.3s ease-out';
      setTimeout(() => notification.remove(), 300);
    }, 3000);
  }

  // Add CSS animations
  const style = document.createElement('style');
  style.textContent = `
    @keyframes slideIn {
      from { transform: translateX(100%); opacity: 0; }
      to { transform: translateX(0); opacity: 1; }
    }
    @keyframes slideOut {
      from { transform: translateX(0); opacity: 1; }
      to { transform: translateX(100%); opacity: 0; }
    }
  `;
  document.head.appendChild(style);
</script>

</body>
</html>
