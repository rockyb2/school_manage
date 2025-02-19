<div class="p-4 bg-white shadow rounded-lg">
    <h2 class="text-lg font-semibold">Statistiques</h2>
    <div class="mt-4">
        <p>Total d'enseignants : {{ $this->getData()['totalEnseignants'] }}</p>
        <p>Total de classes : {{ $this->getData()['totalClasses'] }}</p>
    </div>
</div>
