#!/usr/bin/env bash
set -eu

SCRIPT_DIR="$( cd -- "$( dirname -- "${BASH_SOURCE[0]}" )" &> /dev/null && pwd )"

function main() {
    if ! dockerBuild > /dev/null 2> /dev/null; then
        dockerBuild
        return 1
    fi

    if [[ -s "${1:-}" ]]; then
        local customSceneFile="${1}"
        shift 1
        dockerRun "--volume=${customSceneFile}:/app/scene.txt" php-snow "${@}"
    else
        dockerRun php-snow "${@}"
    fi
}

function dockerBuild() {
    (
        cd "${SCRIPT_DIR}"

        docker build -t php-snow .
    )
}

function dockerRun() {
    (
        cd "${SCRIPT_DIR}"
        docker run "$(dockerTTI)" --rm --name php-snow --env PHP_SNOW_APP_MODE "${@}"
    )
}

function dockerTTI() {
    if [[ -t 0 ]]; then
        echo "-it"
    else
        echo "-i"
    fi
}

main "${@}"
