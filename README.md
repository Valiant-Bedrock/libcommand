# libcommand
A small PocketMine-MP command library meant to simplify the process of creating commands while also enhancing the user experience.

# How to Use?

## Parameter
At the basis of the library, there is the parameter. In most instances, the parameter class accepts two properties:
- `name` - The name of the parameter. This is used in the command's `onExecute()` method as well as sent to the client.
- `optional` - Whether or not the parameter is optional. If the parameter is optional, it will not be required in the overload. When sent to the client, it will be displayed as `<name>` if not optional. Otherwise, it'll be displayed as `[name]`.

A simple raw-text parameter looks like so:
```php
$parameter = new \libcommand\parameter\types\RawTextParameter(name: "text", optional: true);
```

## Parameter Types
This is a list of all current parameter types:
### Standard
| Class Name                | Return Type      | Description                                                                                      |
|:--------------------------|:-----------------|:-------------------------------------------------------------------------------------------------|
| `CommandParameter`        | `Command`        | Accepts any registered command that has been sent to the client.                                 |
| `EquipmentSlotParameter`  | `string`         | A hardcoded client enum that can take any equipment slot (See [Equipment Slot](#Equipment Slot)) |
| `EnumParameter`           | `string`         | A list of accepted string values that can be used to filter the results of a command.            |
| `FilepathParameter`       | `string`         | Accepts a filepath (In progress / Not fully researched yet)                                      |
| `FloatParameter`          | `float`          | Accepts any float value.                                                                         |
| `IntParameter`            | `int`            | Accepts any integer value.                                                                       |
| `IntVector3Parameter`     | `Vector3<int>`   | Accepts positional coordinates and returns a integer-oriented Vector3                            |
| `JsonParameter`           | `string`         | Returns a JSON string (In progress / Not fully researched yet)                                   |
| `MessageParameter`        | `string`         | Returns a message (used for chat commands like `/tell`)                                          |
| `OperatorParameter`       | `string`         | Accepts one of the following: `"+", "-", "*", "/", "%"`                                          |
| `RawTextParameter`        | `string`         | Returns a string (No parameters can be accepted after this)                                      |
| `StringParameter`         | `string`         | Accepts any string value.                                                                        |
| `TargetParameter`         | `Player`         | Accepts a target (only supported for Players at the moment)                                      |
| `ValueParameter`          | `string`         | (Not fully researched yet)                                                                       |
| `Vector3Parameter`        | `Vector3<float>` | Accepts positional coordinates and returns a float-oriented Vector3                              |
| `WildcardIntParameter`    | `int`            | (In progress / Not fully researched yet)                                                         |
| `WildcardTargetParameter` | `Player`         | (In progress / Not fully researched yet)                                                         |
### Custom
| Class Name            | Return Type | Description                                                               |
|:----------------------|:------------|:--------------------------------------------------------------------------|
| `BoolParameter`       | `bool`      | An Enum parameter that can be `true`, `false`, `1`, or `0`                |
| `SubcommandParameter` | `string`    | A parameter that allows for nothing but the subcommand name to be passed. |
| `BlockEnumParameter`  | `Block`     | An Enum parameter that displays a list of blocks to the client            |
| `ItemEnumParameter`   | `Item`      | An Enum parameter that displays a list of items to the client             |


## `Overload`
In the terms of commands, an overload is a set of parameters that a command can take. An overload is defined by an array of `Parameter` objects. Here is how a simple overload class looks:

```php
$overload = new \libcommand\Overload(
    // An internal name used to track the overload
    name: "test",
    // A list of parameters
    parameters: []
);

```

### `Command`
Finally, to tie these features together, it uses the `Command` class. This class is meant to be extended to create new commands. The class extends `\pocketmine\command\Command` and accepts
one more parameter, `$overloads`, which is an array of `Overload` objects, though you can use the methods `addOverload(Overload $overload): void` and `addOverloads(Overload ...$overloads)` to add them separately from the constructor.

To limit the access to the command, you can use the `ConsoleCommand` class or `PlayerCommand` class. This will verify the command sender before executing the command.

## Simple Example
Below is a simple example on how to create and register commands.

## Command Class

```php
class SimpleCommand extends \libcommand\Command {
    public function __construct() {
        parent::__construct(
            name: "simple",
            description: "Simple command description",
            usageMessage: "Usage: /simple <test_int> <test_raw>",
            aliases: ["s"],
            overloads: [
                new \libcommand\Overload(name: "default", parameters: [
                    new \libcommand\IntParameter(name: "test_int", description: "Test integer parameter", optional: false),
                    new \libcommand\RawTextParameter(name: "test_raw", description: "Test raw text parameter", optional: true)
                ])
            ]
        );
    }
    public function onExecute(\pocketmine\command\CommandSender $sender, array $arguments) : bool|string {
        $int = $arguments["test_int"];
        $raw = $arguments["test_raw"] ?? "fallback raw text";
        // Returning a string will be sent to the sender as a message
        return "Simple command executed with $int and $raw";
    }

}
```
## Registration

```php
class SimplePlugin extends \pocketmine\plugin\PluginBase {

    protected function onEnable(): void {
    
        // Registering `LibCommandBase` allows for client-sided rendering to be done
        \libcommand\LibCommandBase::register(plugin: $this);
        $this->getServer()->getCommandMap()->register(
            fallbackPrefix: $this->getName(),
            command: new SimpleCommand()
        );
    }

}
```

## Types
These types are associated with the various parameters.

### Equipment Slot
- `slot.armor`
- `slot.armor.head`
- `slot.armor.chest`
- `slot.armor.legs`
- `slot.armor.feet`
- `slot.chest`
- `slot.enderchest`
- `slot.equippable`
- `slot.hotbar`
- `slot.inventory`
- `slot.saddle`
- `slot.weapon.mainhand`
- `slot.weapon.offhand`



## Roadmap
- [ ] Generate usage messages based off of overloads
- [ ] Introduce subcommand system