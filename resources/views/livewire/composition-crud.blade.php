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
                    <button wire:click="delete({{ $composition->id }})" class="bg-red-500 text-white px-2 py-1 rounded">
                        Supprimer
                    </button>
                    <button wire:click="addNote({{ $composition->id }})" class="bg-green-500 text-white px-2 py-1 rounded">
                        Attribuer une note
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

    <!-- Modal pour attribuer une note -->
    @if($showNoteModal)
    <div class="fixed inset-0 backdrop-blur-sm bg-opacity-20 flex items-center justify-center z-50">
        <div class="bg-white p-8 rounded-xl shadow-2xl w-full max-w-2xl relative">
            <button wire:click="$set('showNoteModal', false)" class="absolute top-2 right-2 text-gray-500 hover:text-red-500 text-xl">&times;</button>
            <h2 class="text-xl font-bold mb-4">Attribuer une note - {{ $compositionSelectionnee->titre ?? '' }}</h2>
            <form wire:submit.prevent="saveNotes">
                <table class="min-w-full bg-white mb-4">
                    <thead>
                        <tr>
                            <th class="py-2">Nom</th>
                            <th class="py-2">Prénoms</th>
                            <th class="py-2">Note</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($etudiants as $etudiant)
                            <tr>
                                <td class="border px-4 py-2">{{ $etudiant->nom }}</td>
                                <td class="border px-4 py-2">{{ $etudiant->prenoms }}</td>
                                <td class="border px-4 py-2">
                                    <input type="number" min="0" max="20" step="0.01"
                                        wire:model.defer="notes.{{ $etudiant->id }}"
                                        class="border rounded p-1 w-20" required>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition-all duration-300">
                    Enregistrer les notes
                </button>
            </form>
        </div>
    </div>
    @endif
</div>
@push('scripts')
<script>
    Livewire.on('swal', function(data) {
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
</script>
@endpush
