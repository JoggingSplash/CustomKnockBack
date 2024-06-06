<?php

namespace arrach\customkb\command;

use arrach\customkb\form\KnockBackEditForm;
use CustomCMD\venom\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;

class KnockBack extends Command {
    public function __construct(private readonly PluginBase $loader)    {
        parent::__construct('kb', '', '');
        $this->setPermission('customkb.op');
        $this->setAliases(['knockback']);
        $this->loader->getServer()->getCommandMap()->register('kb', $this);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): void    {
        if(!$this->testPermission($sender)) {
            $sender->sendMessage(TextFormat::RED . 'You dont have permission to edit knockback values.');
            return;
        }

        if(!$sender instanceof Player) {
            return;
        }

        $sender->sendForm(new KnockBackEditForm());
    }

}