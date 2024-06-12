    <?php
    use App\Http\Controllers\exportationControllers;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\zoneControllers;
    use App\Http\Controllers\permissionControllers;
    use App\Http\Controllers\roleControllers;
    use App\Http\Controllers\role_permissionControllers;
    use App\Http\Controllers\userControllers;
    use App\Http\Controllers\AuthControllers;
    use App\Http\Controllers\inventaireControllers;
    use App\Http\Controllers\equipeControllers;
    use App\Http\Controllers\equipe_userControllers;
    use App\Http\Controllers\employeControllers;
    use App\Http\Controllers\departementControllers;
    use App\Http\Controllers\departement_bienControllers;
    use App\Http\Controllers\bienControllers;
    use App\Http\Controllers\comptageControllers;
    use App\Http\Controllers\comptage_bienControllers;
    /*
    |--------------------------------------------------------------------------
    | API Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register API routes for your application. These
    | routes are loaded by the RouteServiceProvider and all of them will
    | be assigned to the "api" middleware group. Make something great!
    |
    */ 

    Route::get('/auth/afficher', [AuthControllers::class, 'afficher']);
    Route::post('/auth/login', [AuthControllers::class, 'login'])->name('login');
    Route::prefix('permission')->group(function () {
        Route::get('/liste_permission', [permissionControllers::class, 'index']);
        Route::post('/ajouter_permission', [permissionControllers::class, 'store']);
        Route::get('/afiicher_permission/{id_permission}', [permissionControllers::class, 'show']);
        Route::post('/modifier_permission/{id_permission}', [permissionControllers::class, 'update']);
        Route::delete('/suprimer_permission/{id_permission}', [permissionControllers::class, 'destroy']);
    });
    Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::post('/auth/deconexion', [AuthControllers::class, 'deconexion'])->name('deconexion');
      //return $request->user();
    Route::prefix('zone')->group(function () {
        Route::get('/liste_zone', [zoneControllers::class, 'index']);
        Route::post('/ajouter_zone', [zoneControllers::class, 'store']);
        Route::get('/afiicher_zone/{id_zone}', [zoneControllers::class, 'show']);
        Route::post('/modifier_zone/{id_zone}', [zoneControllers::class, 'update']);
        Route::delete('/suprimer_zone/{id_zone}', [zoneControllers::class, 'destroy']);
    });
    
    Route::get('comptage/export/{id_comptage}', [exportationControllers::class, 'exportcomptage']);
    Route::get('inventaire/export/{id_inventaire}', [exportationControllers::class, 'export']);
        Route::prefix('inventaire')->group(function () {
        Route::get('/liste_inventaire', [inventaireControllers::class, 'index']);
        Route::post('/ajouter_inventaire', [inventaireControllers::class, 'store']);
        Route::get('/afiicher_inventaire/{id_inventaire}', [inventaireControllers::class, 'show']);
        Route::post('/modifier_inventaire/{id_inventaire}', [inventaireControllers::class, 'update']);
        Route::delete('/suprimer_inventaire/{id_inventaire}', [inventaireControllers::class, 'destroy']);
    });


    Route::prefix('equipe')->group(function () {
        Route::get('/liste_equipe', [equipeControllers::class, 'index']);
        Route::post('/ajouter_equipe', [equipeControllers::class, 'store']);
        Route::get('/afiicher_equipe/{id_equipe}', [equipeControllers::class, 'show']);
        Route::post('/modifier_equipe/{id_equipe}', [equipeControllers::class, 'update']);
        Route::delete('/suprimer_equipe/{id_equipe}', [equipeControllers::class, 'destroy']);
    });


    Route::prefix('equipe-user')->group(function () {
        Route::get('/liste_equipe_user', [equipe_userControllers::class, 'index']);
        Route::post('/ajouter_equipe_user', [equipe_userControllers::class, 'store']);
        Route::get('/afiicher_equipe_user/{id_equipe}/{id_user}', [equipe_userControllers::class, 'show']);
        Route::post('/modifier_equipe_user/{id_equipe}/{id_user}', [equipe_userControllers::class, 'update']);
        Route::delete('/suprimer_equipe_user/{id_equipe}/{id_user}', [equipe_userControllers::class, 'destroy']);
    });

    Route::prefix('employe')->group(function (){
        Route::get('/liste_employe', [employeControllers::class,'index']);
        Route::post('/ajouter_employe',[employeControllers::class,'store']);
        Route::get('/afiicher_employe/{id_employe}',[employeControllers::class,'show']);
        Route::post('/modifier_employe/{id_employe}',[employeControllers::class,'update']);
        Route::delete('/suprimer_employe/{id_employe}',[employeControllers::class,'destroy']);
    }
    );
    Route::prefix('departement')->group(function () {
        Route::get('/liste_departement', [departementControllers::class, 'index']);
        Route::post('/ajouter_departement', [departementControllers::class, 'store']);
        Route::get('/afiicher_departement/{id_departement}', [departementControllers::class, 'show']);
        Route::post('/modifier_departement/{id_departement}', [departementControllers::class, 'update']);
        Route::delete('/suprimer_departement/{id_departement}', [departementControllers::class, 'destroy']);
    });


    Route::prefix('departement-bien')->group(function () {
        Route::get('/liste_departement_bien', [departement_bienControllers::class, 'index']);
        Route::post('/ajouter_departement_bien', [departement_bienControllers::class, 'store']);
        Route::get('/afiicher_departement_bien/{id_departement}/{id_bien}', [departement_bienControllers::class, 'show']);
        Route::post('/modifier_departement_bien/{id_departement}/{id_bien}', [departement_bienControllers::class, 'update']);
        Route::delete('/suprimer_departement_bien/{id_departement}/{id_bien}', [departement_bienControllers::class, 'destroy']);
    });

    Route::prefix('comptage')->group(function () {
        Route::get('/exel_comptage', [comptageControllers::class, 'import']);
        Route::get('/liste_comptage', [comptageControllers::class, 'index']);
        Route::post('/ajouter_comptage', [comptageControllers::class, 'store']);
        Route::get('/afiicher_comptage/{id_comptage}', [comptageControllers::class, 'show']);
        Route::post('/modifier_comptage/{id_comptage}', [comptageControllers::class, 'update']);
        Route::delete('/suprimer_comptage/{id_comptage}', [comptageControllers::class, 'destroy']);
    });

    Route::prefix('bien')->group(function () {
       // Route::get('/exel_bien', [bienControllers::class, 'import']);
       Route::post('/exel_biensansinv', [bienControllers::class, 'importe_exel_data_sansinv']);
        Route::post('/exel_bien/{id_inventaire}', [bienControllers::class, 'importe_exel_data']);
        Route::get('/liste_bien', [bienControllers::class, 'index']);
        Route::post('/ajouter_bien', [bienControllers::class, 'store']);
        Route::get('/afiicher_bien/{id_bien}', [bienControllers::class, 'show']);
        Route::post('/modifier_bien/{id_bien}', [bienControllers::class, 'update']);
        Route::delete('/suprimer_bien/{id_bien}', [bienControllers::class, 'destroy']);
    });

    Route::prefix('comptage-bien')->group(function () {
        Route::get('/liste_comptage_bien', [comptage_bienControllers::class, 'index']);
        Route::post('/ajouter_comptage_bien', [comptage_bienControllers::class, 'store']);
        Route::get('/afiicher_comptage_bien/{id_comptage}/{id_bien}', [comptage_bienControllers::class, 'show']);
        Route::post('/modifier_comptage_bien/{id_comptage}/{id_bien}', [comptage_bienControllers::class, 'updateEtas']);
        Route::delete('/suprimer_comptage_bien/{id_comptage}/{id_bien}', [comptage_bienControllers::class, 'destroy']);
    });
    Route::prefix('role')->group(function () {
        Route::get('/liste_role', [roleControllers::class, 'index']);
        Route::post('/ajouter_role', [roleControllers::class, 'store']);
        Route::get('/afiicher_role/{id_role}', [roleControllers::class, 'show']);
        Route::post('/modifier_role/{id_role}', [roleControllers::class, 'update']);
        Route::delete('/suprimer_role/{id_role}', [roleControllers::class, 'destroy']);
    });

    Route::prefix('user')->group(function () {
        Route::get('/liste_user', [userControllers::class, 'index']);
        Route::post('/ajouter_user', [userControllers::class, 'store']);
        Route::get('/afiicher_user/{id_user}', [userControllers::class, 'show']);
        Route::post('/modifier_user/{id_user}', [userControllers::class, 'update']);
        Route::delete('/suprimer_user/{id_user}', [userControllers::class, 'destroy']);
    });

    Route::prefix('role-permission')->group(function () {
        Route::get('/liste_role_permission', [role_permissionControllers::class, 'index']);
        Route::post('/ajouter_role_permission', [role_permissionControllers::class, 'store']);
        Route::get('/afiicher_role_permission/{id_role}/{id_permission}', [role_permissionControllers::class, 'show']);
        Route::post('/modifier_role_permission/{id_role}/{id_permission}', [role_permissionControllers::class, 'update']);
        Route::delete('/suprimer_role_permission/{id_role}/{id_permission}', [role_permissionControllers::class, 'destroy']);
    });
});