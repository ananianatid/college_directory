<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Filiere;

class FiliereSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filieres = [
            // P\u00f4le Technologique
            ['name' => 'Genie Logiciel', 'pole' => 'Technologique'],
            ['name' => 'Syst\u00e8mes et Reseaux', 'pole' => 'Technologique'],
            ['name' => 'BIG DATA (IA)', 'pole' => 'Technologique'],
            ['name' => 'Genie Civil', 'pole' => 'Technologique'],
            ['name' => 'Publicite et Arts Graphiques', 'pole' => 'Technologique'],

            // P\u00f4le Tertiaire
            ['name' => 'Comptabilite Finance', 'pole' => 'Tertiaire'],
            ['name' => 'Communication Digitale', 'pole' => 'Tertiaire'],
            ['name' => 'Gestion Commerciale', 'pole' => 'Tertiaire'],
            ['name' => 'Communication des Organisations', 'pole' => 'Tertiaire'],
            ['name' => 'Gestion des Ressources Humaines', 'pole' => 'Tertiaire'],
            ['name' => 'Assistant Administratif', 'pole' => 'Tertiaire'],
            ['name' => 'Logistique et Transport', 'pole' => 'Tertiaire'],
        ];

        foreach ($filieres as $filiere) {
            Filiere::firstOrCreate(
            ['name' => $filiere['name']], // On verifie l'existence par le nom
            ['pole' => $filiere['pole']]
            );
        }
    }
}