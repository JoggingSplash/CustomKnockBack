<?php

namespace CustomCMD\venom\command;

use pocketmine\command\{Command as PMMPCommand, CommandSender};

abstract class Command extends PMMPCommand {

    protected array $subCommands;

    public function __construct(string $name, string $description = '', ?string $usage = null, array $alias = []){
        parent::__construct($name, $description, $usage, $alias);
    }

    public function addSubCommand(SubCommand $subCommand) : void {
        $this->subCommands[$subCommand->getName()] = $subCommand;
        foreach($subCommand->getAliases() as $alias){
            $this->subCommands[$alias] = $subCommand;
        }
    }

    public function getSubCommand(string $name) : ?SubCommand {
        return $this->subCommands[$name] ?? null;
    }

    abstract public function execute(CommandSender $sender, string $commandLabel, array $args) : void;

}