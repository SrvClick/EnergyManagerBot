<?php
namespace Srvclick\Energybot;
trait Maintenance
{
    public function startMaintenance($plant)
    {
        $this->game->setUrl('https://energymanager.trophyapi.com/maintenance.php?type=storage&id='.$plant.'&mode=do');
        $this->game->setMethod("POST");
        $this->game->setParameters('type=storage&id='.$plant.'&mode=do&_='.time());
        $this->response = $this->game->Send();
    }
    public function startMaintenancePlant($plant)
    {
        $this->game->setUrl('https://energymanager.trophyapi.com/maintenance.php?type=plant&id='.$plant.'&mode=do');
        $this->game->setMethod("POST");
        $this->game->setParameters('type=storage&id='.$plant.'&mode=do&_='.time());
        $this->response = $this->game->Send();
    }
}