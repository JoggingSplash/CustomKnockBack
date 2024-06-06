<?php

namespace arrach\customkb;

use arrach\customkb\command\KnockBack;
use arrach\customkb\profile\ProfileHandler;
use arrach\customkb\values\Values;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\SingletonTrait;

final class Loader extends PluginBase {
    use SingletonTrait;

    protected function onLoad(): void    {
        self::setInstance($this);
    }

    protected function onEnable(): void    {
        $this->saveDefaultConfig();

        new KnockBack($this);
        new EventHandler($this);
        new Values();
    }

    protected function onDisable(): void    {
        foreach (ProfileHandler::getInstance()->all() as $profiles) {
            ProfileHandler::getInstance()->remove($profiles->getPlayer());
        }
    }

}