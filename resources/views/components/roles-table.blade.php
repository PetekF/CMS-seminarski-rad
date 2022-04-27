<div class="rounded-lg">

    @if (session('success'))
        <div id="status_bar" class="bg-green-500 border border-green-800">
            {{ session('success')}}
        </div> 
    @endif

    @include('cms.errors.role_table_errors', ['errors' => $errors])
    
    <div class="overflow-x-auto">
        <table class="bg-gray-200 rounded-lg w-full">
            <thead >
                @foreach ($headers as $header)
                    <th class="p-3 text-left text-gray-200 border bg-zinc-800">{{ $header }}</th>
                @endforeach
            </thead>
            <tbody>
                @foreach ($items as $role)
                    <tr class="even:bg-gray-100">
                        <td class="p-3">{{$role->name}}</td>
                        <td class="p-3 w-0">
                            {{-- <span class="text-blue-600 font-bold hover:border-b hover:border-blue-600 hover:cursor-pointer mr-1">
                                {{ __("Edit") }}
                            </span> --}}

                            <form action="{{ route('edit_role', ['id' => $role->id]) }}" method="get">
                                @csrf
                                <button class="text-blue-600 font-bold hover:border-b hover:border-blue-600 hover:cursor-pointer"
                                 type="submit">
                                    {{ __("Edit") }}
                                </button>
                            </form>

                            <form action="{{ route('delete_role', ['id' => $role->id]) .'?'. $queryString }}" method="post" onsubmit="return confirm('{{ __('Do you want to delete role') }}');">
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