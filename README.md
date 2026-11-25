# Brain Games CLI

[![CI](https://github.com/AlexeyGorc/brain-games-cli/actions/workflows/ci.yml/badge.svg)](https://github.com/AlexeyGorc/brain-games-cli/actions/workflows/ci.yml)
[![Maintainability](https://qlty.sh/gh/AlexeyGorc/projects/brain-games-cli/maintainability.svg)](https://qlty.sh/gh/AlexeyGorc/projects/brain-games-cli)
![PHP](https://img.shields.io/badge/PHP-8.3%20%7C%208.4%20%7C%208.5-777BB4?logo=php&logoColor=white)
![PHPStan](https://img.shields.io/badge/PHPStan-level%20max-brightgreen)
![License](https://img.shields.io/badge/license-MIT-blue)

Five brain-training mini games for the terminal, written in modern PHP.
Answer three questions in a row correctly to win.

![Demo](docs/demo.gif)

## Games

| Game | Command | You answer |
| --- | --- | --- |
| Even number | `brain-even` | `yes` if the number is even, otherwise `no` |
| Calculator | `brain-calc` | the result of `12 - 38` |
| Greatest common divisor | `brain-gcd` | the GCD of `12 18` |
| Arithmetic progression | `brain-progression` | the missing number in `3 7 .. 15 19` |
| Prime number | `brain-prime` | `yes` if the number is prime, otherwise `no` |

## Quick start

Requires PHP 8.3+ and Composer.

    git clone https://github.com/AlexeyGorc/brain-games-cli.git
    cd brain-games-cli
    composer install
    ./bin/brain-games

`brain-games` opens a menu. To start a game directly:

    ./bin/brain-games calc   # or ./bin/brain-calc

Answers are case-insensitive. Press Ctrl+D at any prompt to quit.

| Exit code | Meaning |
| --- | --- |
| 0 | You won (or left the menu) |
| 1 | Wrong answer |
| 2 | Unknown game |
| 130 | Input closed (Ctrl+D) |

## Development

    make check      # composer validate + PHPCS (PSR-12) + PHPStan (max) + PHPUnit
    make test       # tests only
    make lint-fix   # auto-fix code style

CI runs the same checks on PHP 8.3, 8.4 and 8.5 for every push to `main` and every pull request.

## Architecture

    bin/brain-games ──► Application ──► Menu ──► GameRegistry
                            │                        │
                            ▼                        ▼
                         Engine  ◄──── GameInterface (Even, Calc, Gcd, Progression, Prime)
                            │
                            ▼
                       IoInterface (ConsoleIo / FakeIo in tests)

- **Games** implement `GameInterface` and return an immutable `Round` (question + answer).
- **Engine** runs the rounds and knows nothing about the terminal: it talks to `IoInterface`.
- **Randomness** is injected as `Random\Randomizer`, so tests use a fixed seed
  and check 200 generated rounds per game against an independent oracle.

### Adding a game

1. Create `src/Game/YourGame.php` implementing `GameInterface`.
2. Register it in `GameRegistry::default()`. It appears in the menu automatically.
3. Optionally add `bin/brain-yourgame` and list it in `composer.json` → `bin`.

## License

[MIT](LICENSE)
