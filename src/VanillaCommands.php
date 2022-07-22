<?php
/**
 *  _ _ _                                                   _
 * | (_) |                                                 | |
 * | |_| |__   ___ ___  _ __ ___  _ __ ___   __ _ _ __   __| |
 * | | | '_ \ / __/ _ \| '_ ` _ \| '_ ` _ \ / _` | '_ \ / _` |
 * | | | |_) | (_| (_) | | | | | | | | | | | (_| | | | | (_| |
 * |_|_|_.__/ \___\___/|_| |_| |_|_| |_| |_|\__,_|_| |_|\__,_|
 *
 * This library is free software licensed under the MIT license.
 * For more information about the license, visit the link below:
 *
 * https://opensource.org/licenses/MIT
 *
 * Copyright (c) 2022 Matthew Jordan
 */
declare(strict_types=1);

namespace libcommand;

use InvalidArgumentException;
use libcommand\parameter\Parameter;
use libcommand\parameter\types\BoolParameter;
use libcommand\parameter\types\enums\EnumParameter;
use libcommand\parameter\types\enums\ItemEnumParameter;
use libcommand\parameter\types\FilepathParameter;
use libcommand\parameter\types\FloatParameter;
use libcommand\parameter\types\IntParameter;
use libcommand\parameter\types\JsonParameter;
use libcommand\parameter\types\MessageParameter;
use libcommand\parameter\types\RawTextParameter;
use libcommand\parameter\types\StringParameter;
use libcommand\parameter\types\SubcommandParameter;
use libcommand\parameter\types\TargetParameter;
use libcommand\parameter\types\ValueParameter;
use libcommand\parameter\types\Vector3Parameter;
use pocketmine\network\mcpe\protocol\types\command\CommandParameter;
use pocketmine\utils\RegistryTrait;

/**
 * @method static self BAN()
 * @method static self BAN_IP()
 * @method static self BANLIST()
 * @method static self CLEAR()
 * @method static self DEFAULTGAMEMODE()
 * @method static self DEOP()
 * @method static self DIFFICULTY()
 * @method static self DUMPMEMORY()
 * @method static self EFFECT()
 * @method static self ENCHANT()
 * @method static self GAMEMODE()
 * @method static self GC()
 * @method static self GIVE()
 * @method static self KICK()
 * @method static self KILL()
 * @method static self LIST()
 * @method static self ME()
 * @method static self OP()
 * @method static self PARDON()
 * @method static self PARDON_IP()
 * @method static self PARTICLE()
 * @method static self PLUGINS()
 * @method static self SAVE_ALL()
 * @method static self SAVE_OFF()
 * @method static self SAVE_ON()
 * @method static self SAY()
 * @method static self SEED()
 * @method static self SETWORLDSPAWN()
 * @method static self SPAWNPOINT()
 * @method static self STATUS()
 * @method static self STOP()
 * @method static self TELL()
 * @method static self TIME()
 * @method static self TP()
 * @method static self TIMINGS()
 * @method static self TITLE()
 * @method static self TRANSFERSERVER()
 * @method static self VERSION()
 * @method static self WHITELIST()
 */
final class VanillaCommands {
	use RegistryTrait;

	protected static function setup(): void {
		self::register("ban", [
			new Overload("player", [new TargetParameter("player"), new RawTextParameter("reason", true)]),
			new Overload("name", [new StringParameter("name"), new RawTextParameter("reason", true)])
		]);
		self::register("ban-ip", [
			new Overload("ip", [new StringParameter("ip"), new RawTextParameter("reason", true)]),
			new Overload("player", [new TargetParameter("player"), new RawTextParameter("reason", true)])
		]);
		self::register("banlist", [
			new Overload("default", [new EnumParameter("type", "BanType", ["ips", "players"], true)])
		]);
		self::register("clear", [
			new Overload("default", [
				new TargetParameter("player", true),
				new ItemEnumParameter("itemName", true),
				new IntParameter("data", true),
				new IntParameter("maxCount", true)
			])
		]);
		self::register("defaultgamemode", [
			new Overload("enum", [new EnumParameter("gameMode", "GameMode", ["survival", "creative", "adventure", "spectator"])]),
			new Overload("int", [new IntParameter("gameMode")])
		]);
		self::register("deop", [
			new Overload("player", [new TargetParameter("player")]),
			new Overload("name", [new StringParameter("name")])
		]);
		self::register("difficulty", [
			new Overload("enum", [
				new EnumParameter(
					"difficulty",
					"Difficulty",
					["p", "peaceful", "e", "easy", "n", "normal", "h", "hard"]
				)
			]),
			new Overload("int", [new IntParameter("difficulty")])
		]);
		self::register("dumpmemory", [
			new Overload("default", [new FilepathParameter("path", true)])
		]);
		self::register("effect", [
			new Overload("add_enum", [
				new TargetParameter("player"),
				new EnumParameter(
					"effect",
					"Effect",
					[
						"absorption",
						"blindness",
						"conduit_power",
						"confusion",
						"damage_resistance",
						"fatal_poison",
						"fatigue",
						"fire_resistance",
						"harming",
						"haste",
						"healing",
						"health_boost",
						"hunger",
						"instant_damage",
						"instant_health",
						"invisibility",
						"jump",
						"jump_boost",
						"levitation",
						"mining_fatigue",
						"nausea",
						"night_vision",
						"poison",
						"regeneration",
						"resistance",
						"saturation",
						"slowness",
						"speed",
						"strength",
						"water_breathing",
						"weakness",
						"wither"
					]
				),
				new IntParameter("seconds", true),
				new IntParameter("amplifier", true),
				new BoolParameter("hideParticles", true)
			]),
			new Overload("add_int", [
				new TargetParameter("player"),
				new IntParameter("effect"),
				new IntParameter("seconds", true),
				new IntParameter("amplifier", true),
				new BoolParameter("hideParticles", true)
			]),
			new Overload("clear", [
				new TargetParameter("player"),
				new SubcommandParameter("clear")
			]),
		]);
		self::register("enchant", [
			new Overload("enum", [
				new TargetParameter("player"),
				new EnumParameter("enchantmentName", "Enchant", []),
				new IntParameter("level", true)
			]),
			new Overload("int", [
				new TargetParameter("player"),
				new IntParameter("enchantmentId"),
				new IntParameter("level", true)
			])
		]);
		self::register("gamemode", [
			new Overload("enum", [
				new EnumParameter("gameMode", "GameMode", ["s", "survival", "c", "creative", "a", "adventure", "view", "spectator"]),
				new TargetParameter("player", true)
			]),
			new Overload("int", [
				new IntParameter("gameMode"),
				new TargetParameter("player", true)
			]),
		]);
		self::register("gc", []);
		self::register("give", [
			new Overload("default", [
				new TargetParameter("player"),
				new ItemEnumParameter("itemName"),
				new IntParameter("amount", true),
				new IntParameter("data", true),
				new JsonParameter("components", true)
			])
		]);
		self::register("kick", [
			new Overload("default", [new TargetParameter("player"), new RawTextParameter("reason", true)])
		]);
		self::register("kill", [
			new Overload("default", [new TargetParameter("player", true)])
		]);
		self::register("list", []);
		self::register("me", [
			new Overload("default", [new RawTextParameter("action")])
		]);
		self::register("op", [
			new Overload("player", [new TargetParameter("player")]),
			new Overload("name", [new StringParameter("name")])
		]);
		self::register("pardon", [
			new Overload("name", [new StringParameter("name")])
		]);
		self::register("pardon-ip", [
			new Overload("ip", [new StringParameter("ip")])
		]);
		self::register("particle", [
			new Overload("default", [
				new ValueParameter("particle"),
				new Vector3Parameter("position"),
				new FloatParameter("xd"),
				new FloatParameter("yd"),
				new FloatParameter("zd"),
				new IntParameter("count", true),
				new IntParameter("data", true),
			])
		]);
		self::register("plugins", []);
		self::register("save-all", []);
		self::register("save-off", []);
		self::register("save-on", []);
		self::register("say", [new Overload("default", [new RawTextParameter("message")])]);
		self::register("seed", []);
		self::register("setworldspawn", [
			new Overload("position", [new Vector3Parameter("spawnPoint")]),
			new Overload("player", [new TargetParameter("player")])
		]);
		self::register("spawnpoint", [
			new Overload("default", [new TargetParameter("player", true), new Vector3Parameter("spawnPoint", true)])
		]);
		self::register("status", []);
		self::register("stop", []);
		self::register("tell", [
			new Overload("default", [new TargetParameter("target"), new MessageParameter("message")])
		]);
		self::register("time", [
			new Overload("add", [
				new SubcommandParameter("add"),
				new IntParameter("amount")
			]),
			new Overload("query", [
				new SubcommandParameter("query"),
				new EnumParameter("time", "TimeQuery", ["daytime", "gametime", "day"])
			]),
			new Overload("set_enum", [
				new SubcommandParameter("set"),
				new EnumParameter("time", "TimeSpec", ["day", "midnight", "night", "noon", "sunrise", "sunset"])
			]),
			new Overload("set_int", [
				new SubcommandParameter("set"),
				new IntParameter("amount")
			])
		]);
		self::register("tp", [
			new Overload("target", [new TargetParameter("player")]),
			new Overload("coordinates", [new Vector3Parameter("destination")]),
			new Overload("victim_to_target", [
				new TargetParameter("victim"),
				new TargetParameter("destination")
			]),
			new Overload("victim_to_coordinates", [
				new TargetParameter("victim"),
				new Vector3Parameter("destination")
			]),
		]);
		self::register("timings", [
			new Overload("reset", [new SubcommandParameter("reset")]),
			new Overload("report", [new SubcommandParameter("report")]),
			new Overload("on", [new SubcommandParameter("on")]),
			new Overload("off", [new SubcommandParameter("off")]),
			new Overload("paste", [new SubcommandParameter("paste")]),
		]);
		self::register("title", [
			new Overload("default", [
				new TargetParameter("player"),
				new EnumParameter("types", "type_values", ["title", "subtitle", "actionbar"]),
				new MessageParameter("titleText")
			]),
			new Overload("clear", [
				new TargetParameter("player"),
				new SubcommandParameter("clear")
			]),
			new Overload("reset", [
				new TargetParameter("player"),
				new SubcommandParameter("reset")
			]),
			new Overload("times", [
				new TargetParameter("player"),
				new SubcommandParameter("times"),
				new IntParameter("fadeIn"),
				new IntParameter("stay"),
				new IntParameter("fadeOut")
			])
		]);
		self::register("transferserver", [
			new Overload("default", [
				new StringParameter("address"),
				new IntParameter("port"),
			])
		]);
		self::register("version", [
			new Overload("plugin", [new StringParameter("plugin", true)])
		]);
		self::register("whitelist", [
			new Overload("add_player", [
				new SubcommandParameter("add"),
				new TargetParameter("player")
			]),
			new Overload("add_name", [
				new SubcommandParameter("add"),
				new StringParameter("name")
			]),
			new Overload("remove_player", [
				new SubcommandParameter("remove"),
				new TargetParameter("player")
			]),
			new Overload("remove_name", [
				new SubcommandParameter("remove"),
				new StringParameter("name")
			]),
			new Overload("list", [new SubcommandParameter("list")]),
			new Overload("on", [new SubcommandParameter("on")]),
			new Overload("off", [new SubcommandParameter("off")]),

		]);
	}

	/**
	 * @param string $name
	 * @param array<Overload> $overloads
	 * @return void
	 */
	public static function register(string $name, array $overloads = []): void {
		self::_registryRegister(str_replace("-", "_", $name), new VanillaCommands($name, $overloads));
	}


	/** @var array<array<CommandParameter>> */
	protected array $mappedOverloads;

	/**
	 * @param string $name
	 * @param array<Overload> $overloads
	 */
	public function __construct(protected string $name, protected array $overloads = []) {
	}

	public function getName(): string {
		return $this->name;
	}

	/**
	 * @return array<Overload>
	 */
	public function getOverloads(): array {
		return $this->overloads;
	}

	/**
	 * @return array<array<CommandParameter>>
	 */
	public function getMappedOverloads(): array {
		return $this->mappedOverloads ??= array_map(
			callback: fn(Overload $overload) => array_map(
				callback: fn(Parameter $parameter) => $parameter->encode(),
				array: $overload->getParameters()
			),
			array: $this->overloads
		);
	}

	public static function fromString(string $name): ?VanillaCommands {
		try {
			/** @var VanillaCommands|null $value */
			$value = self::_registryFromString(str_replace("-", "_", $name));
			return $value;
		} catch(InvalidArgumentException) {
			return null;
		}
	}
}