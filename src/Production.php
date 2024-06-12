<?php
namespace Srvclick\Energybot;

trait Production
{
    public function getGrids(): string
    {
        $grids = [];
        $this->getUserData();
        $plants = array_unique(array_column($this->userData['plants'], 'storageId'));
        foreach ($plants as $plant) {
            $storage = $this->getStatusStorage($plant);
            if (preg_match_all("/<button class=\"btn-box btn-box-blue w-100\" onClick=\"popup\('power-exchange-details\.php\?id=(.*?)'\);\"><span class='bi bi-currency-dollar'><\/span> Sell<\/button>/s", $storage, $matches)) {
                $gridIds = array_filter($matches[1], fn($id) => !in_array($id, $grids));
                $grids = array_merge($grids, $gridIds);
            }
        }
        return implode(',', $grids);
    }
    public function PowerExchange(): array
    {
        $this->game->setUrl('https://energymanager.trophyapi.com/power-exchange.php?');
        $this->game->setMethod("POST");
        $this->game->setParameters('_='.time());
        $this->response = $this->game->Send();
        preg_match_all("/<span id='value-kwh-(.*?)' data-value='(.*?)'>(.*?)<\/span>/s",$this->response->getBody(),$prices);
        $plants = [];
        for ($i = 0; $i < count($prices[0]); $i++) {
            //$this->info($prices[1][$i]." ".($prices[2][$i]*1000));
            $plants[$prices[1][$i]] = $prices[2][$i] * 1000;
        }
        return $plants;
    }

    public function sellStorage($storage,$grid): string
    {
        $this->game->setUrl('https://energymanager.trophyapi.com/power-exchange-sell.php?grid='.$grid.'&storage='.$storage.'&pct=0');
        $this->game->setMethod("POST");
        $this->game->setParameters('grid='.$grid.'&storage='.$storage.'&pct=0&_='.time());
        $this->response = $this->game->Send();
        return $this->response->getBody();
    }
    public function getStatusStorage($id): string
    {
        $this->game->setUrl('https://energymanager.trophyapi.com/status-storage.php?id='.$id);
        $this->game->setMethod("POST");
        $this->game->setParameters('id='.$id.'&_='.time());
        $response = $this->game->Send();
        return $response->getBody();
    }
    public function storageStartAll()
    {
        $this->game->setUrl('https://energymanager.trophyapi.com/production-plants-state.php?mode=online');
        $this->game->setMethod("POST");
        $this->game->setParameters('mode=online&_='.time());
        $this->response = $this->game->Send();
    }
    public function storageSellAll($grids)
    {
        $this->game->setUrl('https://energymanager.trophyapi.com/power-exchange-sell.php?grid='.$grids.'&pct=0');
        $this->game->setMethod("POST");
        $this->game->setParameters('grid='.$grids.'&pct=0');
        $this->response = $this->game->Send();
    }
    public function getStorage(): string
    {
        $this->game->setUrl('https://energymanager.trophyapi.com/production-storage.php?');
        $this->game->setMethod("POST");
        $this->game->setParameters(['_' => time()]);
        $this->response = $this->game->Send();
        return $this->response->getBody();
    }

}