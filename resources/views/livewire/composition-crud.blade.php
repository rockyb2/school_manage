<div>
    <div class="flex items-center justify-center mb-4">
        <button wire:click="openModal" class="rounded-xl p-2 text-white bg-neutral-800">Créer une composition</button>
    </div>

    

    <!-- Tableau des compositions -->
    <table class="min-w-full bg-white mt-4">
        <thead>
            <tr>
                <th class="py-2">Titre</th>
                <th class="py-2">Date</th>
                <th class="py-2">Type</th>
                <th class="py-2">Classe</th>
                <th class="py-2">Matière</th>
                <th class="py-2">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($compositions as $composition)
                <tr>
                    <td class="border px-4 py-2">{{ $composition->titre }}</td>
                    <td class="border px-4 py-2">{{ $composition->date_composition }}</td>
                    <td class="border px-4 py-2">{{ $composition->type }}</td>
                    <td class="border px-4 py-2">{{ $composition->classe->nom_classe ?? '' }}</td>
                    <td class="border px-4 py-2">{{ $composition->matiere->nom_matiere ?? '' }}</td>
                    <td class="border px-4 py-2 flex justify-around">
                        <button wire:click="edit({{ $composition->id }})" class="bg-blue-500 text-white p-2 rounded">Modifier</button>
                       <button onclick="confirmDelete({{ $composition->id }})" class="bg-red-500 text-white p-2 rounded">
    Supprimer
</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Modal -->
    @if($showModal)
    <div class="fixed inset-0 backdrop-blur-sm bg-opacity-20 flex items-center justify-center z-50">
        <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-lg relative">
            <button wire:click="closeModal" class="absolute top-2 right-2 text-gray-500 hover:text-red-500 text-xl">&times;</button>
            <h2 class="text-xl font-bold mb-4">{{ $isEditMode ? 'Modifier' : 'Créer' }} la composition</h2>
            <form wire:submit.prevent="{{ $isEditMode ? 'update' : 'store' }}">
                <div class="mb-4">
                    <label class="block mb-1">Titre</label>
                    <input type="text" wire:model="titre" class="w-full border border-gray-300 rounded p-2" required>
                </div>
                <div class="mb-4">
                    <label class="block mb-1">Date</label>
                    <input type="date" wire:model="date" class="w-full border border-gray-300 rounded p-2" required>
                </div>
                <div class="mb-4">
                    <label class="block mb-1">Type</label>
                    <select wire:model="type" class="w-full border border-gray-300 rounded p-2" required>
                        <option value="">-- Sélectionner --</option>
                        <option value="examen">Examen</option>
                        <option value="composition">Evaluation</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block mb-1">Classe</label>
                    <select wire:model="classe_id" class="w-full border border-gray-300 rounded p-2" required>
                        <option value="">-- Sélectionner la classe --</option>
                        @foreach ($classes as $classe)
                            <option value="{{ $classe->id }}">{{ $classe->nom_classe }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block mb-1">Matière</label>
                    <select wire:model="matiere_id" class="w-full border border-gray-300 rounded p-2" required>
                        <option value="">-- Sélectionner la matière --</option>
                        @foreach ($matieres as $matiere)
                            <option value="{{ $matiere->id }}">{{ $matiere->nom_matiere }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition-all duration-300">
                    {{ $isEditMode ? 'Mettre à jour' : 'Créer' }}
                </button>
            </form>
        </div>
    </div>
    @endif
</div>
@push('scripts')
<script>
    Livewire.on('swal', function (data) {
        const title = data.title ?? 'Succès';
        const text = data.text ?? '';
        const icon = data.icon ?? 'success';

        Swal.fire({
            title: title,
            text: text,
            icon: icon,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK'
        });
    });
    function confirmDelete(id) {
        Swal.fire({
            title: 'Êtes-vous sûr ?',
            text: "Cette action est irréversible !",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Oui, supprimer !',
            cancelButtonText: 'Annuler'
        }).then((result) => {
            if (result.isConfirmed) {
                Livewire.dispatch('delete', id);
            }
        });
    }
</script>
@endpush

