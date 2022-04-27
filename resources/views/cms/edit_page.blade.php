@extends("cms.layouts.layout")

@section("title", __('Pages'))

@section("main")

<h1 class="font-bold text-3xl mr-2 text-center mb-10">
    <span class="border-b-4 border-blue-900">{{ __($page_form_heading) }}</span>
</h1>

@include('cms.errors.page_errors', ['errors' => $errors])

@include('cms.includes.image_upload')

<form action="{{ $form_action }}" method="post" enctype="multipart/form-data">
    <div class="flex-column md:flex gap-4">
        <div class="md:w-4/5 bg-gray-300">
        {{-- CKEDITOR---------------------------------------------------------------- --}}
            <textarea name="body" id="body">{{$page->body}}</textarea>
            <script>
                    // Replace the <textarea id="editor1"> with a CKEditor 4
                    // instance, using default configuration.
                    CKEDITOR.replace( 'body' );
                    CKEDITOR.stylesSet.add('mystyle', [
                    {

                    }
                ]);
            </script>
        {{-- ----------------------------------------------------------------CKEDITOR --}}

        </div>

        <div class="mt-14 md:mt-0 md:border-l md:border-black md:pl-4">
                @csrf
                @method('PATCH')
                <div class="flex items-center justify-between"">
                    <label for="author">{{ __('Author') }}: </label>
                    <input type="text" id="author"
                    value="{{ $page->author->username }}" disabled
                    class="border border-black m-2 h-10 p-3 rounded shadow-inner">
                </div>
                <div class="flex items-center justify-between">
                    <label for="title">{{ __('Title') }}: </label>
                    <input type="text" id="title" name="title" 
                    value="{{ $page->title ?? '' }}"
                    class="border border-black m-2 h-10 p-3 rounded shadow-inner">
                </div>
                <div class="flex items-center justify-between">
                    <label for="slug">{{ __('Slug') }}: </label>
                    <input type="text" id="slug" name="slug"
                    value="{{ $page->slug ?? '' }}"
                    class="border border-black m-2 h-10 p-3 rounded shadow-inner">
                </div>
                <div class="flex items-center justify-left">
                    <input type="checkbox" id="publish" name="is_published"
                    value="1"
                    @if ($page->is_published)
                        checked
                    @endif
                    class="border border-black m-2 h-10 p-3 rounded shadow-inner">
                    <label for="publish">{{ __('Publish') }}</label>
                </div>
        
        
                <div class="flex items-center justify-around">
                    <button type="submit" 
                    class="p-2 mt-10 w-full rounded bg-green-200 border border-black 
                    hover:shadow-2xl hover:bg-green-500 flex items-center justify-center
                    ">{{ __('Save') }}</button>
                </div>
             
                <div class="flex items-center justify-around">
                    <span id="delete_page_button" 
                    class="p-2 mt-5 w-full rounded bg-red-200 border border-black 
                    hover:shadow-2xl hover:bg-red-500 flex items-center justify-center select-none
                    ">{{ __('Delete') }}</span>
                </div>
        </div>
    </div>
</form>

<form id="delete_page_form" class="hidden" action="{{ route('delete_page', ['id' => $page->id]) }}"
 method="post" onsubmit="return confirm('{{ __('Do you want to delete page') }}');">
@csrf
@method('DELETE')
</form>

<script>
let deletePageForm = document.getElementById('delete_page_form');
let deletePageButton = document.getElementById('delete_page_button');

deletePageButton.addEventListener("click", function(){
    if(!confirm('{{ __('Do you want to delete page') }}')) {
        return false;
    }
    deletePageForm.submit();
})

</script>
@endsection