<?php

namespace arrach\customkb;

use arrach\customkb\profile\ProfileHandler;
use arrach\customkb\values\Values;
use pocketmine\block\Furnace;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityMotionEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerLoginEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\network\mcpe\NetworkBroadcastUtils;
use pocketmine\network\mcpe\protocol\AnimatePacket;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;

class EventHandler implements Listener {

    public function __construct(private readonly PluginBase $loader){
        $this->loader->getServer()->getPluginManager()->registerEvents($this, $this->loader);
    }

    public function handleLogin(PlayerLoginEvent $event): void    {
        ProfileHandler::getInstance()->create($event->getPlayer());
    }

    public function handleQuit(PlayerQuitEvent $event): void    {
        $player = $event->getPlayer();

        $profile = ProfileHandler::getInstance()->get($player);

        if($profile === null) {
            return;
        }

        ProfileHandler::getInstance()->remove($player);
    }

    public function handleDamage(EntityDamageEvent $event): void    {
        $player = $event->getEntity();

        if (!$player instanceof Player) {
            return;
        }

        $profile = ProfileHandler::getInstance()->get($player);

        if ($profile === null) {
            return;
        }

        if ($event instanceof EntityDamageByEntityEvent) {
            $damager = $event->getDamager();

            if ($event->isCancelled()) {
                return;
            }

            if ($event->getModifier(EntityDamageEvent::MODIFIER_PREVIOUS_DAMAGE_COOLDOWN) < 0) {
                $event->cancel();
                return;
            }

            $event->setKnockBack(0.0); // remove vanilla kb
            $event->setAttackCooldown(Values::getInstance()->get(Values::C)); //add custom cooldown

            $profile->knockback($damager, Values::getInstance()->get(Values::H), Values::getInstance()->get(Values::V), Values::getInstance()->get(Values::L)); //add custom kb

            //you still can do switching with throwable items
        }
    }

    public function handleData(DataPacketReceiveEvent $event): void    {
        $player = $event->getOrigin()->getPlayer();
        $pk = $event->getPacket();
        if(!$player instanceof Player) {
            return;
        }

        if($pk instanceof AnimatePacket) {
            if($pk->action === AnimatePacket::ACTION_SWING_ARM) {
                $event->cancel();
                NetworkBroadcastUtils::broadcastPackets($player->getViewers(), [$pk]);
            }
        }

        //remove arm sounds
    }

    public function handleMotion(EntityMotionEvent $event): void {
        $player = $event->getEntity();

        if(!$player instanceof Player) {
            return;
        }

        $profile = ProfileHandler::getInstance()->get($player);

        if($profile === null) {
            return;
        }

        if ($profile->initialKnockBack()) {
            $profile->setInitialKnockBack(false);
            $profile->setCancelKnockBack();
        } elseif ($profile->cancelKnockBack()) {
            $profile->setCancelKnockBack(false);
            $event->cancel();
        }

    }
}