<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-3xl font-bold text-white">Add New Game</h2>
                <p class="text-gray-400 mt-1">Create a new game for the store</p>
            </div>
            <a href="{{ route('games.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                Back to Games
            </a>
        </div>
    </x-slot>

    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-gray-800/50 backdrop-blur-sm rounded-lg p-6 border border-gray-700">
            <form action="{{ route('admin.games.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <!-- Title -->
                <div class="mb-6">
                    <label for="title" class="block text-gray-300 font-medium mb-2">Game Title</label>
                    <input type="text" 
                           id="title" 
                           name="title" 
                           value="{{ old('title') }}"
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
                              required>{{ old('description') }}</textarea>
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
                           value="{{ old('price') }}"
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
                        <option value="RPG" {{ old('genre') == 'RPG' ? 'selected' : '' }}>RPG</option>
                        <option value="Action" {{ old('genre') == 'Action' ? 'selected' : '' }}>Action</option>
                        <option value="Adventure" {{ old('genre') == 'Adventure' ? 'selected' : '' }}>Adventure</option>
                        <option value="Racing" {{ old('genre') == 'Racing' ? 'selected' : '' }}>Racing</option>
                        <option value="Strategy" {{ old('genre') == 'Strategy' ? 'selected' : '' }}>Strategy</option>
                        <option value="Platformer" {{ old('genre') == 'Platformer' ? 'selected' : '' }}>Platformer</option>
                        <option value="Stealth" {{ old('genre') == 'Stealth' ? 'selected' : '' }}>Stealth</option>
                        <option value="Simulation" {{ old('genre') == 'Simulation' ? 'selected' : '' }}>Simulation</option>
                    </select>
                    @error('genre')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Image -->
                <div class="mb-6">
                    <label for="image" class="block text-gray-300 font-medium mb-2">Game Cover Image</label>
                    
                    <!-- Image Preview -->
                    <div id="imagePreview" class="hidden mb-4 relative">
                        <img id="previewImg" class="w-full h-48 object-cover rounded-lg border border-gray-600" alt="Preview">
                        <button type="button" onclick="clearImagePreview()" class="absolute top-2 right-2 bg-red-600 hover:bg-red-700 text-white rounded-full w-8 h-8 flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <!-- File Input -->
                    <div class="relative">
                        <input type="file" 
                               id="image" 
                               name="image" 
                               accept="image/*"
                               onchange="previewImage(this)"
                               class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-600 file:text-white hover:file:bg-blue-700">
                        
                        <!-- Drag & Drop Zone -->
                        <div id="dropZone" class="hidden mt-4 border-2 border-dashed border-gray-600 rounded-lg p-8 text-center hover:border-blue-500 transition-colors cursor-pointer"
                             onclick="document.getElementById('image').click()">
                            <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                            <p class="text-gray-400">Click to upload or drag and drop</p>
                            <p class="text-gray-500 text-sm mt-1">PNG, JPG, GIF up to 2MB</p>
                        </div>
                    </div>
                    
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
                    
                    // Drag and drop functionality
                    const dropZone = document.getElementById('dropZone');
                    const fileInput = document.getElementById('image');
                    
                    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                        dropZone?.addEventListener(eventName, preventDefaults, false);
                    });
                    
                    function preventDefaults(e) {
                        e.preventDefault();
                        e.stopPropagation();
                    }
                    
                    dropZone?.addEventListener('drop', handleDrop, false);
                    
                    function handleDrop(e) {
                        const dt = e.dataTransfer;
                        const files = dt.files;
                        if (files.length > 0) {
                            fileInput.files = files;
                            previewImage(fileInput);
                        }
                    }
                </script>

                <!-- Submit Button -->
                <div class="flex justify-end space-x-4">
                    <a href="{{ route('games.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                        Cancel
                    </a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                        Create Game
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout> 