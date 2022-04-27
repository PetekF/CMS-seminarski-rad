@extends("cms.layouts.layout")

@section("title", __('Pages'))

@section("main")

<h1 class="font-bold text-3xl mr-2 text-center mb-10">
    <span class="border-b-4 border-blue-900">{{ __($page_form_heading) }}</span>
</h1>

@include('cms.errors.page_errors', ['errors' => $errors])

@include('cms.includes.image_upload')

<form action="{{ $form_action }}" method="post">
    <div class="flex-column md:flex gap-4">
        <div class="md:w-4/5 bg-gray-300">
        {{-- CKEDITOR---------------------------------------------------------------- --}}
            <textarea name="body" id="body" rows="10" cols="80"></textarea>
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
                    value="{{ $page->is_published ?? 1 }}"
                    class="border border-black m-2 h-10 p-3 rounded shadow-inner">
                    <label for="publish">{{ __('Publish') }}</label>
                </div>
        
        
                <div class="flex items-center justify-around">
                    <button type="submit" 
                    class="p-2 mt-10 w-full rounded bg-green-200 border border-black 
                    hover:shadow-2xl hover:bg-green-500 flex items-center justify-center
                    ">{{ __('Save') }}</button>
                </div>
                
        
        </div>
    </div>
</form>
@endsection