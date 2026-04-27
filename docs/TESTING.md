# Testing Guide — ATP 3.0

PHPUnit 11 against an in-memory SQLite database. Every test starts on a fresh
schema thanks to the `RefreshDatabase` trait wired into `tests/TestCase.php`.

## How to run

```bash
composer test            # full suite (Unit + Feature)
composer test:unit       # Unit only — pure PHP / service tests
composer test:feature    # Feature only — Livewire + HTTP-level tests
composer test:coverage   # full suite with coverage, --min=50 gate
```

`composer test` runs `php artisan config:clear` first so the suite never picks
up a stale cached config.

## Directory layout

```
tests/
  TestCase.php            # base class, applies RefreshDatabase
  Unit/
    Services/             # service classes (PenaltyEngine, …)
    Models/               # model casting / relations / scopes
  Feature/
    Livewire/             # Livewire components grouped by domain
      Fleet/
      Admin/
    Http/                 # full route + controller integration
  Fixtures/               # shared scenario builders (PHP classes)
```

Place new tests under the matching domain folder. Mirror the source path —
`app/Livewire/Fleet/EquipmentShowForm.php` → `tests/Feature/Livewire/Fleet/
EquipmentShowFormTest.php`.

## Database

`phpunit.xml` configures `DB_CONNECTION=sqlite` and `DB_DATABASE=:memory:`. The
`RefreshDatabase` trait runs all migrations before each test method and rolls
back the transaction at teardown. Tests do not need `php artisan migrate` and
should never seed reference data manually — use factories instead.

## Factories

One factory per testable model under `database/factories/`. Identity fields
(codes, refs, serial numbers) use deterministic prefixes plus `unique()->
numerify(...)` so collisions are impossible inside a single test:

```php
'code' => 'ITM-' . $this->faker->unique()->numerify('######'),
```

`fake()` is fine for descriptive fields (names, descriptions). Never use
`fake()` in `UserFactory` outside testing — it has a production guard that
throws.

## Fixtures

`tests/Fixtures/*` holds reusable scenario builders. The PenaltyEngine
cascade tests share `PenaltyEngineFixtures::createCascadeScenario()` to wire up
the source / target equipment / counter / rule graph in one call. Keep
fixture classes small and composable; if a fixture grows past ~80 lines, split
it.

## Conventions

- One assertion focus per test. If a test has more than ~5 assertions, ask
  whether it should be split.
- Arrange / Act / Assert blocks separated by blank lines.
- Snake-case method names: `test_zero_delta_short_circuits_with_no_penalties`.
- Prefer real Eloquent models over mocks; use Mockery only for external
  services (HTTP clients, queues) that you don't want to actually invoke.
- For Livewire tests use the `Livewire::test(MyComponent::class, [...])`
  builder and `assertSet` / `call` / `assertDispatched`.

## CI

`.github/workflows/tests.yml` runs the full suite on every pull request and on
pushes to `master`. The job:

1. Checks out the repo
2. Installs PHP 8.2 with the required extensions
3. Restores Composer cache, runs `composer install`
4. Restores npm cache, runs `npm ci && npm run build` (Vite manifest is needed
   for any Blade view that uses `@vite`)
5. Copies `.env.example` to `.env`, generates `APP_KEY`, clears config
6. Runs `composer test`

If a test fails on CI but passes locally, the most common cause is a missing
factory column or a difference in cached config. Run `php artisan config:clear`
before re-running locally.

## Bugs found by tests

If a test reveals a real bug, mark it with
`$this->markTestSkipped('Bug in <thing>: <description>')` and open an issue.
Bug fixes do not belong in test PRs.
