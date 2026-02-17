<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('users') && !Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                $table->enum('role', ['admin', 'enseignant', 'etudiant'])->default('etudiant')->after('email');
            });
        }

        if (Schema::hasTable('admin') && !Schema::hasColumn('admin', 'user_id')) {
            Schema::table('admin', function (Blueprint $table) {
                $table->foreignId('user_id')->nullable()->unique()->after('id')->constrained('users')->nullOnDelete();
            });
        }

        if (Schema::hasTable('enseignants') && !Schema::hasColumn('enseignants', 'user_id')) {
            Schema::table('enseignants', function (Blueprint $table) {
                $table->foreignId('user_id')->nullable()->unique()->after('id')->constrained('users')->nullOnDelete();
            });
        }

        if (Schema::hasTable('etudiants') && !Schema::hasColumn('etudiants', 'user_id')) {
            Schema::table('etudiants', function (Blueprint $table) {
                $table->foreignId('user_id')->nullable()->unique()->after('id')->constrained('users')->nullOnDelete();
            });
        }

        $this->syncAdminUsers();
        $this->syncEnseignantUsers();
        $this->syncEtudiantUsers();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('etudiants') && Schema::hasColumn('etudiants', 'user_id')) {
            Schema::table('etudiants', function (Blueprint $table) {
                $table->dropConstrainedForeignId('user_id');
            });
        }

        if (Schema::hasTable('enseignants') && Schema::hasColumn('enseignants', 'user_id')) {
            Schema::table('enseignants', function (Blueprint $table) {
                $table->dropConstrainedForeignId('user_id');
            });
        }

        if (Schema::hasTable('admin') && Schema::hasColumn('admin', 'user_id')) {
            Schema::table('admin', function (Blueprint $table) {
                $table->dropConstrainedForeignId('user_id');
            });
        }

        if (Schema::hasTable('users') && Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('role');
            });
        }
    }

    private function syncAdminUsers(): void
    {
        if (!Schema::hasTable('admin')) {
            return;
        }

        $admins = DB::table('admin')->select('id', 'nom', 'email', 'password')->get();

        foreach ($admins as $admin) {
            if (empty($admin->email)) {
                continue;
            }

            $name = trim((string) ($admin->nom ?? 'Admin')) ?: 'Admin';
            $password = $this->normalizePassword($admin->password ?? null);

            $user = DB::table('users')->where('email', $admin->email)->first();

            if ($user) {
                DB::table('users')->where('id', $user->id)->update([
                    'name' => $name,
                    'role' => 'admin',
                    'updated_at' => now(),
                ]);
                $userId = $user->id;
            } else {
                $userId = DB::table('users')->insertGetId([
                    'name' => $name,
                    'email' => $admin->email,
                    'role' => 'admin',
                    'password' => $password,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            DB::table('admin')->where('id', $admin->id)->update(['user_id' => $userId]);
        }
    }

    private function syncEnseignantUsers(): void
    {
        if (!Schema::hasTable('enseignants')) {
            return;
        }

        $select = ['id', 'nom', 'prenoms', 'email'];
        if (Schema::hasColumn('enseignants', 'mot_de_passe')) {
            $select[] = 'mot_de_passe';
        }

        $enseignants = DB::table('enseignants')->select($select)->get();

        foreach ($enseignants as $enseignant) {
            if (empty($enseignant->email)) {
                continue;
            }

            $name = trim(((string) ($enseignant->nom ?? '') . ' ' . (string) ($enseignant->prenoms ?? ''))) ?: 'Enseignant';
            $rawPassword = property_exists($enseignant, 'mot_de_passe') ? $enseignant->mot_de_passe : null;
            $password = $this->normalizePassword($rawPassword);

            $user = DB::table('users')->where('email', $enseignant->email)->first();

            if ($user) {
                DB::table('users')->where('id', $user->id)->update([
                    'name' => $name,
                    'role' => 'enseignant',
                    'updated_at' => now(),
                ]);
                $userId = $user->id;
            } else {
                $userId = DB::table('users')->insertGetId([
                    'name' => $name,
                    'email' => $enseignant->email,
                    'role' => 'enseignant',
                    'password' => $password,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            DB::table('enseignants')->where('id', $enseignant->id)->update(['user_id' => $userId]);
        }
    }

    private function syncEtudiantUsers(): void
    {
        if (!Schema::hasTable('etudiants')) {
            return;
        }

        $etudiants = DB::table('etudiants')->select('id', 'nom', 'prenoms', 'email', 'matricule')->get();

        foreach ($etudiants as $etudiant) {
            if (empty($etudiant->email)) {
                continue;
            }

            $name = trim(((string) ($etudiant->nom ?? '') . ' ' . (string) ($etudiant->prenoms ?? ''))) ?: 'Etudiant';
            $seedPassword = (string) ($etudiant->matricule ?: Str::random(10));
            $password = $this->normalizePassword($seedPassword);

            $user = DB::table('users')->where('email', $etudiant->email)->first();

            if ($user) {
                DB::table('users')->where('id', $user->id)->update([
                    'name' => $name,
                    'role' => 'etudiant',
                    'updated_at' => now(),
                ]);
                $userId = $user->id;
            } else {
                $userId = DB::table('users')->insertGetId([
                    'name' => $name,
                    'email' => $etudiant->email,
                    'role' => 'etudiant',
                    'password' => $password,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            DB::table('etudiants')->where('id', $etudiant->id)->update(['user_id' => $userId]);
        }
    }

    private function normalizePassword(?string $password): string
    {
        if (is_string($password) && Str::startsWith($password, ['$2y$', '$2a$', '$argon2i$', '$argon2id$'])) {
            return $password;
        }

        $source = trim((string) $password);
        if ($source === '') {
            $source = Str::random(12);
        }

        return Hash::make($source);
    }
};
