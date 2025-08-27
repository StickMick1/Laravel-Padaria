<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Editar Usuário</h2>
    </x-slot>

    <div class="max-w-lg mx-auto mt-6">
        <form method="POST" action="{{ route('users.update', $user) }}" class="bg-white p-6 rounded shadow">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block">Nome</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" 
                       class="w-full border rounded px-3 py-2">
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" 
                       class="w-full border rounded px-3 py-2">
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block">Cargo</label>
                <select name="role" class="w-full border rounded px-3 py-2">
                    <option value="member" @selected($user->role === 'member')>Membro</option>
                    <option value="admin" @selected($user->role === 'admin')>Administrador</option>
                </select>
                @error('role')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block">Status</label>
                <select name="status" class="w-full border rounded px-3 py-2">
                    <option value="active" @selected($user->status === 'ativo')>Ativo</option>
                    <option value="blocked" @selected($user->status === 'bloqueado')>Bloqueado</option>
                </select>
            </div>

            <button class="bg-blue-500 text-white px-4 py-2 rounded">Atualizar</button>
            <a href="{{ route('users.index') }}" class="ml-2 text-gray-600">Cancelar</a>
        </form>
    </div>
</x-app-layout>
