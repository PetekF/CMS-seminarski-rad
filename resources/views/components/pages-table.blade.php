<div class="rounded-lg">

    @if (session('success'))
        <div id="status_bar" class="bg-green-500 border border-green-800">
            {{ session('success')}}
        </div> 
    @endif

    @include('cms.errors.user_table_errors', ['errors' => $errors])
    
    <div class="overflow-x-auto">
        <table class="bg-gray-200 rounded-lg w-full">
            <thead >
                @foreach ($headers as $header)
                    <th class="p-3 text-left text-gray-200 border bg-zinc-800">{{ $header }}</th>
                @endforeach
            </thead>
            <tbody>
                @foreach ($items as $page)
                    <tr class="even:bg-gray-100">
                        <td class="p-3">{{$page->title}}</td>
                        <td class="p-3">{{$page->slug}}</td>
                        <td class="p-3">{{$page->author === null ? __("Undefined") : $page->author->username}}</td>
                        <td class="p-3 w-0">{{$page->is_published}}</td>
                        <td class="p-3 w-0">
                            {{-- <span class="text-blue-600 font-bold hover:border-b hover:border-blue-600 hover:cursor-pointer mr-1">
                                {{ __("Edit") }}
                            </span> --}}

                            <form action="{{ route('edit_page', ['id' => $page->id]) }}" method="get">
                                @csrf
                                <button class="text-blue-600 font-bold hover:border-b hover:border-blue-600 hover:cursor-pointer"
                                 type="submit">
                                    {{ __("Edit") }}
                                </button>
                            </form>

                            <form action="{{ route('update_page', ['id' => $page->id, 'publish_action' => '1']) .'&'. $queryString }}" method="post">
                                @csrf
                                @method('PATCH')
                                @if ($page->is_published === 0)
                                    <input type="hidden" name="is_published" value="1">
                                    <button class="text-yellow-500 font-bold hover:border-b hover:border-yellow-500 hover:cursor-pointer box-content"
                                    type="submit">
                                        {{ __("Publish") }}
                                    </button>
                                @elseif($page->is_published === 1)
                                    <input type="hidden" name="is_published" value="0">
                                    <button class="text-orange-500 font-bold hover:border-b hover:border-orange-500 hover:cursor-pointer box-content"
                                    type="submit">
                                        {{ __("Unpublish") }}
                                    </button>
                                @endif
                                
                            </form>

                            <form action="{{ route('delete_page', ['id' => $page->id]) .'?'. $queryString }}" method="post" onsubmit="return confirm('{{ __('Do you want to delete page') }}');">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600 font-bold hover:border-b hover:border-red-600 hover:cursor-pointer box-content"
                                 type="submit">
                                    {{ __("Delete") }}
                                 </button>
                            </form>

                            
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
  

</div>