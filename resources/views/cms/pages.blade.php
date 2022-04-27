@extends("cms.layouts.layout")

@section("title", __('Pages'))

@section("main")
<div>
    <h1 class="font-bold text-3xl mr-2 inline-block">
        {{ __('Pages') }}
    </h1>
    <form action="{{ route('new_page') }}" method="get" class="inline-block">
        @csrf
        <button type="submit" class="p-2 rounded bg-green-200 border border-black hover:shadow-2xl hover:bg-green-500">
            + {{ __("Add") }}
        </button>
    </form>

    {{-- TODO!: FILL OUT THE FORM WITH LAST VALUES --}}
    <div class="mt-6">
        <fieldset class="border border-solid border-black p-3">
            <legend class="text-sm">Filter</legend>
            <form action="{{ route('pages') }}" method="GET">
                <label for="perPage">Prikaži: </label>
                <select class="m-1 bg-white" name="per_page" id="per_page">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="15">15</option>
                </select>
                <input class="m-1" type="text" name="title" placeholder="{{ __('Title') }}">
                <input class="m-1" type="text" name="author" placeholder="{{ __('Author') }}">
                <button type="submit" class="m-1 pl-3 pr-3 rounded bg-blue-200 border border-black hover:shadow-2xl hover:bg-blue-500">
                    {{ __('Search') }}
                </button>
            </form>
        </fieldset>
    </div>

    <form action="{{ route('root_page') . '?' . $query_string }}" method="post" class="mt-5">
        @csrf
        @method('PATCH')
        <label for="root-page">{{__('Root page')}}: </label>
        <select name="root-page-id" id="root-page" class="m-1 bg-white">
            {{-- @foreach ($pages as $page)
                <option value="{{ $page->id }}"
                @if ($page->is_root_page === 1)
                    selected
                @endif
                >{{ $page->title }}</option>
            @endforeach --}}
            @foreach (\App\Models\Page::all() as $p)
                <option value="{{ $p->id }}"
                @if ($p->is_root_page === 1)
                    selected
                @endif
                >{{ $p->title }}</option>
            @endforeach
        </select>
        <button type="submit" class="m-1 pl-3 pr-3 rounded bg-blue-200 border border-black hover:shadow-2xl hover:bg-blue-500">
            {{ __('Change') }}
        </button>
    </form>

    <div class="mt-5">
        <x-pages-table table="pages" :items="$pages" :queryString="$query_string"/>
    </div>

    <div class="mt-4 flex flex-wrap justify-center">
        @foreach ($page_links as $page_link)
            <a href="{{ $page_link['url'] }}" 
            class="p-2 m-2 border border-black bg-blue-200 hover:bg-blue-500 text-center
            @if($page_link['active'])
                {{ "bg-green-300" }}  {{-- Previously was bg-green-200 but it suddenly stopped working --}}
            @endif
            ">{!!$page_link['label']!!}</a>
        @endforeach
    </div>
    
</div>

<script>
    let perPageSelect = document.getElementById('per_page') ?? null;
    let params = new URLSearchParams(window.location.search);
    let perPage = null;

    if (params.has('per_page')) {
        perPage = params.get('per_page');

        for(let i = 0; i < perPageSelect.options.length; i++){
            if(perPageSelect.options[i].value == perPage){
                perPageSelect.options[i].setAttribute("selected", "true");
            }
        }
    }
</script>
@endsection
