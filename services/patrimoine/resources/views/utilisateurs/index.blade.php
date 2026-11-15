@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">Utilisateurs</h1>
        <a href="{{ route('utilisateurs.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Nouvel utilisateur
        </a>
    </div>

    @if ($utilisateurs->isEmpty())
        <div class="p-6 bg-white rounded shadow">
            Aucun utilisateur n’a encore été créé.
        </div>
    @else
        <div class="bg-white rounded shadow overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-3">Nom</th>
                        <th class="p-3">Email</th>
                        <th class="p-3">Rôle</th>
                        <th class="p-3">Statut</th>
                        <th class="p-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($utilisateurs as $utilisateur)
                        <tr class="border-t">
                            <td class="p-3">{{ $utilisateur->nom }}</td>
                            <td class="p-3">{{ $utilisateur->email }}</td>
                            <td class="p-3">{{ ucfirst($utilisateur->role) }}</td>
                            <td class="p-3">{{ $utilisateur->actif ? 'Actif' : 'Inactif' }}</td>
                            <td class="p-3">
                                <a href="{{ route('utilisateurs.show', $utilisateur) }}" class="text-blue-600 hover:underline">Voir</a>
                                <a href="{{ route('utilisateurs.edit', $utilisateur) }}" class="text-yellow-600 hover:underline ml-2">Modifier</a>
                                <form action="{{ route('utilisateurs.destroy', $utilisateur) }}" method="POST" class="inline ml-2"
                                      onsubmit="return confirm('Supprimer cet utilisateur ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600 hover:underline">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $utilisateurs->links() }}
        </div>
    @endif
</div>
@endsection
