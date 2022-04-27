<div class="mt-5 mb-5 p-2 border border-black">
    <h1 class="text-xl font-bold mb-2">{{ __('Upload images') }}</h1>

    <div>
        <form action="/api/image" method="post" enctype="multipart/form-data" id="image_upload_form">
            @csrf
            <input type="file" name="image" id="image">
            <button class="m-1 pl-3 pr-3 rounded bg-blue-200 border border-black hover:shadow-2xl hover:bg-blue-500">{{ __("Upload") }}</button>
        </form>
    </div>

    <div class="mt-4">
        <label for="image_url">{{ __("Image url") }}: </label>
        <input type="text" id="image_url" value="" class="p-1 border border-black overflow-auto w-3/5" disabled>
    </div>
    <span id="upload_error" class="border border-red-600 text-red-600 mt-3 p-3 inline-block hidden"></span>
</div>

<script>
let form = document.getElementById("image_upload_form");
let formData = null;
let actionPath = "";

let imageUrl = document.getElementById("image_url");
let uploadError = document.getElementById("upload_error");

var xhr = new XMLHttpRequest();


form.addEventListener("submit", function(e){
    e.preventDefault();
    
    if(!uploadError.classList.contains('hidden')){
        uploadError.classList.add('hidden');
    }

    formData = new FormData(form);
    actionPath = form.getAttribute("action");

    xhr.open("POST", actionPath, true);
    xhr.setRequestHeader("X-CSRF-TOKEN", formData.get("_token"));

    {{-- FOR SOME REASIN SETTING CONTENT TYPE TO MULTIPART/FORM-DATA DOESN'T WORK --}}
    {{-- xhr.setRequestHeader("Content-type", "multipart/form-data"); --}}

    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

    xhr.onreadystatechange = function(){
        if(xhr.readyState == 4){
            let response = JSON.parse(xhr.responseText);

            if(xhr.status == 200){
                imageUrl.value = response.url;
            }
            else if(xhr.status == 400){

                uploadError.classList.remove('hidden');
                uploadError.innerHTML = response.errorMessage;
            }
            else if(xhr.status == 409){
                imageUrl.value = response.url;

                uploadError.classList.remove('hidden');
                uploadError.innerHTML = response.errorMessage;
            }
        }
      
    }

    xhr.send(formData);
})
</script>
