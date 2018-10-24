<?php

namespace tim03we\sb;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\network\mcpe\protocol\types\ScorePacketEntry;
use pocketmine\network\mcpe\protocol\SetScorePacket;
use pocketmine\Player;
use pocketmine\network\mcpe\protocol\SetDisplayObjectivePacket;
use pocketmine\network\mcpe\protocol\RemoveObjectivePacket;
use pocketmine\utils\Config;
use pocketmine\Server;

class Scoreboard extends PluginBase implements Listener {
	
	private static $instance;

    public function onEnable(){
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
		self::$instance = $this;
		@mkdir($this->getDataFolder());
		$this->saveDefaultConfig();
		}
	
    public function onJoin (PlayerJoinEvent $event)
    {
        $pl = $this->getServer()->getOnlinePlayers();
        foreach ($pl as $player) {
            $this->rmScoreboard($player, "objektName");
            $this->createScoreboard($player, $this->getConfig()->get("title"), "objektName");
            $this->setScoreboardEntry($player, 1, $this->getConfig()->get("line1"), "objektName");
            $this->setScoreboardEntry($player, 2, $this->getConfig()->get("line2"), "objektName");
            $this->setScoreboardEntry($player, 3, $this->getConfig()->get("line3"), "objektName");
            $this->setScoreboardEntry($player, 4, $this->getConfig()->get("line4"), "objektName");
            $this->setScoreboardEntry($player, 5, $this->getConfig()->get("line5"), "objektName");
            $this->setScoreboardEntry($player, 6, $this->getConfig()->get("line6"), "objektName");
            $this->setScoreboardEntry($player, 7, $this->getConfig()->get("line7"), "objektName");
            $this->setScoreboardEntry($player, 8, $this->getConfig()->get("line8"), "objektName");
            $this->setScoreboardEntry($player, 9, $this->getConfig()->get("line9"), "objektName");
            $this->setScoreboardEntry($player, 10, $this->getConfig()->get("line10"), "objektName");
        }
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
}
