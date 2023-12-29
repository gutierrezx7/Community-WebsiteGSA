<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GameserverApp\Api\Client;
use GameserverApp\Helpers\SiteHelper;

class SupporterTierController extends Controller
{
    /**
     * @var Client
     */
    private $client;

    /**
     * Construtor do Controlador.
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function index(Request $request)
    {
        if(! SiteHelper::featureEnabled('supporter_tiers')) {
            return view('pages.v3.supporter-tier.disabled');
        }

        $packages = $this->client->allSupporterTiers(route('supporter-tier.index'), request()->get('page', 1));

        if($request->has('status') == 'success') {
            session()->flash('alert', [
                'status'  => 'success',
                'message' => 'Obrigado por mostrar seu apoio!',
                'stay'    => true
            ]);
        }

        return view('pages.v3.supporter-tier.index', [
            'packages' => $packages
        ]);
    }

    public function show(Request $request, $id)
    {
        if(! SiteHelper::featureEnabled('supporter_tiers')) {
            return view('pages.v3.supporter-tier.disabled');
        }

        $package = $this->client->supporterTier($id);

        if ($request->has('status')) {
            switch ($request->get('status')) {
                case 'cancel':
                    session()->flash('alert', [
                        'status'  => 'warning',
                        'message' => 'Seu pedido foi cancelado',
                        'stay'    => true
                    ]);
                    break;

                case 'error':
                    session()->flash('alert', [
                        'status'  => 'warning',
                        'message' => 'Houve um erro durante o processo. Por favor, tente novamente ou entre em contato com o administrador.',
                        'stay'    => true
                    ]);
                    break;

                case 'discord-error':
                    session()->flash('alert', [
                        'status'  => 'warning',
                        'message' => 'Certifique-se de conectar sua conta do Discord antes de comprar este Nível de Apoio.',
                        'stay'    => true
                    ]);
                    break;

                case 'no-char-error':
                    session()->flash('alert', [
                        'status'  => 'warning',
                        'message' => 'Você precisa ter um personagem para pedir este Nível de Apoio.',
                        'stay'    => true
                    ]);
                    break;

                case 'paypal-missing-product-id':
                    session()->flash('alert', [
                        'status'  => 'warning',
                        'message' => 'O ID do produto PayPal não foi configurado corretamente. Peça ao administrador para atualizar o Nível de Apoio.',
                        'stay'    => true
                    ]);
                    break;

                case 'not-available':
                    session()->flash('alert', [
                        'status'  => 'warning',
                        'message' => 'Esta funcionalidade não é atualmente suportada.',
                        'stay'    => true
                    ]);
                    break;
            }
        }

        return view('pages.v3.supporter-tier.show', [
            'package' => $package
        ]);
    }

    public function purge($id)
    {
        $this->client->clearCache('get', 'supporter-tier');
        $this->client->clearCache('get', 'supporter-tier/show/' . $id);
    }
}