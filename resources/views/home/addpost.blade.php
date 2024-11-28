@extends('layouts.residence.basetemplate')
@section('content')

<div class="flex items-center justify-centern">
    <div class="bg-white w-full max-w-xxl rounded-lg shadow-lg">
     <div class="flex items-center mb-4">
      <i class="fas fa-arrow-left text-black text-xl cursor-pointer">
      </i>
     </div>
     <form>
      <div class="relative mb-4">
       <input accept="image/*" class="hidden" id="imageUpload" type="file"/>
       <label class="cursor-pointer relative" for="imageUpload">
        <img alt="Preview of uploaded image" class="w-full h-48 object-cover rounded-lg" height="200" id="imagePreview" src="https://storage.googleapis.com/a1aa/image/2zJUesL3lnSQXKjSrMcSGaKXHEiGkQJgQPWfpOGzDDuZJd1TA.jpg" width="300"/>
        <div class="absolute inset-0 flex flex-col items-center justify-center">
         <i class="fas fa-plus text-white text-4xl mb-2">
         </i>
         <span class="text-white text-lg">
          Upload Foto
         </span>
         <span class="text-white text-sm">
          (Opsional)
         </span>
        </div>
       </label>
       <button class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-1 hidden" id="removeImageButton">
        <i class="fas fa-times">
        </i>
       </button>
      </div>
      <div class="mb-6">
       <label class="block text-gray-500 mb-2">
        Tulis Sesuatu
       </label>
       <textarea class="w-full p-3 border border-gray-300 rounded-lg" id="textInput" placeholder="Tulis Sesuatu..." rows="4">
       </textarea>
       
      </div>
        <button class="w-full bg-green-600 text-white py-3 rounded-lg" type="submit">
        Posting
        </button>       
     </form>
    </div>
    <script>
     const imageUpload = document.getElementById('imageUpload');
     const imagePreview = document.getElementById('imagePreview');
     const removeImageButton = document.getElementById('removeImageButton');
  
     imageUpload.addEventListener('change', function() {
       const file = this.files[0];
       if (file) {
         const reader = new FileReader();
         reader.onload = function(e) {
           imagePreview.src = e.target.result;
           removeImageButton.classList.remove('hidden');
         }
         reader.readAsDataURL(file);
       }
     });
  
     removeImageButton.addEventListener('click', function() {
       imagePreview.src = 'https://placehold.co/300x200?text=Upload+Image';
       imageUpload.value = '';
       removeImageButton.classList.add('hidden');
     });
    </script>
</div>

@endsection 