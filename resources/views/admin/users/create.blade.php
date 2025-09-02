<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Criar Usuário</h2>
    </x-slot>

    <div class="max-w-lg mx-auto mt-6">
        <form method="POST" action="{{ route('users.store') }}" class="bg-white p-6 rounded shadow">
            @csrf
            <div class="mb-4">
                <label class="block">Nome</label>
                <input type="text" name="name" class="w-full border rounded px-3 py-2">
            </div>

            <div class="mb-4">
                <label class="block">Email</label>
                <input type="email" name="email" class="w-full border rounded px-3 py-2">
            </div>

            <div class="mb-4">
                <label class="block">Senha</label>
                <input type="password" name="password" class="w-full border rounded px-3 py-2">
            </div>

            <div class="mb-4">
                <label class="block">Cargo</label>
                <select name="role" class="w-full border rounded px-3 py-2">
                    <option value="member">Membro</option>
                    <option value="admin">Administrador</option>
                </select>
            </div>

            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded mb-4">
                Salvar
            </button>
        </form>
    </div>
</x-app-layout>

