<?php


namespace App\Http\Controllers;
use App\Models\inventaire;
use App\Models\comptage;
use App\Models\user;
use App\Models\employe;
use App\Models\bien;
use App\Models\departement_bien;
use App\Models\departement;
use App\Models\zone;
use App\Models\comptage_bien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class exportationControllers extends Controller
{
    public function export($id_inventaire)
    {
        $x = inventaire::find($id_inventaire);
    
        if (!$x) {
            return response()->json(['message' => 'Inventaire not found'], 404);
        }
    
        $fichier = "inventaire_".$x->nom_inventaire.".csv";
        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename=\"$fichier\"");
    
        $Sp = ';';
        $Rt = "\r";
        $id_user_createur = $x->id_user_createure;
        $id_user_updateur = $x->id_user_updateure;
        $x1 = user::find($id_user_createur);
        $e1 = employe::find($x1->id_employe);
        $nom_inventaire = $x->nom_inventaire;
        $etas = $x->etas;
        $dtcr = $x->created_at;
        $date_debut = $x->date_debut;
        $date_fin = $x->date_fin;
        $ec = $e1->nom_employe . ' ' . $e1->prenom_employe;
        $eu = null;
        $dtup = $x->updated_at;
        $observation = $x->observation;
        if ($id_user_updateur) {
            $x2 = user::find($id_user_updateur);
            if (!$x2) {
                return response()->json(['message' => 'not found'], 404);
            }
            $e2 = employe::find($x2->id_employe);
            $eu = $e2->nom_employe . ' ' . $e2->prenom_employe;
        }
    
        echo 'Nom inventaire' . $Sp . 'Etat inventaire' . $Sp . 'Date creation inventaire' . $Sp . 'Date debut inventaire' . $Sp . 'Date fin inventaire' . $Sp . 'Nom employe createur' . $Sp . 'Nom employe updateur' . $Sp . 'Date mise a jour inventaire' . $Sp . 'observation' . $Rt;
        $Core = $nom_inventaire . $Sp . $etas . $Sp . $dtcr . $Sp . $date_debut . $Sp . $date_fin . $Sp . $ec . $Sp . $eu . $Sp . $dtup . $Sp . $observation;
        echo $Core . $Rt.$Rt.$Rt;

            $comptage = comptage::where('id_inventaire', $id_inventaire)->get();
            if($comptage)
            {
                
                foreach ($comptage as $comptage)
                 {
                    echo 'Nom comptage' . $Sp . 'Etat comptage' . $Sp . 'Date creation comptage' . $Sp . 'Date debut comptage' . $Sp . 'Date fin comptage' . $Sp . 'Nom employe createur' . $Sp . 'Nom employe updateur' . $Sp . 'Date mise a jour comptage' . $Sp . 'observation' . $Rt;
                    $id_user_createur = $comptage->id_user_createure;
                    $id_user_updateur = $comptage->id_user_updateure;
                    $x1 = user::find($id_user_createur);
                    $e1 = employe::find($x1->id_employe);
                    $nom_comptage = $comptage->nom_comptage;
                    $etas = $comptage->etas;
                    $dtcr = $comptage->created_at;
                    $date_debut = $comptage->date_debut;
                    $date_fin = $comptage->date_fin;
                    $ec = $e1->nom_employe . ' ' . $e1->prenom_employe;
                    $eu = null;
                    $dtup = $comptage->updated_at;
                    $observation = $comptage->observation;
                    if ($id_user_updateur) {
                        $x2 = user::find($id_user_updateur);
                        if (!$x2) {
                            return response()->json(['message' => 'not found'], 404);
                        }
                        $e2 = employe::find($x2->id_employe);
                        $eu = $e2->nom_employe . ' ' . $e2->prenom_employe;
                    } 
                   $Core = $nom_comptage . $Sp . $etas . $Sp . $dtcr . $Sp . $date_debut . $Sp . $date_fin . $Sp . $ec . $Sp . $eu . $Sp . $dtup . $Sp . $observation.$Rt;
                  echo $Core.$Rt ;
                   echo 'CODE' . $Sp . 'LIBELLE' . $Sp . 'Date' . $Sp . 'Prix' . $Sp . 'Affectation' . $Sp . 'bil' . $Sp . 'NO_SERIE ' . $Sp . 'EMPLACEMENT' . $Sp . 'etas' .$Sp . 'vie' .$Sp . 'zone' .$Sp . 'etat d\'inventaire' .$Sp . 'Agent' .$Sp . 'date d\'inventaire' . $Rt;
                   
                   $comptage_bien = comptage_bien::where('id_comptage', $comptage->id_comptage)->get();
            if($comptage_bien)
            {
                
                
                foreach ($comptage_bien as $comptage_bien)
                 {
                    $bien = bien::where('id_bien', $comptage_bien->id_bien)->first();
                    if($bien){
                    $id_user_updateur = $comptage_bien->id_user_updateure;
                    $code = "'".$bien->barcode;
                    $libelle = $bien->nom_bien;
                    $date = $bien->date_achat;
                    $prix = $bien->prix_d_achat; 
                    $prix = preg_replace('/[^\d,.-]/', '', $prix);
                    $prix = str_replace(',', '.', $prix);
                    $prix = (float) $prix;

                    $x = departement_bien::where('id_departement', $comptage->id_departement)
                    ->where('id_bien', $bien->id_bien)
                    ->where('etas_affectation','en cours')
                    ->first();
                        if(!$x){
                        return response()->json(['message' => 'not found'], 404);
                        }
                    $affectation = $x->affecter_a;
                    $bil = $bien->fournisseure;
                    $NO_SERIE  = $bien->no_serie;
                    $etas = $bien->etas;
                    $vie = $bien->duree_vie;
                    $x7 = departement::where('id_departement', $comptage->id_departement)->first();
                    
                        if(!$x7){
                        return response()->json(['message' => 'not found'], 404);
                        }
                        $emplacment=$x7->nom_departement;
                        $z=zone::where('id_zone', $x7->id_zone)->first();
                        if(!$z){
                            return response()->json(['message' => 'not found'], 404);
                            }
                    $zone = $z->nom_zone;
                    $etat_inventaire = $comptage_bien->etas; 
                    $eu = null;
                    $date_d_inventaire = $comptage_bien->updated_at;
                    
                  
                   
                    if ($id_user_updateur) {
                        $x2 = user::find($id_user_updateur);
                        if (!$x2) {
                            return response()->json(['message' => 'not found'], 404);
                        }
                        $e2 = employe::find($x2->id_employe);
                        $eu = $e2->nom_employe . ' ' . $e2->prenom_employe;
                    } 
                   $Core = $code . $Sp . $libelle  . $Sp . $date . $Sp . $prix . $Sp . $affectation . $Sp . $bil . $Sp . $NO_SERIE . $Sp.$emplacment.$Sp . $etas . $Sp . $vie. $Sp . $zone. $Sp . $etat_inventaire. $Sp . $eu.$Sp .$date_d_inventaire.$Rt;
                   echo $Core ;
                }}

        echo $Rt.$Rt;
            }
       
    }}}
    public function exportcomptage($id_comptage)
    {
        $x = comptage::find($id_comptage);
    
        if (!$x) {
            return response()->json(['message' => 'Comptage not found'], 404);
        }
    
        $fichier = "comptage_".$x->nom_comptage.".csv";
        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename=\"$fichier\"");
    
        $Sp = ';';
        $Rt = "\r";
        $id_user_createur = $x->id_user_createure;
        $id_user_updateur = $x->id_user_updateure;
        $x1 = user::find($id_user_createur);
        $e1 = employe::find($x1->id_employe);
        $nom_comptage = $x->nom_comptage;
        $etas = $x->etas;
        $dtcr = $x->created_at;
        $date_debut = $x->date_debut;
        $date_fin = $x->date_fin;
        $ec = $e1->nom_employe . ' ' . $e1->prenom_employe;
        $eu = null;
        $dtup = $x->updated_at;
        $observation = $x->observation;
        if ($id_user_updateur) {
            $x2 = user::find($id_user_updateur);
            if (!$x2) {
                return response()->json(['message' => 'not found'], 404);
            }
            $e2 = employe::find($x2->id_employe);
            $eu = $e2->nom_employe . ' ' . $e2->prenom_employe;
        }
    
        echo 'Nom comptage' . $Sp . 'Etat comptage' . $Sp . 'Date creation comptage' . $Sp . 'Date debut comptage' . $Sp . 'Date fin comptage' . $Sp . 'Nom employe createur' . $Sp . 'Nom employe updateur' . $Sp . 'Date mise a jour comptage' . $Sp . 'observation' . $Rt;
        $Core = $nom_comptage . $Sp . $etas . $Sp . $dtcr . $Sp . $date_debut . $Sp . $date_fin . $Sp . $ec . $Sp . $eu . $Sp . $dtup . $Sp . $observation;
        echo $Core . $Rt;
    }
}