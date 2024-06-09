<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\bien;
use App\Models\zone;
use App\Models\departement_bien;
use App\Models\departement;
use Illuminate\Support\Facades\Validator;

class BienImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    
   protected $id_user_createure; // Ajoutez cette propriété

    public function __construct($id_user_createure)
    {
        $this->id_user_createure = $id_user_createure;
    }
    public function collection(Collection $rows)
    {
        
        foreach ($rows as $row) {
            $date_formatted = null;
            $date_input = $row['date'];
            $date = \DateTime::createFromFormat('d/m/y', $date_input);
            if ($date !== false && $date->format('d/m/y') === $date_input) {
                $date_formatted = $date->format('Y-m-d');
            } else {
                 $date_input = intval($row['date']);
                    $date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($date_input);
                    $date_formatted = $date->format('Y/m/d');
            }
            
            $bien = bien::where('barcode', $row['code'])->first();
            if ($bien) {
                
                if ($bien->etas != $row['etas'] ) {
                    $bien->etas = $row['etas'];
                    $bien->id_user_updateure = $this->id_user_createure;
                    $bien->save();
                }
                   
            } else {
                $bien = bien::create([
                    'nom_bien'      => $row['libelle'],
                    'prix_d_achat'  => $row['prix'],
                    'barcode'       => $row['code'],             
                    'date_achat'    => $date_formatted,
                    'duree_vie'     => $row['vie'],
                    'fournisseure'  => $row['bil'],
                    'etas'          => $row['etas'],
                    'no_serie'      => $row['no_serie'],
                    'id_user_importateure' => $this->id_user_createure,

                ]);
            }
        
            $zone = zone::where('nom_zone', $row['zone'])->first();
            $departement = null;
            if ($zone) {
                $departement = departement::where('nom_departement', $row['emplacement'])
                    ->where('id_zone', $zone->id_zone)
                    ->first();
            }
        
            if ($departement && $bien && $zone) {
                $departement_bien = departement_bien::where('id_bien', $bien->id_bien)
                ->where('etas_affectation', '!=', 'retiré')
                ->first();
                if($departement_bien && $departement_bien->id_departement !=  $departement->id_departement ){
                    departement_bien::updatesansid($departement_bien->id_departement ,$bien->id_bien, ['etas_affectation' => 'retiré' ,  'id_user_updateure' =>$this->id_user_createure]);
                    $departement_bien2 = departement_bien::where('id_bien', $bien->id_bien)
                    ->where('id_departement', $departement->id_departement )
                    ->first();
                    if($departement_bien2){
                        departement_bien::updatesansid($departement->id_departement ,$bien->id_bien, ['etas_affectation' => 'en cours' ,  'id_user_updateure' =>$this->id_user_createure]);
                    }else{
                       departement_bien::create([
                        'id_bien'        => $bien->id_bien,
                        'id_departement' => $departement->id_departement,
                        'affecter_a'     => $row['affectation'],
                        'id_user_importateure' => $this->id_user_createure,
                    ]);    
                    }
                   
                }else{
                if(!$departement_bien){
                //       departement_bien::updatesansid($bien->id_bien, ['id_departement' => $departement->id_departement, 'affecter_a' => $row['affectation']]);
                   departement_bien::create([
                    'id_bien'        => $bien->id_bien,
                    'id_departement' => $departement->id_departement,
                    'affecter_a'     => $row['affectation'],
                    'id_user_importateure' => $this->id_user_createure,
                ]); 
                }
                
                
            }
        }
        
        }
    
    
    
    
}
}