<?php

namespace arrach\customkb\values;

use arrach\customkb\Loader;
use pocketmine\utils\Config;
use pocketmine\utils\SingletonTrait;

class Values {
    use SingletonTrait;

    private array $values = [];
    public const ARRAY_KNOCKBACK = "knockback";
    public const H = "horizontal";
    public const V = "vertical";
    public const L = "limiter";
    public const C = "cooldown";


    public function __construct() {}

    /**
     * @throws \JsonException
     */
    public function set(float $h, float $v, float $l, int $c): void    {
        $cf = new Config(Loader::getInstance()->getDataFolder() . 'config.yml', Config::YAML);


        $cf->set(self::ARRAY_KNOCKBACK, [
            self::H => $h,
            self::V => $v,
            self::L => $l,
            self::C => $c

        ]);

        $cf->save();
    }


    public function get(string $type): mixed  {
        $cf = new Config(Loader::getInstance()->getDataFolder() . 'config.yml', Config::YAML);
        return $cf->get(self::ARRAY_KNOCKBACK)[$type] ?? null;
    }



}