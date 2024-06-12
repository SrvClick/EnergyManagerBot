<?php
namespace Srvclick\Energybot;
use Srvclick\Scurl\Scurl_Request as SCURL;
use Srvclick\Scurl\Response as SCURL_Response;
class EnergyBot{

    use SessionManager , User , Production , Maintenance;
    private string $version = "Energy Bot Version 1.0.0";
    protected SCURL $game;
    protected SCURL_Response $response;
    public function __construct()
    {
        $this->info( $this->version."\n" );
        $this->game = new SCURL();
    }
    public function info($cmd)
    {
        echo $cmd."\n";
    }
}