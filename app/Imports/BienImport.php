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
                $bien->update([
                    'etas'          => $row['etas'],
                ]);
            } else {
                $bien = bien::create([
                    'nom_bien'      => $row['libelle'],
                    'prix_d_achat'  => $row['prix'],
                    'barcode'       => $row['code'],
                    'date_achat'    => $date_formatted,
                    'duree_vie'     => $row['vie'],
                    'qr_code'       => $row['code'],
                    'fournisseure'  => $row['bil'],
                    'etas'          => $row['etas'],
                    'no_serie'      => $row['no_serie'],
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
                $departement_bien = departement_bien::where('id_bien', $bien->id_bien)->first();
                if($departement_bien){
                       departement_bien::updatesansid($bien->id_bien, ['id_departement' => $departement->id_departement, 'affecter_a' => $row['affectation']]);
                    
                }else{
                departement_bien::create([
                    'id_bien'        => $bien->id_bien,
                    'id_departement' => $departement->id_departement,
                    'affecter_a'     => $row['affectation'],
                ]);
                }
            }
        }
        
    
    
    
    
    
}
}