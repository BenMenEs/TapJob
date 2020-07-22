<?php

namespace BenMenEs\TapJob;

use pocketmine\plugin\PluginBase;

class Main extends PluginBase{

    /** @var array */
    private $job = [];

    /** @var Config */
    public $config;

    /**
     * @return void
     */
    public function onEnable() : void{
        $this->saveDefaultConfig();
        $this->config = $this->getConfig()->getAll();
        $this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
    }

    /**
     * @param string $player
     * @return bool|true|false
     */
    public function isJobbing(string $player) : bool{
        return isset($this->job[strtolower($player)]);
    }

    /**
     * @param string $player
     * @param bool $value = true
     * @return void
     */
    public function setJobbing(string $player, bool $value = true) : void{
        switch($value){
            case true:
                $this->job[strtolower($player)] = strtolower($player);
            break;
            case false:
                unset($this->job[strtolower($player]);
            break;
        }
    }

    /**
     * @param string $player
     * @param int $reward = 5
     * @return void
     */
    public function giveReward(string $player, int $reward = 5) : void{
        $this->getServer()->getPluginManager()->getPlugin("EconomyAPI")->addMoney($player, $reward);
    }
}
