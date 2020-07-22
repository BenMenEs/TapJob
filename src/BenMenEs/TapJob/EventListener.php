<?php

namespace BenMenEs\TapJob;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;

class EventListener implements Listener{

    private $main;

    public function __construct(Main $main){
        $this->main = $main;
    }

    public function onInteract(PlayerInteractEvent $event){
        $player = $event->getPlayer();
        $nick = $player->getName();
        $block = $event->getBlock();
        $pos = $block->asPosition();
        $main = $this->main;
        $c = $main->config;
        if($pos->x == $c['x-start'] && $pos->y == $c['y-start'] && $pos->z == $c['z-start'] && $pos->level->getFolderName() == $c['level-start']){
            if($main->isJobbing($nick)){
                $player->sendMessage($c['already-jobbing']);
                return;
            }
            $main->setJobbing($nick);
            $player->sendMessage($c['job-start']);
            return;
        }
        if($pos->x == $c['x-finish'] && $pos->y == $c['y-finish'] && $pos->z == $c['z-finish'] && $pos->level->getFolderName() == $c['level-finish']){
            if(!$main->isJobbing($nick)){
                $player->sendMessage($c['job-error']);
                return;
            }
            $main->setJobbing($nick, false);
            $main->giveReward($nick, $c['reward']);
            $player->sendMessage(str_replace("{REWARD}", $c['reward'], $c['job-finish']));
        }
    }
}
