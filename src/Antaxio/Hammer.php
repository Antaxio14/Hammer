<?php

namespace Antaxio\hammer;

use pocketmine\block\Air;
use pocketmine\block\Block;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\item\Item;
use pocketmine\math\Vector3;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\utils\Config;

class Hammer extends PluginBase implements Listener
{
    private $config;

    public function onEnable()
    {
	    $this->getServer()->getPluginManager()->registerEvents($this, $this);

        @mkdir($this->getDataFolder());

        if(!file_exists($this->getDataFolder()."config.yml")){

            $this->saveResource('config.yml');

        }

        $this->config = new Config($this->getDataFolder().'config.yml', Config::YAML);

    }

    public function onBlockBreaks(BlockBreakEvent $event)
    {
        $item = $event->getItem();
        $block = $event->getBlock();

        if ($item->getId() === $this->config->get("id")) {

            if (!$event->isCancelled()) {

                $event->setCancelled();
                $this->addBlock($block);

            }
        }

    }

    private function addBlock(Block $blocks)
    {
        $minX = $blocks->x - 1;
        $maxX = $blocks->x + 1;

        $minY = $blocks->y - 1;
        $maxY = $blocks->y + 1;

        $minZ = $blocks->z - 1;
        $maxZ = $blocks->z + 1;

        for ($x = $minX; $x <= $maxX; $x++) {

            for ($y = $minY; $y <= $maxY; $y++) {

                for ($z = $minZ; $z <= $maxZ; $z++) {

                    $block = $blocks->getLevel()->getBlockAt($x,$y,$z);

                    if ($block->getId() == Block::OBSIDIAN or
                        $block->getId() == Block::BEDROCK) {

                    } else {

                        $block->getLevel()->setBlock(new Vector3($x, $y, $z), new Air());

                        $item = $this->onTransform($block);
                        $block->getLevel()->dropItem(new Vector3($x, $y, $z), $item);

                    }

                }

            }

        }

    }

    public function onTransform(Block $block) : Item
    {
        switch ($block->getId()) {

            case Block::STONE:

                return Item::get(0);

                break;

            case Block::GRASS:

                return Item::get(0);

                break;

            case Block::SAND:

                return Item::get(0);

                break;

            case Block::PURPUR_BLOCK:

                return Item::get(0);

                break;

            case Block::SANDSTONE:

                return Item::get(0);

                break;

            case Block::LAVA:

                return Item::get(0);

                break;

            case Block::WATER:

                return Item::get(0);

                break;

            case Block::DIRT:

                return Item::get(0);

                break;

            case Block::COAL_ORE:

                return Item::get(Item::COAL);

                break;

            case Block::DIAMOND_ORE:

                return Item::get(Item::DIAMOND);

                break;

            case Block::GLASS:

                return Item::get(0);

                break;

            case 17:

                return Item::get(0);

                break;

            case 162:

                return Item::get(0);

                break;

            case 246:

                return Item::get(0);

                break;

            case 31:

                return Item::get(0);

                break;

            case 175:

                return Item::get(0);

                break;

            case 74:

                return Item::get(Block::REDSTONE_ORE);

                break;

            case Block::GLASS_PANE:

                return Item::get(0);

                break;

            case Block::ENDER_CHEST:

                return Item::get(Item::OBSIDIAN,0, 5);

                break;

            case Block::ANVIL:

                return Item::get(Item::OBSIDIAN, $block->getDamage(), 5);

                break;

            case Block::GLOWSTONE:

                return Item::get(Item::PRISMARINE_CRYSTALS, 0, rand(1,4));

                break;

            case Block::SPONGE:

                return Item::get(0);

                break;

            default:

                return Item::get($block->getID());

                break;

        }

    }

}
