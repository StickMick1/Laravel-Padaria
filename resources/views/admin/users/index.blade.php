<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Gestão de Usuários
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">
                
                <!-- Busca -->
                <form method="GET" class="mb-4">
                    <input type="text" name="search" value="{{ $search }}"
                        placeholder="Buscar usuário..." 
                        class="border rounded px-3 py-2 w-1/3">
                    <button class="bg-blue-500 text-white px-4 py-2 rounded">Buscar</button>
                </form>

                <!-- Botão criar -->
                <a href="{{ route('users.create') }}" 
                   class="bg-green-500 text-white px-4 py-2 rounded mb-4 inline-block">
                   Novo Usuário
                </a>

                <!-- Tabela -->
                <table class="min-w-full border">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2">ID</th>
                            <th class="px-4 py-2">Nome</th>
                            <th class="px-4 py-2">Email</th>
                            <th class="px-4 py-2">Cargo</th>
                            <th class="px-4 py-2">Status</th>
                            <th class="px-4 py-2">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr class="border-b">
                            <td class="px-4 py-2">{{ $user->id }}</td>
                            <td class="px-4 py-2">{{ $user->name }}</td>
                            <td class="px-4 py-2">{{ $user->email }}</td>
                            <td class="px-4 py-2">{{ $user->role }}</td>
                            <td class="px-4 py-2">{{ $user->status }}</td>
                            <td class="px-4 py-2">
                                <a href="{{ route('users.edit', $user) }}" 
                                   class="text-blue-500">Editar</a>
                                <form action="{{ route('users.destroy', $user) }}" 
                                      method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button class="text-red-500 ml-2">Bloquear</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
