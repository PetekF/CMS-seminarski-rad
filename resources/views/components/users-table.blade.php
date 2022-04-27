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
                @foreach ($items as $user)
                    <tr class="even:bg-gray-100">
                        <td class="p-3">{{$user->username}}</td>
                        <td class="p-3">{{$user->first_name}}</td>
                        <td class="p-3">{{$user->last_name}}</td>
                        <td class="p-3">{{$user->email}}</td>
                        <td class="p-3 w-0">{{ __($user->role->name) }}</td>
                        <td class="p-3 w-0">
                            {{-- <span class="text-blue-600 font-bold hover:border-b hover:border-blue-600 hover:cursor-pointer mr-1">
                                {{ __("Edit") }}
                            </span> --}}

                            <form action="{{ route('edit_user', ['id' => $user->id]) }}" method="get">
                                @csrf
                                <button class="text-blue-600 font-bold hover:border-b hover:border-blue-600 hover:cursor-pointer"
                                 type="submit">
                                    {{ __("Edit") }}
                                </button>
                            </form>

                            <form action="{{ route('delete_user', ['id' => $user->id]) .'?'. $queryString }}" method="post" onsubmit="return confirm('{{ __('Do you want to delete user') }}');">
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