<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class permission extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('permissions')->insert([
            'nom_permission' => 'bien',
        
            
        ]);
        DB::table('permissions')->insert([
            'nom_permission' => 'ajouter bien',
      
        ]);
        DB::table('permissions')->insert([
            'nom_permission' => 'modifier bien',
      
        ]);
        DB::table('permissions')->insert([
            'nom_permission' => 'importer bien',
      
        ]);
        DB::table('permissions')->insert([
            'nom_permission' => 'inventaire',
      
            
        ]);
        DB::table('permissions')->insert([
            'nom_permission' => 'afficher tous les inventaire',
      
        ]);
        DB::table('permissions')->insert([
            'nom_permission' => 'ajouter inventaire',
      
        ]);
        DB::table('permissions')->insert([
            'nom_permission' => 'modifier inventaire',
      
        ]);
        DB::table('permissions')->insert([
            'nom_permission' => 'supprimer inventaire',
      
        ]);
        DB::table('permissions')->insert([
            'nom_permission' => 'lancer inventaire',
      
        ]);
        DB::table('permissions')->insert([
            'nom_permission' => 'annuler inventaire',
      
        ]);
        DB::table('permissions')->insert([
            'nom_permission' => 'cloturer inventaire',
      
        ]);
        DB::table('permissions')->insert([
            'nom_permission' => 'exporter inventaire',
      
        ]);
        DB::table('permissions')->insert([
            'nom_permission' => 'importer inventaire',
      
        ]);

        DB::table('permissions')->insert([
            'nom_permission' => 'comptage',
            
            
        ]);
        DB::table('permissions')->insert([
            'nom_permission' => 'afficher tous les comptage',
      
        ]);
        DB::table('permissions')->insert([
            'nom_permission' => 'ajouter comptage',
      
        ]);
        DB::table('permissions')->insert([
            'nom_permission' => 'modifier comptage',
      
        ]);
        DB::table('permissions')->insert([
            'nom_permission' => 'supprimer comptage',
      
        ]);
        DB::table('permissions')->insert([
            'nom_permission' => 'lancer comptage',
      
        ]);
        DB::table('permissions')->insert([
            'nom_permission' => 'annuler comptage',
      
        ]);
        DB::table('permissions')->insert([
            'nom_permission' => 'cloturer comptage',
      
        ]);
        DB::table('permissions')->insert([
            'nom_permission' => 'equipe',
         
            
        ]);
        DB::table('permissions')->insert([
            'nom_permission' => 'ajouter equipe',
      
        ]);
        DB::table('permissions')->insert([
            'nom_permission' => 'modifier equipe',
      
        ]);
        DB::table('permissions')->insert([
            'nom_permission' => 'supprimer equipe',
      
        ]);
        DB::table('permissions')->insert([
            'nom_permission' => 'attribuer equipe',
      
        ]);
        DB::table('permissions')->insert([
            'nom_permission' => 'zone',
        
            
        ]);
        DB::table('permissions')->insert([
            'nom_permission' => 'ajouter zone',
      
        ]);
        DB::table('permissions')->insert([
            'nom_permission' => 'modifier zone',
      
        ]);
        DB::table('permissions')->insert([
            'nom_permission' => 'supprimer zone',
      
        ]);
        DB::table('permissions')->insert([
            'nom_permission' => 'departement',
       
            
        ]);
        DB::table('permissions')->insert([
            'nom_permission' => 'ajouter departement',
      
        ]);
        DB::table('permissions')->insert([
            'nom_permission' => 'modifier departement',
      
        ]);
        DB::table('permissions')->insert([
            'nom_permission' => 'supprimer departement',
      
        ]);
        DB::table('permissions')->insert([
            'nom_permission' => 'utilisateur',
      
            
        ]);
        DB::table('permissions')->insert([
            'nom_permission' => 'ajouter utilisateur',
      
        ]);
        DB::table('permissions')->insert([
            'nom_permission' => 'modifier utilisateur',
      
        ]);
        DB::table('permissions')->insert([
            'nom_permission' => 'bloquer utilisateur',
      
        ]);
        DB::table('permissions')->insert([
            'nom_permission' => 'role',
           
            
        ]);
        DB::table('permissions')->insert([
            'nom_permission' => 'ajouter role',
      
        ]);
        DB::table('permissions')->insert([
            'nom_permission' => 'modifier role',
      
        ]);
        DB::table('permissions')->insert([
            'nom_permission' => 'bloquer role',
      
        ]);
        DB::table('permissions')->insert([
            'nom_permission' => 'permission',
      
        ]);
        DB::table('permissions')->insert([
            'nom_permission' => 'employe',
          
        ]);
        DB::table('permissions')->insert([
            'nom_permission' => 'ajouter employe',
      
        ]);
        DB::table('permissions')->insert([
            'nom_permission' => 'modifier employe',
      
        ]);
        DB::table('permissions')->insert([
            'nom_permission' => 'supprimer employe',
      
        ]);
        DB::table('permissions')->insert([
            'nom_permission' => 'afficher tous equipe',
      
        ]);
    }
}
