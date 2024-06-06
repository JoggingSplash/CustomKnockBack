<?php

namespace arrach\customkb\profile;

use pocketmine\player\Player;
use pocketmine\utils\SingletonTrait;

final class ProfileHandler {
    use SingletonTrait;

    /** @var Profile[]  */
    private array $profiles = [];

    public function get(Player $player): ?Profile {
        return $this->profiles[$player->getName()] ?? null;
    }

    public function create(Player $player): void {
        $this->profiles[$player->getName()] = new Profile($player);;
    }

    public function remove(Player $player): void {
        if (!($this->get($player)) === null) {
            return;
        }
        unset($this->profiles[$player->getName()]);
    }

    public function all(): array    {
        return $this->profiles;
    }

}