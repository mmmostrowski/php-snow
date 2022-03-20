#!/usr/bin/env bash
set -eu

function main() {
    if [[ "${1:-}" == "devbox" ]]; then
        bash
        return 0
    fi

    installVendorFolderToHost

    waitUntilTerminalSizeIsAvailable 3s

    if [[ "${PHP_SNOW_APP_MODE:-}" != "develop" ]]; then
        terminalCleanupOnExit true
    fi

    if ! "php" "snow.php" "${@}"; then
        terminalCleanupOnExit false
    fi
}

function installVendorFolderToHost()
{
    if [[ -e /app/vendor/ ]] && cmp /app/vendor/composer/installed.json /app-vendor/composer/installed.json; then
        return
    fi

    rm -rf /app/vendor/
    cp -rf /app-vendor/ /app/vendor/
}

function waitUntilTerminalSizeIsAvailable() {
    local waitSec="${1%s}"

    local iterations=$(( waitSec * 2 ))
    while (( --iterations >= 0 )); do
        local cols
        cols="$( tput cols )"

        if (( cols != 0 )) && (( cols != 80 )); then
            break
        fi

        sleep 0.5;
    done
}

function terminalCleanupOnExit() {
    local trapEnabled="${1:-true}"

    if $trapEnabled; then
        trap "reset; clear"  EXIT
    else
        trap ""  EXIT
    fi
}

main "${@}"
