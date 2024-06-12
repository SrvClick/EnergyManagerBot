<?php
namespace Srvclick\Energybot;

trait User
{
    public ?array $userData = null;
    public function printUserData()
    {
        $this->info("Bienvenido ".$this->userData['userData']['company']);
        $this->info('Puntos: '.$this->userData['userData']['points']);
        $this->info("Dinero: $".number_format($this->userData['userData']['account']));
    }
    public function getUserData()
    {
        $this->game->setUrl('https://energymanager.trophyapi.com/api/user.data.php');
        $this->response = $this->game->Send();
        $this->userData = $this->response->getBodyArray();
    }
}