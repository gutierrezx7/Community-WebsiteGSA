<?php
namespace GameserverApp\Composers;

use Illuminate\View\View;
use GameserverApp\Api\Client;
use GameserverApp\Api\OAuthApi;

class PopulationOverview
{
    /**
     * @var Client
     */
    private $api;

    public function __construct()
    {
        $this->api = app(Client::class);
    }

    public function compose(View $view)
    {
        $stats = [];

        $stats[] = [
            'name' => 'Novos sobreviventes',
            'col' => 6,
            'route' => 'new-characters'
        ];

        $stats[] = [
            'name' => 'Jogadores online',
            'col' => 6,
            'route' => 'online-players'
        ];

        $stats[] = [
            'name' => 'Horas jogadas por dia',
            'col' => 12,
            'route' => 'hours-played'
        ];

        $view->with([
            'stats' => $stats
        ]);
    }
}