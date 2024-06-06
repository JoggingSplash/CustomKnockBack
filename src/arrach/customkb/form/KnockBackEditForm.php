<?php

namespace arrach\customkb\form;

use arrach\customkb\values\Values;
use cosmicpe\form\CustomForm;
use cosmicpe\form\entries\custom\InputEntry;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;

final class KnockBackEditForm extends CustomForm {


    protected float $h;
    protected float $v;
    protected float $l;
    protected int $c;

    /**
     * @throws \JsonException
     */
    public function __construct()    {
        parent::__construct(TextFormat::DARK_PURPLE . 'KnockBack Edit Form');
        $this->addEntry(
            new InputEntry(
                TextFormat::RED . 'Horizontal',
                '',
                (string) Values::getInstance()?->get(Values::H)
            ),

            function (Player $player, InputEntry $entry, string $value): void {
                if(!is_numeric($value)) {
                    $player->sendMessage(TextFormat::RED . 'Use only numbers.');
                    return;
                }

                if($value < 0.0) {
                    $player->sendMessage(TextFormat::RED . 'Use only positive numbers.');
                    return;
                }

                if($value === Values::getInstance()?->get(Values::H)) {
                    return;
                }

                $this->setH($value);
                $player->sendMessage(TextFormat::AQUA . 'Changed Horizontal Kb to: ' . $value);

                Values::getInstance()->set($this->getH(), $this->getV(), $this->getL(), $this->getC());
            }
        );

        $this->addEntry(
            new InputEntry(
                TextFormat::RED . 'Vertical',
                '',
                (string) Values::getInstance()?->get(Values::V)
            ),

            function (Player $player, InputEntry $entry, string $value): void {
                if(!is_numeric($value)) {
                    $player->sendMessage(TextFormat::RED . 'Use only numbers.');
                    return;
                }

                if($value < 0.0) {
                    $player->sendMessage(TextFormat::RED . 'Use only positive numbers.');
                    return;
                }

                if($value === Values::getInstance()?->get(Values::V)) {
                    return;
                }

                $this->setV($value);
                $player->sendMessage(TextFormat::AQUA . 'Changed Vertical Kb to: ' . $value);

                Values::getInstance()->set($this->getH(), $this->getV(), $this->getL(), $this->getC());
            }
        );

        $this->addEntry(
            new InputEntry(
                TextFormat::RED . 'Limiter',
                '',
                (string) Values::getInstance()?->get(Values::L)
            ),

            function (Player $player, InputEntry $entry, string $value): void {
                if(!is_numeric($value)) {
                    $player->sendMessage(TextFormat::RED . 'Use only numbers.');
                    return;
                }

                if($value < 0.0) {
                    $player->sendMessage(TextFormat::RED . 'Use only positive numbers.');
                    return;
                }

                if($value === Values::getInstance()?->get(Values::L)) {
                    return;
                }

                $this->setL($value);
                $player->sendMessage(TextFormat::AQUA . 'Changed Limiter to: ' . $value);

                Values::getInstance()->set($this->getH(), $this->getV(), $this->getL(), $this->getC());
            }
        );

        $this->addEntry(
            new InputEntry(
                TextFormat::RED . 'Cooldown',
                '',
                (string) Values::getInstance()?->get(Values::C)
            ),

            function (Player $player, InputEntry $entry, string $value): void {
                if(!is_numeric($value) ) {
                    $player->sendMessage(TextFormat::RED . 'Use only numbers.');
                    return;
                }

                if($value < 0) {
                    $player->sendMessage(TextFormat::RED . 'Use only positive numbers.');
                    return;
                }

                if($value === Values::getInstance()?->get(Values::C)) {
                    return;
                }

                $this->setC($value);
                $player->sendMessage(TextFormat::AQUA . 'Changed Cooldown Attack to: ' . $value);

                Values::getInstance()->set($this->getH(), $this->getV(), $this->getL(), $this->getC());
            }
        );
    }

    public function getC(): int    {
        return $this->c ?? 10;
    }

    public function getH(): float {
        return $this->h ?? 0.4025;
    }

    public function getL(): float    {
        return $this->l ?? 100;
    }

    public function getV(): float    {
        return $this->v ?? 0.4025;
    }

    public function setC(int $c): void    {
        $this->c = $c;
    }

    public function setH(float $h): void    {
        $this->h = $h;
    }

    public function setL(float $l): void    {
        $this->l = $l;
    }

    public function setV(float $v): void   {
        $this->v = $v;
    }


}