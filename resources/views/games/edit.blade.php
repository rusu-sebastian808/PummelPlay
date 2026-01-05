<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-3xl font-bold text-white">Edit Game</h2>
                <p class="text-gray-400 mt-1">Update {{ $game->title }}</p>
            </div>
            <a href="{{ route('games.show', $game) }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                View Game
            </a>
        </div>
    </x-slot>

    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-gray-800/50 backdrop-blur-sm rounded-lg p-6 border border-gray-700">
            <form action="{{ route('admin.games.update', $game) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                
                <!-- Title -->
                <div class="mb-6">
                    <label for="title" class="block text-gray-300 font-medium mb-2">Game Title</label>
                    <input type="text" 
                           id="title" 
                           name="title" 
                           value="{{ old('title', $game->title) }}"
                           class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Enter game title"
                           required>
                    @error('title')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="mb-6">
                    <label for="description" class="block text-gray-300 font-medium mb-2">Description</label>
                    <textarea id="description" 
                              name="description" 
                              rows="4"
                              class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                              placeholder="Enter game description"
                              required>{{ old('description', $game->description) }}</textarea>
                    @error('description')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Price -->
                <div class="mb-6">
                    <label for="price" class="block text-gray-300 font-medium mb-2">Price ($)</label>
                    <input type="number" 
                           id="price" 
                           name="price" 
                           value="{{ old('price', $game->price) }}"
                           step="0.01"
                           min="0"
                           class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="0.00"
                           required>
                    @error('price')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Genre -->
                <div class="mb-6">
                    <label for="genre" class="block text-gray-300 font-medium mb-2">Genre</label>
                    <select id="genre" 
                            name="genre" 
                            class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            required>
                        <option value="">Select a genre</option>
                        <option value="RPG" {{ old('genre', $game->genre) == 'RPG' ? 'selected' : '' }}>RPG</option>
                        <option value="Action" {{ old('genre', $game->genre) == 'Action' ? 'selected' : '' }}>Action</option>
                        <option value="Adventure" {{ old('genre', $game->genre) == 'Adventure' ? 'selected' : '' }}>Adventure</option>
                        <option value="Racing" {{ old('genre', $game->genre) == 'Racing' ? 'selected' : '' }}>Racing</option>
                        <option value="Strategy" {{ old('genre', $game->genre) == 'Strategy' ? 'selected' : '' }}>Strategy</option>
                        <option value="Platformer" {{ old('genre', $game->genre) == 'Platformer' ? 'selected' : '' }}>Platformer</option>
                        <option value="Stealth" {{ old('genre', $game->genre) == 'Stealth' ? 'selected' : '' }}>Stealth</option>
                        <option value="Simulation" {{ old('genre', $game->genre) == 'Simulation' ? 'selected' : '' }}>Simulation</option>
                    </select>
                    @error('genre')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Current Image -->
                @if($game->image)
                    <div class="mb-6">
                        <label class="block text-gray-300 font-medium mb-2">Current Game Cover</label>
                        <div class="w-full max-w-sm bg-gray-700 rounded-lg overflow-hidden border border-gray-600">
                            <img src="{{ asset('storage/' . $game->image) }}" 
                                 alt="{{ $game->title }}" 
                                 class="w-full h-48 object-cover">
                        </div>
                        <p class="text-gray-400 text-sm mt-2">Current cover image will be replaced if you upload a new one</p>
                    </div>
                @endif

                <!-- New Image -->
                <div class="mb-6">
                    <label for="image" class="block text-gray-300 font-medium mb-2">
                        {{ $game->image ? 'Replace Game Cover' : 'Game Cover Image' }}
                    </label>
                    
                    <!-- Image Preview for new image -->
                    <div id="imagePreview" class="hidden mb-4 relative">
                        <img id="previewImg" class="w-full h-48 object-cover rounded-lg border border-gray-600" alt="New Preview">
                        <button type="button" onclick="clearImagePreview()" class="absolute top-2 right-2 bg-red-600 hover:bg-red-700 text-white rounded-full w-8 h-8 flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                        <p class="text-green-400 text-sm mt-2">✅ New image ready to upload</p>
                    </div>
                    
                    <input type="file" 
                           id="image" 
                           name="image" 
                           accept="image/*"
                           onchange="previewImage(this)"
                           class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-600 file:text-white hover:file:bg-blue-700">
                    
                    <div class="text-gray-400 text-sm mt-2 space-y-1">
                        <p>📸 <strong>Recommended:</strong> High-quality game cover art (1:1 aspect ratio preferred)</p>
                        <p>💡 <strong>Tip:</strong> Use official game artwork or screenshots for best results</p>
                        <p>⚡ <strong>Formats:</strong> JPEG, PNG, JPG, GIF (max 2MB)</p>
                    </div>
                    
                    @error('image')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- JavaScript for Image Preview -->
                <script>
                    function previewImage(input) {
                        if (input.files && input.files[0]) {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                document.getElementById('previewImg').src = e.target.result;
                                document.getElementById('imagePreview').classList.remove('hidden');
                            }
                            reader.readAsDataURL(input.files[0]);
                        }
                    }
                    
                    function clearImagePreview() {
                        document.getElementById('image').value = '';
                        document.getElementById('imagePreview').classList.add('hidden');
                    }
                </script>

                <!-- Submit Button -->
                <div class="flex justify-end space-x-4">
                    <a href="{{ route('games.show', $game) }}" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                        Cancel
                    </a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                        Update Game
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout> 