#!/usr/bin/env bash
set -euo pipefail

# Laravel optimize + cache script.
# Run from any cwd; resolves project root via this file's location.

cd "$(dirname "$0")/.."

PHP="${PHP:-php}"
COMPOSER="${COMPOSER:-composer}"
ARTISAN=("$PHP" artisan)

step() { printf '\n\033[1;34m==>\033[0m %s\n' "$*"; }

step "Clearing stale caches"
"${ARTISAN[@]}" config:clear
"${ARTISAN[@]}" route:clear
"${ARTISAN[@]}" view:clear
"${ARTISAN[@]}" cache:clear || true
"${ARTISAN[@]}" event:clear || true

step "Dumping optimized autoloader"
"$COMPOSER" dump-autoload --optimize --no-interaction

step "Caching config, routes, views, events"
"${ARTISAN[@]}" config:cache
"${ARTISAN[@]}" route:cache
"${ARTISAN[@]}" view:cache
"${ARTISAN[@]}" event:cache

step "Running aggregate optimize"
"${ARTISAN[@]}" optimize

step "Done."
