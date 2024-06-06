<?php

namespace CustomCMD\venom\command;

use pocketmine\command\CommandSender;

abstract class SubCommand {

    public function __construct(
        protected string $name,
        protected string $usage = '',
        protected array $aliases = [],
    ){}

    public function getName() : string {
        return $this->name;
    }

    public function getUsage() : ?string {
        return $this->usage;
    }

    public function getAliases() : array {
        return $this->aliases;
    }

    abstract public function execute(CommandSender $sender, string $commandLabel, array $args) : void;
}