@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Home') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h3>Your Favorite Outfits</h3>
                    
                    @if($heartedOutfits->count() > 0)
                        <div class="outfit-grid">
                            @foreach($heartedOutfits as $outfit)
                                <div class="outfit-card">
                                    <div class="outfit-content">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <div class="outfit-info">
                                                <h5 class="mb-1">{{ $outfit->outfit_description }}</h5>
                                                <small class="text-muted">
                                                    Weather: {{ $outfit->weather_condition }}, 
                                                    Temperature: {{ $outfit->temperature }}
                                                </small>
                                            </div>
                                            <button class="heart-button active" 
                                                    onclick="toggleHeart(this)" 
                                                    data-outfit-id="{{ $outfit->id }}">
                                                ♥
                                            </button>
                                        </div>
                                        <div class="outfit-image-container">
                                            <img src="{{ $outfit->image_url }}" alt="Saved outfit" class="img-fluid rounded">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p>You haven't saved any favorite outfits yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.outfit-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 20px;
    padding: 20px;
}

.outfit-card {
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
    overflow: hidden;
}

.outfit-card:hover {
    transform: translateY(-5px);
}

.outfit-content {
    padding: 15px;
}

.outfit-info {
    flex: 1;
    padding-right: 10px;
}

.outfit-info h5 {
    font-size: 1rem;
    margin-bottom: 5px;
}

.heart-button {
    background: none;
    border: none;
    font-size: 1.5rem;
    cursor: pointer;
    color: #ff4444;
    transition: color 0.3s ease;
    padding: 5px;
}

.heart-button:hover {
    opacity: 0.8;
}

.outfit-image-container {
    margin-top: 10px;
    width: 100%;
    position: relative;
    padding-top: 100%; /* 1:1 Aspect Ratio */
    overflow: hidden;
}

.outfit-image-container img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 8px;
}

@media (max-width: 768px) {
    .outfit-grid {
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 15px;
        padding: 15px;
    }
}
</style>

<script>
function toggleHeart(button) {
    const outfitId = button.dataset.outfitId;
    
    fetch('/unheart-outfit', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            outfit_id: outfitId,
            _token: document.querySelector('meta[name="csrf-token"]').content
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Remove the outfit card from the grid
            button.closest('.outfit-card').remove();
            
            // Check if there are no more outfits
            if (document.querySelectorAll('.outfit-card').length === 0) {
                document.querySelector('.outfit-grid').innerHTML = 
                    '<p>You haven\'t saved any favorite outfits yet.</p>';
            }
        } else {
            alert('Failed to remove outfit from favorites');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Failed to remove outfit from favorites');
    });
}
</script>
@endsection
