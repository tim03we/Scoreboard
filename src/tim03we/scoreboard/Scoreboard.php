<?php

namespace tim03we\scoreboard;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use tim03we\scoreboard\ScoreboardTask;
use pocketmine\network\mcpe\protocol\types\ScorePacketEntry;
use pocketmine\network\mcpe\protocol\SetScorePacket;
use pocketmine\Player;
use pocketmine\network\mcpe\protocol\SetDisplayObjectivePacket;
use pocketmine\network\mcpe\protocol\RemoveObjectivePacket;
use pocketmine\utils\Config;

class Scoreboard extends PluginBase implements Listener {

    public function onEnable(){
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getLogger()->info("Plugin enabled!");
        $this->saveResource("settings.yml");
        $settings = new Config($this->getDataFolder() . "settings.yml", Config::YAML);
        if($settings->get("GroupSystem") == "GlobalGroups") {
            if(!$this->getServer()->getPluginManager()->getPlugin("GlobalGroups")){
                $this->getLogger()->critical("GlobalGroups does not exist!");
                $this->getServer()->getPluginManager()->disablePlugin($this->getServer()->getPluginManager()->getPlugin('Scoreboard'));
            }
        } else if($settings->get("GroupSystem") == "PurePerms") {
            if(!$this->getServer()->getPluginManager()->getPlugin("PurePerms")){
                $this->getLogger()->critical("PurePerms does not exist!");
                $this->getServer()->getPluginManager()->disablePlugin($this->getServer()->getPluginManager()->getPlugin('Scoreboard'));
            }
        } else if($settings->get("EconomyAPI") == "true") {
                if(!$this->getServer()->getPluginManager()->getPlugin("EconomyAPI")){
                    $this->getLogger()->critical("EconomyAPI does not exist!");
                    $this->getServer()->getPluginManager()->disablePlugin($this->getServer()->getPluginManager()->getPlugin('Scoreboard'));
                }
            }
        } else if($settings->get("Scoreboard Activate") == "false") {
            $this->getLogger()->notice("The plugin was deactivated because it was disabled in the config!");
            $this->getServer()->getPluginManager()->disablePlugin($this->getServer()->getPluginManager()->getPlugin('Scoreboard'));
        }
    }
	
    public function onJoin (PlayerJoinEvent $event){
        $settings = new Config($this->getDataFolder() . "settings.yml", Config::YAML);
        $this->getscheduler()->scheduleRepeatingTask(new ScoreboardTask($this), $settings->get("Update Task"));
    }

    public function setScoreboardEntry(Player $player, int $score, string $msg, string $objName) {
        $entry = new ScorePacketEntry();
        $entry->objectiveName = $objName;
        $entry->type = 3;
        $entry->customName = " $msg   ";
        $entry->score = $score;
        $entry->scoreboardId = $score;
        $pk = new SetScorePacket();
        $pk->type = 0;
        $pk->entries[$score] = $entry;
        $player->sendDataPacket($pk);
    }

    public function rmScoreboardEntry(Player $player, int $score) {
        $pk = new SetScorePacket();
        if(isset($pk->entries[$score])) {
            unset($pk->entries[$score]);
            $player->sendDataPacket($pk);
        }
    }

    public function createScoreboard(Player $player, string $title, string $objName, string $slot = "sidebar", $order = 0) {
        $pk = new SetDisplayObjectivePacket();
        $pk->displaySlot = $slot;
        $pk->objectiveName = $objName;
        $pk->displayName = $title;
        $pk->criteriaName = "dummy";
        $pk->sortOrder = $order;
        $player->sendDataPacket($pk);
    }

    public function rmScoreboard(Player $player, string $objName) {
        $pk = new RemoveObjectivePacket();
        $pk->objectiveName = $objName;
        $player->sendDataPacket($pk);
    }

    public function onDisable(){
        $this->getLogger()->info("Plugin disabled!");
    }
}
