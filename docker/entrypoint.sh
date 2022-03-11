#!/usr/bin/env bash
set -eu

function main() {
    waitUntilTerminalSizeIsAvailable

    terminalCleanupOnExit true

    if ! "${@}"; then
        terminalCleanupOnExit false
    fi
}

function waitUntilTerminalSizeIsAvailable() {
    local iterations=10

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
    local enabled="${1:-true}"

    if $enabled; then
        trap "reset; clear"  EXIT
    else
        trap ""  EXIT
    fi
}

main "${@}"
