<?php

namespace Srvclick\Energybot;
trait SessionManager
{
    public function session($url)
    {
        $this->game->setUrl($url);
        $this->game->useCookie();
        $this->game->setCookieName(uniqid().'game.session');
        $this->response = $this->game->Send();
    }
}