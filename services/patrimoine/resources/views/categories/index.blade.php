@extends('layouts.app')

@section('contenu')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-semibold">Catégories de biens</h1>
    <a href="{{ route('categories.create') }}"
       class="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">
        Nouvelle catégorie
    </a>
</div>

<div class="overflow-hidden rounded-lg border bg-white">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-3 text-left text-sm font-semibold">Nom</th>
                <th class="px-4 py-3 text-left text-sm font-semibold">Code</th>
                <th class="px-4 py-3 text-left text-sm font-semibold">Statut</th>
                <th class="px-4 py-3 text-right text-sm font-semibold">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse ($categories as $categorie)
                <tr>
                    <td class="px-4 py-3">{{ $categorie->nom }}</td>
                    <td class="px-4 py-3">{{ $categorie->code }}</td>
                    <td class="px-4 py-3">
                        {{ $categorie->actif ? 'Active' : 'Inactive' }}
                    </td>
                    <td class="px-4 py-3 text-right">
                        <a href="{{ route('categories.show', $categorie) }}"
                           class="text-blue-600 hover:underline">
                            Voir
                        </a>
                        <a href="{{ route('categories.edit', $categorie) }}"
                           class="ml-3 text-amber-600 hover:underline">
                            Modifier
                        </a>
                        <form action="{{ route('categories.destroy', $categorie) }}"
                              method="POST"
                              class="inline"
                              onsubmit="return confirm('Confirmez-vous la suppression de cette catégorie ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="ml-3 text-red-600 hover:underline">
                                Supprimer
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="px-4 py-6 text-center text-gray-500">
                        Aucune catégorie n’a encore été créée.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $categories->links() }}
</div>
@endsection
