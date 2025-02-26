<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Pusher\Pusher;

class Pusher_lib {
    private $pusher;

    public function __construct() {
        $CI =& get_instance();
        $CI->config->load('config');

        $options = [
            'cluster' => $CI->config->item('pusher')['cluster'],
            'useTLS'  => true
        ];

        $this->pusher = new Pusher(
            $CI->config->item('pusher')['key'],
            $CI->config->item('pusher')['secret'],
            $CI->config->item('pusher')['app_id'],
            $options
        );
    }

    public function trigger($channel, $event, $data,$socket_id) {
        return $this->pusher->trigger($channel, $event, $data, ['socket_id' => $socket_id]);
    }

    public function authenticate($socket_id, $channel_name) {
        return $this->pusher->authorizeChannel($channel_name, $socket_id);
    }

	public function getPusher(){
		return $this->pusher->getPusher();
	}
}
