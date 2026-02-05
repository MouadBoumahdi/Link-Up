<!-- Create Post Component -->
<div class="bg-white rounded-xl shadow-md border overflow-hidden mb-6">
    <div class="p-4">
        <div class="flex items-center">
            <div class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center text-white font-bold mr-3">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div class="flex-1">
                <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
                    @csrf
                    
                    <!-- Text Area -->
                    <textarea 
                        name="content" 
                        rows="3" 
                        placeholder="What's on your mind?"
                        class="w-full px-4 py-3 bg-gray-50 border rounded-lg focus:outline-none focus:border-blue-500 resize-none"
                        required
                    ></textarea>
                    
                    <!-- Image Upload Preview -->
                    <div id="image-preview" class="mt-3 hidden">
                        <img id="preview-image" class="max-h-64 rounded-lg" src="" alt="Preview">
                        <button type="button" onclick="removeImage()" class="mt-2 text-red-600 text-sm">
                            <i class="fas fa-times mr-1"></i> Remove image
                        </button>
                    </div>
                    
                    <!-- Image Upload -->
                    <div class="flex items-center justify-between mt-3">
                        <div class="flex items-center space-x-4">
                            <!-- Image Upload Button -->
                            <label for="image-upload" class="cursor-pointer text-gray-600 hover:text-gray-800">
                                <i class="fas fa-image text-lg"></i>
                                <span class="ml-2">Photo</span>
                                <input type="file" 
                                       id="image-upload" 
                                       name="image" 
                                       accept="image/*" 
                                       class="hidden" 
                                       onchange="previewImage(event)">
                            </label>
                        </div>
                        
                        <!-- Submit Button -->
                        <button type="submit" class="bg-black hover:bg-gray-800 text-white font-medium py-2 px-6 rounded-lg">
                            Post
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function previewImage(event) {
    const input = event.target;
    const preview = document.getElementById('preview-image');
    const previewContainer = document.getElementById('image-preview');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.src = e.target.result;
            previewContainer.classList.remove('hidden');
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}

function removeImage() {
    document.getElementById('image-upload').value = '';
    document.getElementById('image-preview').classList.add('hidden');
    document.getElementById('preview-image').src = '';
}
</script>