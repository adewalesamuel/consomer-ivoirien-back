<?php
namespace App\Http\Controllers;

use App\Models\SouscriptionUtilisateur;
use App\Models\Souscription;
use App\Models\Utilisateur;
use Illuminate\Http\Request;
use App\Http\Requests\StoreSouscriptionUtilisateurRequest;
use App\Http\Requests\UpdateSouscriptionUtilisateurRequest;
use Illuminate\Support\Str;
use App\PaymentGateways\CinetPay;
use App\PaymentGateways\CinetPayCommande;


class SouscriptionUtilisateurController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'success' => true,
            'souscription_utilisateurs' => SouscriptionUtilisateur::with(
                ['souscription', 
                'utilisateur'])->where('id', '>', -1)
                ->orderBy('created_at', 'desc')->get()
        ];

        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSouscriptionUtilisateurRequest $request)
    {
        $validated = $request->validated();

        $souscription_utilisateur = new SouscriptionUtilisateur;

        $souscription_utilisateur->paiement_id = $validated['paiement_id'] ?? null;
		$souscription_utilisateur->souscription_id = $validated['souscription_id'] ?? null;
		$souscription_utilisateur->utilisateur_id = $validated['utilisateur_id'] ?? null;
		$souscription_utilisateur->prix = $validated['prix'] ?? null;
		$souscription_utilisateur->quantite = $validated['quantite'] ?? null;
		$souscription_utilisateur->mode_paiement = $validated['mode_paiement'] ?? null;
        
        if ($souscription_utilisateur->status) 
            $souscription_utilisateur->status = $validated['status'];

        $souscription_utilisateur->save();

        $utilisateur = Utilisateur::findOrFail($souscription_utilisateur->utilisateur_id);
        $souscription = Souscription::findOrFail($souscription_utilisateur->souscription_id);

        $url = $this->getCinetPayPaymentUrl($request, $souscription, $utilisateur);

        return $url;

        $data = [
            'success'       => true,
            'souscription_utilisateur'   => $souscription_utilisateur
        ];
        
        return response()->json($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SouscriptionUtilisateur  $souscription_utilisateur
     * @return \Illuminate\Http\Response
     */
    public function show(SouscriptionUtilisateur $souscription_utilisateur)
    {
        $data = [
            'success' => true,
            'souscription_utilisateur' => $souscription_utilisateur
        ];

        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SouscriptionUtilisateur  $souscription_utilisateur
     * @return \Illuminate\Http\Response
     */
    public function edit(SouscriptionUtilisateur $souscription_utilisateur)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SouscriptionUtilisateur  $souscription_utilisateur
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSouscriptionUtilisateurRequest $request, SouscriptionUtilisateur $souscription_utilisateur)
    {
        $validated = $request->validated();

        $souscription_utilisateur->paiement_id = $validated['paiement_id'] ?? null;
		$souscription_utilisateur->souscription_id = $validated['souscription_id'] ?? null;
		$souscription_utilisateur->utilisateur_id = $validated['utilisateur_id'] ?? null;
		$souscription_utilisateur->prix = $validated['prix'] ?? null;
		$souscription_utilisateur->quantite = $validated['quantite'] ?? null;
		$souscription_utilisateur->mode_paiement = $validated['mode_paiement'] ?? null;
        
        if ($souscription_utilisateur->status) 
            $souscription_utilisateur->status = $validated['status'];

        $souscription_utilisateur->save();

        $data = [
            'success'       => true,
            'souscription_utilisateur'   => $souscription_utilisateur
        ];
        
        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SouscriptionUtilisateur  $souscription_utilisateur
     * @return \Illuminate\Http\Response
     */
    public function destroy(SouscriptionUtilisateur $souscription_utilisateur)
    {   
        $souscription_utilisateur->delete();

        $data = [
            'success' => true,
            'souscription_utilisateur' => $souscription_utilisateur
        ];

        return response()->json($data);
    }

    private function getCinetPayPaymentUrl(Request $request, Souscription $souscription, Utilisateur $utilisateur) {
        $commande = new CinetPayCommande();
        
        try {
            $customer_name = $utilisateur->nom_prenoms;
            $customer_surname = $utilisateur->nom_prenoms;
            $description = $souscription->description;
            $amount = $souscription->prix;
            $currency = 'XOF';
            //transaction id
            $id_transaction = date("YmdHis"); // or $id_transaction = Cinetpay::generateTransId()

            //Veuillez entrer votre apiKey
            $apikey = env('CINET_PAY_KEY', '');
            //Veuillez entrer votre siteId
            $site_id = env('CINET_PAY_SITE_ID', '');

            //notify url
            $notify_url = $commande->getCurrentUrl().'cinetpay-sdk-php/notify/notify.php';
            //return url
            $return_url = $commande->getCurrentUrl().'cinetpay-sdk-php/return/return.php';
            $channels = "ALL";

            //
            $formData = array(
                "transaction_id"=> $id_transaction,
                "amount"=> $amount,
                "currency"=> $currency,
                "customer_surname"=> $customer_name,
                "customer_name"=> $customer_surname,
                "description"=> $description,
                "notify_url" => $notify_url,
                "return_url" => $return_url,
                "channels" => $channels,
                "metadata" => "", // utiliser cette variable pour recevoir des informations personnalisés.
                "alternative_currency" => "",//Valeur de la transaction dans une devise alternative
                //pour afficher le paiement par carte de credit
                "customer_email" => "", //l'email du client
                "customer_phone_number" => "", //Le numéro de téléphone du client
                "customer_address" => "", //l'adresse du client
                "customer_city" => "", // ville du client
                "customer_country" => "",//Le pays du client, la valeur à envoyer est le code ISO du pays (code à deux chiffre) ex : CI, BF, US, CA, FR
                "customer_state" => "", //L’état dans de la quel se trouve le client. Cette valeur est obligatoire si le client se trouve au États Unis d’Amérique (US) ou au Canada (CA)
                "customer_zip_code" => "" //Le code postal du client
            );
            // enregistrer la transaction dans votre base de donnée
            /*  $commande->create(); */

            $CinetPay = new CinetPay($site_id, $apikey);
            $result = $CinetPay->generatePaymentLink($formData);

            if ($result["code"] == '201')
            {
                return $result["data"]["payment_url"];
            }
        } catch (\Exception $e) {
            throw new \Exception("Une erreure est survenue. Veuillez réessayer" . $e, 1);
        }
    }
}