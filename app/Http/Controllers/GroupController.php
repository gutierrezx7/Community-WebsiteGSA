<?php namespace App\Http\Controllers;

use App\GameserverApp\Exceptions\UploadExceededFileSizeLimitException;
use App\GameserverApp\Exceptions\UploadMimeTypeNotAcceptedException;
use App\GameserverApp\Helpers\UploadHelper;
use Illuminate\Http\Request;
use GameserverApp\Api\Client;
use GameserverApp\Helpers\SiteHelper;

class GroupController extends Controller
{
    private $api;
    
    public function __construct()
    {
        $this->api = app(Client::class);
    }
    
    public function show(Request $request, $id)
    {
        if( !SiteHelper::featureEnabled('tribe_page')) {
            return view('pages.v3.group.disabled');
        }

        $hoursplayed = (array) $this->api->stats('group', 'hours-played', $id);

        return view('pages.v3.group.index', [
            'group' => $this->api->group($id),
            'hoursPlayed' => $hoursplayed
        ]);
    }

    public function statistics(Request $request, $id)
    {
        if(! SiteHelper::featureEnabled('tribe_page')) {
            return view('pages.v3.group.disabled');
        }

        $group = $this->api->group($id);

        $stats = [];

        $stats['hours-played'] = (array) $this->api->stats('group', 'hours-played', $id);

        if($group->hasGame() and $group->game->supportLevel()) {
            $stats['levels-gained'] = (array) $this->api->stats('group', 'levels-gained', $id);
            $stats['xp-gained'] = (array) $this->api->stats('group', 'xp-gained', $id);
        }

        return view('pages.v3.group.statistics', [
            'group' => $group,
            'stats' => $stats
        ]);
    }

    public function log(Request $request, $id)
    {
        if(! SiteHelper::featureEnabled('tribe_page')) {
            return view('pages.v3.group.disabled');
        }

        $group = $this->api->group($id);

        if(
            !auth()->check() or
            (
                auth()->check() and
                !auth()->user()->isGroupMember($group)
            )
        ) {
            return view('pages.v3.group.restricted', [
                'group' => $group
            ]);
        }

        return view('pages.v3.group.log', [
            'group' => $group,
            'logs' => $this->api->groupLog($id, route('group.log', $id), $request->get('page'))
        ]);
    }
    
//    public function promote(Request $request, $id)
//    {
//        if(! SiteHelper::featureEnabled('tribe_page')) {
//            return view('pages.v1.tribe.disabled');
//        }
//
//        return view('pages.v1.tribe.promote', [
//            'tribe' => $this->api->group($id),
//        ]);
//    }

    public function settings(Request $request, $id)
    {
        if(! SiteHelper::featureEnabled('tribe_page')) {
            return view('pages.v3.group.disabled');
        }

        $this->api->clearCache('get', 'group/' . $id . '?settings=1', []);

        $group = $this->api->group($id, [
            'settings' => true,
            'auth' => true
        ]);

        if(
            !auth()->check() or
            !auth()->user()->isGroupMember($group) or
            (
                !$group->isOwner(auth()->user()) and
                !$group->isAdmin(auth()->user())
            )
        ) {
            return view('pages.v3.group.restricted', [
                'group' => $group
            ]);
        }

        return view('pages.v3.group.settings', [
            'group' => $group
        ]);
    }

    public function discordStatus(Request $request, $id,  $status)
    {
        switch($status) {
            case 'success':
                $alert = [
                    'status'  => 'success',
                    'message' => 'Feito! Seus registros agora também são reportados para o seu Discord.'
                ];
                break;

            case 'configure':
                $alert = [
                    'status'  => 'success',
                    'message' => 'Quase lá! Por favor, finalize as configurações.'
                ];
                break;

            case 'already-used':

                $alert = [
                    'status'  => 'danger',
                    'message' => 'Este servidor do Discord já está conectado a um Painel GSA.'
                ];
                break;

            case 'already-used-group':

                $alert = [
                    'status'  => 'danger',
                    'message' => 'Este servidor do Discord já está conectado a outro grupo.'
                ];
                break;

            case 'failed':
                $alert = [
                    'status'  => 'danger',
                    'message' => 'Algo deu errado. Certifique-se de que todas as permissões estão marcadas.'
                ];
                break;

            case 'disconnected':
                $alert = [
                    'status'  => 'success',
                    'message' => 'Suas informações do Discord foram removidas.'
                ];
                break;
        }


        return redirect(route('group.settings', $id))->with([
            'alert' => $alert
        ]);
    }

    public function storeSettings(Request $request, $id)
    {
        if(! SiteHelper::featureEnabled('tribe_page')) {
            return view('pages.v1.tribe.disabled');
        }

        $group = $this->api->group($id);

        $response = $this->api->saveGroupSettings(
            $group,
            $request->only([
                'motd',
                'about'
            ])
        );
        
        if(
            $response instanceof \Exception or
            is_null($response)
        ) {
            $error = json_decode($response->getResponse()->getBody());

            return redirect()->back()->withErrors($error);
        }

        return redirect(route('group.settings', $group->id))->with([
            'alert' => [
                'status' => 'success',
                'message' => 'Configurações salvas!'
            ]
        ]);
    }

    public function storeVisual(Request $request, $id)
    {
        if(! SiteHelper::featureEnabled('tribe_page')) {
            return view('pages.v1.tribe.disabled');
        }

        $group = $this->api->group($id);

        $files = ['logo', 'background'];

        foreach($files as $name) {
            $file = false;

            try {
                $file = UploadHelper::validate($request, $name);
            } catch (UploadExceededFileSizeLimitException $e) {
                return redirectBackWithAlert('O ' . $name . ' que você tentou fazer upload excedeu o limite de tamanho de upload.', 'danger');
            } catch (UploadMimeTypeNotAcceptedException $e) {
                return redirectBackWithAlert('O ' . $name . ' que você tentou fazer upload não é do tipo suportado.', 'danger');
            }

            if($file) {
                $response = $this->api->uploadGroupVisuals($group, $name, $file);
            }
        }

        if(!isset($response)) {
            return redirectBackWithAlert('Por favor, selecione um arquivo', 'warning');
        }

        if(
            $response instanceof \Exception or
            is_null($response)
        ) {
            $error = json_decode($response->getResponse()->getBody());

            return redirect()->back()->withErrors($error);
        }

        return redirect(route('group.settings', $group->id))->with([
            'alert' => [
                'status' => 'success',
                'message' => 'Arquivo enviado!'
            ]
        ]);
    }

    public function discordSetChannel(Request $request, $id)
    {
        if(! SiteHelper::featureEnabled('tribe_page')) {
            return view('pages.v3.group.disabled');
        }

        $group = $this->api->group($id);

        if($request->get('channel_id') == '-1') {
            return redirectBackWithAlert('Por favor, selecione um canal do Discord', 'danger');
        }

        $response = $this->api->saveGroupDiscordChannel(
            $group,
            $request->only([
                'channel_id'
            ])
        );

        if(
            $response instanceof \Exception or
            is_null($response)
        ) {
            $error = json_decode($response->getResponse()->getBody());

            return redirect()->back()->withErrors($error);
        }

        return redirect(route('group.discord.status', ['uuid' => $group->id, 'status' => 'success']));
    }

    public function disconnectDiscord(Request $request, $id)
    {
        if(! SiteHelper::featureEnabled('tribe_page')) {
            return view('pages.v3.group.disabled');
        }

        $group = $this->api->group($id);

        $response = $this->api->disconnectGroupDiscordChannel($group);

        if(
            $response instanceof \Exception or
            is_null($response)
        ) {
            $error = json_decode($response->getResponse()->getBody());

            return redirect()->back()->withErrors($error);
        }

        return redirect(route('group.discord.status', ['uuid' => $group->id, 'status' => 'disconnected']));
    }
}