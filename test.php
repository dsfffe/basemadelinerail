<?php

/**
 * @var Creator : T.me//MrSylix
 * @version SylixTeam PHP Member Baner By MrSylix v1.0.0
 */


if (!file_exists('madeline.php')) {
    copy('https://phar.madelineproto.xyz/madeline.php', 'madeline.php');
}

include 'madeline.php';

use \danog\MadelineProto\API;
use \danog\Loop\Generic\GenericLoop;
use \danog\MadelineProto\EventHandler;


class XHandler extends EventHandler
{
    const Admins = [0 => 1919698445];
    const Report = '@MrMahdiii';

    public function getReportPeers()
    {
        return [self::Report];
    }
    public function genLoop()
    {
        yield $this->account->updateStatus([
            'offline' => false
        ]);
        return 60000;
    }

    public function onStart()
    {
        $genLoop = new GenericLoop([$this, 'genLoop'], 'update Status');
        $genLoop->start();
    }

    public function onUpdateNewChannelMessage($update)
    {
        yield $this->onUpdateNewMessage($update);
    }
    public function getMessages($update, $id = [])
    {
        try {
            $info = yield $this->getInfo($update);

            $method = in_array($info['type'], ['bot', 'user', 'chat']) ? 'messages' : 'channels';
            $params = ['id' => $id];

            if (in_array($info['type'], ['channel', 'supergroup'])) {
                $params['channel'] = $update;
            }

            $get = yield $this->$method->getMessages($params);
            return $get;
        } catch (Throwable $e) {
            //throw new Exception($e->getMessage());
        }
    }

    public function onUpdateNewMessage($update)
    {
        if (time() - $update['message']['date'] > 2) {
            return;
        }
        try {
            $msg             = isset($update['message']) ? $update['message'] : null;
            $txt             = isset($update['message']['message']) ? $update['message']['message'] : null;
            $msg_id          = isset($update['message']['id']) ? $update['message']['id'] : null;
            $reply_to_msg_id = isset($update['message']['reply_to']['reply_to_msg_id']) ? $update['message']['reply_to']['reply_to_msg_id'] : null;
            $user_id         = isset($update['message']['from_id']['user_id']) ? $update['message']['from_id']['user_id'] : null;
            $com             = isset($update['message']['fwd_from']['saved_from_peer']) ? true : false;
            $me              = yield $this->getSelf();
            $peer            = yield $this->getInfo($update);
            $chID            = yield $this->getID($update);
            $chat_id         = $peer['bot_api_id'];
            $type            = $peer['type'];


if($txt == ".."){
    $load = sys_getloadavg();

    yield $this->messages->editMessage(['peer' => $chID, 'id' => $msg_id, 'message' => "𖣐 Ping Server : $load[0] ", 'parse_mode' => 'MarkDown']);
}


            if (isset($update['message']['fwd_from']['saved_from_peer'])){
                yield $this->messages->sendMessage(['peer' => $chID, 'message' => "سلام میدونم خیلی تلاش کردی کامنتو اولو بگیری ولی نمیتونی با سرور آمازون 8 هسته بنده رقابت کنید 😐", 'parse_mode' => 'Markdown', 'reply_to_msg_id' => $msg_id]);
                }
                
            
            #ADMIN Commands
            if (in_array($user_id, self::Admins) || $user_id == $me_id) {
                

                    

       


            }
        } catch (\Throwable $e) {
            //$this->report("Surfaced: $e");
        }
    }
}

$settings = [
    'serialization' => [
        'cleanup_before_serialization' => true,
    ],
    'logger' => [
        'max_size' => 1 * 1024 * 1024,
    ],
    'peer' => [
        'full_fetch' => false,
        'cache_all_peers_on_startup' => false,
    ],
    'app_info' => [
        'api_id' => 1374236,
        'api_hash' => '4df50166bf37f939cd10c71ece878b06'
    ]
];

$bot = new \danog\MadelineProto\API('X.session', $settings);
$bot->startAndLoop(XHandler::class);
