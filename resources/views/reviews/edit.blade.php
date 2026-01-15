<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-3xl font-bold text-white">Edit Review</h2>
                <p class="text-gray-400 mt-1">Update your review for {{ $review->game->title }}</p>
            </div>
            <a href="{{ route('games.show', $review->game) }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                ← Back to Game
            </a>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-gray-800/50 backdrop-blur-sm rounded-lg p-6 border border-gray-700">
      
            <div class="flex items-center space-x-4 mb-6 p-4 bg-gray-700/50 rounded-lg">
  
                <div class="w-16 h-16 bg-gray-600 rounded-lg overflow-hidden flex-shrink-0">
                    @if($review->game->image)
                        <img src="{{ asset('storage/' . $review->game->image) }}" 
                             alt="{{ $review->game->title }}" 
                             class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-600 to-gray-700">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h.01M19 10a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    @endif
                </div>
                
  
                <div>
                    <h3 class="text-xl font-bold text-white">{{ $review->game->title }}</h3>
                    <p class="text-gray-400 text-sm">{{ $review->game->genre }} • ${{ number_format($review->game->price, 2) }}</p>
                    <p class="text-gray-300 text-sm mt-1">{{ Str::limit($review->game->description, 80) }}</p>
                </div>
            </div>

   
            <form method="POST" action="{{ route('reviews.update', $review) }}" class="space-y-6">
                @csrf
                @method('PATCH')

        
                <div>
                    <label for="rating" class="block text-gray-300 font-medium mb-3">Rating</label>
                    <div class="flex items-center space-x-2">
                        <div class="flex space-x-1" id="star-rating">
                            @for($i = 1; $i <= 5; $i++)
                                <button type="button" 
                                        class="star-btn text-3xl {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-500' }} hover:text-yellow-400 transition-colors focus:outline-none"
                                        data-rating="{{ $i }}"
                                        onclick="setRating({{ $i }})">
                                    ★
                                </button>
                            @endfor
                        </div>
                        <span class="text-gray-400 text-sm ml-4" id="rating-text">
                            {{ $review->rating }} out of 5 stars
                        </span>
                    </div>
                    <input type="hidden" name="rating" id="rating-input" value="{{ $review->rating }}" required>
                    @error('rating')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="review" class="block text-gray-300 font-medium mb-2">Your Review</label>
                    <textarea 
                        id="review" 
                        name="review" 
                        rows="6" 
                        placeholder="Share your thoughts about this game..."
                        class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none"
                        required>{{ old('review', $review->review) }}</textarea>
                    
                    <div class="flex justify-between items-center mt-2">
                        <span class="text-gray-400 text-sm">Share your honest opinion to help other gamers</span>
                        <span class="text-gray-400 text-sm" id="char-count">
                            <span id="current-chars">{{ strlen($review->review) }}</span>/1000 characters
                        </span>
                    </div>
                    
                    @error('review')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="bg-blue-600/10 border border-blue-600/30 rounded-lg p-4">
                    <h4 class="text-blue-400 font-medium mb-2">Review Guidelines</h4>
                    <ul class="text-blue-200 text-sm space-y-1">
                        <li>• Be honest and constructive in your feedback</li>
                        <li>• Focus on gameplay, graphics, story, and overall experience</li>
                        <li>• Avoid spoilers - keep story details vague</li>
                        <li>• Respect other players and developers</li>
                    </ul>
                </div>

                <div class="flex flex-col sm:flex-row gap-4 pt-4">
                    <button type="submit" 
                            class="flex-1 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-200 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Update Review
                    </button>
                    
                    <a href="{{ route('games.show', $review->game) }}" 
                       class="flex-1 bg-gray-600 hover:bg-gray-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors text-center">
                        Cancel
                    </a>
                </div>
            </form>

            <div class="mt-8 pt-6 border-t border-gray-700">
                <div class="bg-red-600/10 border border-red-600/30 rounded-lg p-4">
                    <h4 class="text-red-400 font-medium mb-2">Delete Review</h4>
                    <p class="text-red-200 text-sm mb-4">
                        This action cannot be undone. Your review will be permanently removed.
                    </p>
                    <form method="POST" action="{{ route('reviews.destroy', $review) }}" 
                          onsubmit="return confirm('Are you sure you want to delete this review? This action cannot be undone.')" 
                          class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                            Delete Review
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function setRating(rating) {
     
            document.getElementById('rating-input').value = rating;
            
    
            const stars = document.querySelectorAll('.star-btn');
            stars.forEach((star, index) => {
                if (index < rating) {
                    star.classList.remove('text-gray-500');
                    star.classList.add('text-yellow-400');
                } else {
                    star.classList.remove('text-yellow-400');
                    star.classList.add('text-gray-500');
                }
            });
            
   
            const ratingTexts = ['', 'Poor', 'Fair', 'Good', 'Very Good', 'Excellent'];
            document.getElementById('rating-text').textContent = `${rating} out of 5 stars - ${ratingTexts[rating]}`;
        }


        document.getElementById('review').addEventListener('input', function(e) {
            const currentLength = e.target.value.length;
            document.getElementById('current-chars').textContent = currentLength;
            

            const charCount = document.getElementById('char-count');
            if (currentLength > 900) {
                charCount.classList.add('text-red-400');
                charCount.classList.remove('text-gray-400');
            } else if (currentLength > 800) {
                charCount.classList.add('text-yellow-400');
                charCount.classList.remove('text-gray-400', 'text-red-400');
            } else {
                charCount.classList.add('text-gray-400');
                charCount.classList.remove('text-yellow-400', 'text-red-400');
            }
        });

 
        document.querySelectorAll('.star-btn').forEach((star, index) => {
            star.addEventListener('mouseenter', function() {
                const rating = index + 1;
                const stars = document.querySelectorAll('.star-btn');
                stars.forEach((s, i) => {
                    if (i < rating) {
                        s.classList.add('text-yellow-300');
                    } else {
                        s.classList.remove('text-yellow-300');
                    }
                });
            });
            
            star.addEventListener('mouseleave', function() {
                document.querySelectorAll('.star-btn').forEach(s => {
                    s.classList.remove('text-yellow-300');
                });
            });
        });
    </script>
</x-app-layout> 
