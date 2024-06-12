<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\bien;
use App\Models\zone;
use App\Models\comptage;
use App\Models\comptage_bien;
use App\Models\departement_bien;
use App\Models\departement;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class BienImport implements ToCollection, WithHeadingRow
{
    protected $id_inventaire;

    public function __construct($id_inventaire)
    {
        $this->id_inventaire = $id_inventaire;
    }
    /**
    * @param Collection $collection
    */
    
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            try {
                $zone = zone::where('nom_zone', $row['zone'])->first();
                if (!$zone) {
                    throw new \Exception('Zone ' . $row['zone'] . ' n\'existe pas dans notre systeme.');
                }
                $departement = departement::where('nom_departement', $row['emplacement'])
                    ->where('id_zone', $zone->id_zone)
                    ->first();
                if (!$departement) {
                    throw new \Exception('Departement ' . $row['emplacement'] . ' n\'existe pas dans notre systeme.');
                }
            } catch (\Exception $e) {
                throw new \Exception('Erreur avec le bien code: ' . $row['code'] . ' - ' . $e->getMessage());
            }
        }
        
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
            $zone = zone::where('nom_zone', $row['zone'])->first();
            $departement = null;
            if ($zone) {
                $departement = departement::where('nom_departement', $row['emplacement'])
                    ->where('id_zone', $zone->id_zone)
                    ->first();
            }
            if($departement){
                $comptage= comptage::where('id_inventaire',$this->id_inventaire)
                ->where('id_departement',$departement->id_departement)
                ->first();

        if(!$comptage){
            $cat = new comptage();
                $cat->id_inventaire =$this->id_inventaire ;
                $cat->id_departement = $departement->id_departement;
                $cat->nom_comptage = "comptage_departement_" . $departement->nom_departement;
                $cat->id_user_createure=Auth::user()->id_user;   
                $cat->save();
        }
                
            }
            $bien = bien::where('barcode', $row['code'])->first();
            if ($bien) {
                
                if ($bien->etas != $row['etas'] ) {
                    $bien->etas = $row['etas'];
                    $bien->id_user_updateure = Auth::user()->id_user;
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
                    'id_user_importateure' => Auth::user()->id_user,

                ]);
            }
            if ($departement && $bien && $zone) {
                $departement_bien = departement_bien::where('id_bien', $bien->id_bien)
                ->where('etas_affectation', '!=', 'retiré')
                ->first();
                if($departement_bien && $departement_bien->id_departement !=  $departement->id_departement ){
                    departement_bien::updatesansid($departement_bien->id_departement ,$bien->id_bien, ['etas_affectation' => 'retiré' ,  'id_user_updateure' =>Auth::user()->id_user]);
                    /*$departement_bien2 = departement_bien::where('id_bien', $bien->id_bien)
                    ->where('id_departement', $departement->id_departement )
                    ->first();*/
                    if($departement_bien2){
                        departement_bien::updatesansid($departement->id_departement ,$bien->id_bien, ['etas_affectation' => 'en cours' ,  'id_user_updateure' =>Auth::user()->id_user]);
                       $departement_bien2 = departement_bien::where('id_departement', $departement->id_departement)
                       ->where('id_bien', $bien->id_bien)
                       ->first();
                    }else{
                       departement_bien::create([
                        'id_bien'        => $bien->id_bien,
                        'id_departement' => $departement->id_departement,
                        'affecter_a'     => $row['affectation'],
                        'id_user_importateure' => Auth::user()->id_user,
                    ]);
                    $departement_bien2 = departement_bien::where('id_departement', $departement->id_departement)
                    ->where('id_bien', $bien->id_bien)
                    ->first();    
                    }
                   
                }else{
                if(!$departement_bien){
                //       departement_bien::updatesansid($bien->id_bien, ['id_departement' => $departement->id_departement, 'affecter_a' => $row['affectation']]);
                   departement_bien::create([
                    'id_bien'        => $bien->id_bien,
                    'id_departement' => $departement->id_departement,
                    'affecter_a'     => $row['affectation'],
                    'id_user_importateure' => Auth::user()->id_user,
                ]); 
                $departement_bien2 = departement_bien::where('id_departement', $departement->id_departement)
                ->where('id_bien', $bien->id_bien)
                ->first();
                }
                
                
            }
              $comptage= comptage::where('id_inventaire',$this->id_inventaire)
                ->where('id_departement',$departement->id_departement)
                ->first();

        if($comptage){
            
                $comptage_bien = new comptage_bien();
        $comptage_bien->id_comptage = $comptage->id_comptage;
        $comptage_bien->id_bien = $bien->id_bien;
        $comptage_bien->id_user_createure=Auth::user()->id_user;
        $comptage_bien->save(); 
        
      
            }
            
        }
       
   
        }
    
    
    
    
}
}