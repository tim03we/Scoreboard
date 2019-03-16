<?php

namespace tim03we\scoreboard;

use pocketmine\scheduler\Task;
use tim03we\scoreboard\Scoreboard;
use iTzFreeHD\GG\GGAPI;
use iTzFreeHD\GG\GlobalGroups;
use iTzFreeHD\GG\Listeners;
use pocketmine\utils\Config;
use pocketmine\Server;

class ScoreboardTask extends Task {
	
    public $plugin;
    
	public function __construct(Scoreboard $plugin){
		$this->plugin = $plugin;
	}
	
	public function onRun(int $currentTick) : void {
        $settings = new Config($this->plugin->getDataFolder() . "settings.yml", Config::YAML);
        $pl = $this->plugin->getServer()->getOnlinePlayers();
        foreach ($pl as $player) {
            if($settings->get("GroupSystem") == "PurePerms") {
                $pp = $this->plugin->getServer()->getPluginManager()->getPlugin("PurePerms");
                $group = $pp->getUserDataMgr()->getGroup($player, null);
            }
            if($settings->get("GroupSystem") == "GlobalGroups") {
                $ggapi = new GGAPI(GlobalGroups::getInstance());
                $pinfo = $ggapi->getPlayerInfo($player);
                $group = $pinfo['Group'];
            }
            $playercount = count($this->plugin->getServer()->getOnlinePlayers());
            if($settings->get("EconomyAPI", true)) {
                $money = $this->plugin->getServer()->getPluginManager()->getPlugin('EconomyAPI')->myMoney($player);
            }
			$registered = count(glob($this->plugin->getServer()->getDataPath(). "players/*.dat"));
			$xpos = $player->getX();
			$ypos = $player->getY();
            $zpos = $player->getZ();
            $name = $player->getName();
            $ping = $player->getPing();
            $maxpcount = Server::getInstance()->getMaxPlayers();
            $tps = Server::getInstance()->getTicksPerSecond();
            $pip = $player->getAddress();
            $lname = $player->getLevel()->getName();

            $this->plugin->rmScoreboard($player, "objektName");
            if($settings->get("EconomyAPI", true)) {
                $this->plugin->createScoreboard($player, $this->convert($settings->get("title"), $money, $group, $xpos, $ypos, $zpos, $playercount, $maxpcount, $registered, $name, $ping, $tps, $pip, $lname), "objektName");
                $this->plugin->setScoreboardEntry($player, 1, $this->convert($settings->get("line1"), $money, $group, $xpos, $ypos, $zpos, $playercount, $maxpcount, $registered, $name, $ping, $tps, $pip, $lname), "objektName");
                $this->plugin->setScoreboardEntry($player, 2, $this->convert($settings->get("line2"), $money, $group, $xpos, $ypos, $zpos, $playercount, $maxpcount, $registered, $name, $ping, $tps, $pip, $lname), "objektName");
                $this->plugin->setScoreboardEntry($player, 3, $this->convert($settings->get("line3"), $money, $group, $xpos, $ypos, $zpos, $playercount, $maxpcount, $registered, $name, $ping, $tps, $pip, $lname), "objektName");
                $this->plugin->setScoreboardEntry($player, 4, $this->convert($settings->get("line4"), $money, $group, $xpos, $ypos, $zpos, $playercount, $maxpcount, $registered, $name, $ping, $tps, $pip, $lname), "objektName");
                $this->plugin->setScoreboardEntry($player, 5, $this->convert($settings->get("line5"), $money, $group, $xpos, $ypos, $zpos, $playercount, $maxpcount, $registered, $name, $ping, $tps, $pip, $lname), "objektName");
                $this->plugin->setScoreboardEntry($player, 6, $this->convert($settings->get("line6"), $money, $group, $xpos, $ypos, $zpos, $playercount, $maxpcount, $registered, $name, $ping, $tps, $pip, $lname), "objektName");
                $this->plugin->setScoreboardEntry($player, 7, $this->convert($settings->get("line7"), $money, $group, $xpos, $ypos, $zpos, $playercount, $maxpcount, $registered, $name, $ping, $tps, $pip, $lname), "objektName");
                $this->plugin->setScoreboardEntry($player, 8, $this->convert($settings->get("line8"), $money, $group, $xpos, $ypos, $zpos, $playercount, $maxpcount, $registered, $name, $ping, $tps, $pip, $lname), "objektName");
                $this->plugin->setScoreboardEntry($player, 9, $this->convert($settings->get("line9"), $money, $group, $xpos, $ypos, $zpos, $playercount, $maxpcount, $registered, $name, $ping, $tps, $pip, $lname), "objektName");
                $this->plugin->setScoreboardEntry($player, 10, $this->convert($settings->get("line10"), $money, $group, $xpos, $ypos, $zpos, $playercount, $maxpcount, $registered, $name, $ping, $tps, $pip, $lname), "objektName");
                $this->plugin->setScoreboardEntry($player, 11, $this->convert($settings->get("line11"), $money, $group, $xpos, $ypos, $zpos, $playercount, $maxpcount, $registered, $name, $ping, $tps, $pip, $lname), "objektName");
                $this->plugin->setScoreboardEntry($player, 12, $this->convert($settings->get("line12"), $money, $group, $xpos, $ypos, $zpos, $playercount, $maxpcount, $registered, $name, $ping, $tps, $pip, $lname), "objektName");
                $this->plugin->setScoreboardEntry($player, 13, $this->convert($settings->get("line13"), $money, $group, $xpos, $ypos, $zpos, $playercount, $maxpcount, $registered, $name, $ping, $tps, $pip, $lname), "objektName");
                $this->plugin->setScoreboardEntry($player, 14, $this->convert($settings->get("line14"), $money, $group, $xpos, $ypos, $zpos, $playercount, $maxpcount, $registered, $name, $ping, $tps, $pip, $lname), "objektName");
                $this->plugin->setScoreboardEntry($player, 15, $this->convert($settings->get("line15"), $money, $group, $xpos, $ypos, $zpos, $playercount, $maxpcount, $registered, $name, $ping, $tps, $pip, $lname), "objektName");
            } else {
                $this->plugin->createScoreboard($player, $this->secondConvert($settings->get("title"), $group, $xpos, $ypos, $zpos, $playercount, $maxpcount, $registered, $name, $ping, $tps, $pip, $lname), "objektName");
                $this->plugin->setScoreboardEntry($player, 1, $this->secondConvert($settings->get("line1"), $group, $xpos, $ypos, $zpos, $playercount, $maxpcount, $registered, $name, $ping, $tps, $pip, $lname), "objektName");
                $this->plugin->setScoreboardEntry($player, 2, $this->secondConvert($settings->get("line2"), $group, $xpos, $ypos, $zpos, $playercount, $maxpcount, $registered, $name, $ping, $tps, $pip, $lname), "objektName");
                $this->plugin->setScoreboardEntry($player, 3, $this->secondConvert($settings->get("line3"), $group, $xpos, $ypos, $zpos, $playercount, $maxpcount, $registered, $name, $ping, $tps, $pip, $lname), "objektName");
                $this->plugin->setScoreboardEntry($player, 4, $this->secondConvert($settings->get("line4"), $group, $xpos, $ypos, $zpos, $playercount, $maxpcount, $registered, $name, $ping, $tps, $pip, $lname), "objektName");
                $this->plugin->setScoreboardEntry($player, 5, $this->secondConvert($settings->get("line5"), $group, $xpos, $ypos, $zpos, $playercount, $maxpcount, $registered, $name, $ping, $tps, $pip, $lname), "objektName");
                $this->plugin->setScoreboardEntry($player, 6, $this->secondConvert($settings->get("line6"), $group, $xpos, $ypos, $zpos, $playercount, $maxpcount, $registered, $name, $ping, $tps, $pip, $lname), "objektName");
                $this->plugin->setScoreboardEntry($player, 7, $this->secondConvert($settings->get("line7"), $group, $xpos, $ypos, $zpos, $playercount, $maxpcount, $registered, $name, $ping, $tps, $pip, $lname), "objektName");
                $this->plugin->setScoreboardEntry($player, 8, $this->secondConvert($settings->get("line8"), $group, $xpos, $ypos, $zpos, $playercount, $maxpcount, $registered, $name, $ping, $tps, $pip, $lname), "objektName");
                $this->plugin->setScoreboardEntry($player, 9, $this->secondConvert($settings->get("line9"), $group, $xpos, $ypos, $zpos, $playercount, $maxpcount, $registered, $name, $ping, $tps, $pip, $lname), "objektName");
                $this->plugin->setScoreboardEntry($player, 10, $this->secondConvert($settings->get("line10"), $group, $xpos, $ypos, $zpos, $playercount, $maxpcount, $registered, $name, $ping, $tps, $pip, $lname), "objektName");
                $this->plugin->setScoreboardEntry($player, 11, $this->secondConvert($settings->get("line11"), $group, $xpos, $ypos, $zpos, $playercount, $maxpcount, $registered, $name, $ping, $tps, $pip, $lname), "objektName");
                $this->plugin->setScoreboardEntry($player, 12, $this->secondConvert($settings->get("line12"), $group, $xpos, $ypos, $zpos, $playercount, $maxpcount, $registered, $name, $ping, $tps, $pip, $lname), "objektName");
                $this->plugin->setScoreboardEntry($player, 13, $this->secondConvert($settings->get("line13"), $group, $xpos, $ypos, $zpos, $playercount, $maxpcount, $registered, $name, $ping, $tps, $pip, $lname), "objektName");
                $this->plugin->setScoreboardEntry($player, 14, $this->secondConvert($settings->get("line14"), $group, $xpos, $ypos, $zpos, $playercount, $maxpcount, $registered, $name, $ping, $tps, $pip, $lname), "objektName");
                $this->plugin->setScoreboardEntry($player, 15, $this->secondConvert($settings->get("line15"), $group, $xpos, $ypos, $zpos, $playercount, $maxpcount, $registered, $name, $ping, $tps, $pip, $lname), "objektName");
            }
        }
    }

    public function secondConvert(string $string, $group, $xpos, $ypos, $zpos, $playercount, $maxpcount, $registered, $name, $ping, $tps, $pip, $lname): string{
        $string = str_replace("{group}", $group, $string);
        $string = str_replace("{x}", $xpos, $string);
        $string = str_replace("{y}", $ypos, $string);
        $string = str_replace("{z}", $zpos, $string);
        $string = str_replace("{online_players}", $playercount, $string);
        $string = str_replace("{max_players}", $maxpcount, $string);
        $string = str_replace("{registered}", $registered, $string);
        $string = str_replace("{name}", $name, $string);
        $string = str_replace("{ping}", $ping, $string);
        $string = str_replace("{tps}", $tps, $string);
        $string = str_replace("{player_ip}", $pip, $string);
        $string = str_replace("{level_name}", $lname, $string);
        return $string;
	}

    public function convert(string $string, int $money, $group, $xpos, $ypos, $zpos, $playercount, $maxpcount, $registered, $name, $ping, $tps, $pip, $lname): string{
        $string = str_replace("{money}", $money, $string);
        $string = str_replace("{group}", $group, $string);
        $string = str_replace("{x}", $xpos, $string);
        $string = str_replace("{y}", $ypos, $string);
        $string = str_replace("{z}", $zpos, $string);
        $string = str_replace("{online_players}", $playercount, $string);
        $string = str_replace("{max_players}", $maxpcount, $string);
        $string = str_replace("{registered}", $registered, $string);
        $string = str_replace("{name}", $name, $string);
        $string = str_replace("{ping}", $ping, $string);
        $string = str_replace("{tps}", $tps, $string);
        $string = str_replace("{player_ip}", $pip, $string);
        $string = str_replace("{level_name}", $lname, $string);
        return $string;
	}
}
