<?php

namespace arrach\customkb\profile;

use pocketmine\entity\Attribute;
use pocketmine\entity\Entity;
use pocketmine\player\Player;

final class Profile {

    protected bool $initialKnockBack = false;
    protected bool $cancelKnockBack = false;

    public function __construct(private readonly Player $player)    {}

    public function getPlayer(): Player  {
        return $this->player;
    }

    public function cancelKnockBack(): bool  {
        return $this->cancelKnockBack;
    }

    public function initialKnockBack(): bool  {
        return $this->initialKnockBack;
    }

    public function setInitialKnockBack(bool $initialKnockBack = true): void    {
        $this->initialKnockBack = $initialKnockBack;
    }

    public function setCancelKnockBack(bool $cancelKnockBack = true): void    {
        $this->cancelKnockBack = $cancelKnockBack;
    }

    public function knockback(Entity $damager, float $h, float $v, float $limiter): void    {

        /*
         * we are going to use knockback as:
         * vertical knockback > player vertical´s kb
         * horizontal knockback > player horizontal´s kb
         *
         * height limiter > limit of kb from a player, put it to 0 to disable it.
         *
         * extra: it will remove switching.
         * */

        $player = $this->player;

        if ($limiter > 0 && !$player->isOnGround()) {
            $dist = $player->getPosition()->getY() > $damager->getPosition()->getY() ? $player->getPosition()->getY() - $damager->getPosition()->getY() : $damager->getPosition()->getY() - $player->getPosition()->getY();

            if ($dist >= $limiter) {
                $v -= $dist * $limiter;
            }
        }

        [$x, $z] = [$player->getPosition()->getX() - $damager->getPosition()->getX(), $player->getPosition()->getZ() - $damager->getPosition()->getZ()];
        $f = sqrt($x * $x + $z * $z);

        if ($f <= 0) {
            return;
        }
        if (mt_rand() / mt_getrandmax() > $player->getAttributeMap()->get(Attribute::KNOCKBACK_RESISTANCE)->getValue()) {
            $f = 1 / $f;
            $motion = clone $player->getMotion();

            $motion->x /= 2;
            $motion->y /= 2;
            $motion->z /= 2;

            $motion->x += $x * $f * $h;
            $motion->y += $v;
            $motion->z += $z * $f * $h;

            if ($motion->y > $v) {
                $motion->y = $v;
            }
            $this->initialKnockBack = true;
            $player->setMotion($motion);
        }
    }


}