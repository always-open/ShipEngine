#!/bin/bash

BUILD=false
FRESH=false
DOWN=false
SSH=false
XDEBUG=false

while [[ $# -gt 0 ]]; do
    case "$1" in
    --build|-b)
        BUILD=true
        shift
        ;;
    --fresh|-f)
        FRESH=true
        shift
        ;;
    --down|-d)
        DOWN=true
        shift
        ;;
    --ssh|-s)
        SSH=true
        shift
        ;;
    --xdebug|-x)
        XDEBUG=true
        shift
        ;;
    --)
        shift
        break
        ;;
    *)
        echo "Invalid option: $1"
        exit 1 ## Could be optional.
        ;;
    esac
done

if $DOWN; then
    docker compose down
else
    DEBUG_ENV=""
    if $XDEBUG; then
        DEBUG_ENV="WITH_XDEBUG=true"
    fi
    if $XDEBUG || $BUILD; then
        eval "$DEBUG_ENV docker compose build"
    fi

    docker compose up -d

    if $FRESH; then
        docker compose exec shipengine-app composer install
        docker compose exec shipengine-app composer fresh
    fi

    if $SSH; then
        docker exec -it shipengine-app /bin/bash
    fi
fi
