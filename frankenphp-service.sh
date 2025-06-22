#!/bin/bash

# FrankenPHP Service Script
PIDFILE="/home/latingu2/frankenphp.pid"
LOGFILE="/home/latingu2/domains/latinguitarscores.com/logs/frankenphp-service.log"
WORKDIR="/home/latingu2/domains/latinguitarscores.com/lgs-web"
FRANKENPHP="/home/latingu2/bin/frankenphp"

start() {
    if [ -f "$PIDFILE" ] && kill -0 $(cat "$PIDFILE") 2>/dev/null; then
        echo "FrankenPHP is already running (PID: $(cat $PIDFILE))"
        return 1
    fi
    
    echo "Starting FrankenPHP..."
    cd "$WORKDIR"
    nohup "$FRANKENPHP" run --config Caddyfile > "$LOGFILE" 2>&1 &
    echo $! > "$PIDFILE"
    echo "FrankenPHP started with PID: $(cat $PIDFILE)"
    echo "Log file: $LOGFILE"
}

stop() {
    if [ ! -f "$PIDFILE" ]; then
        echo "FrankenPHP is not running (no PID file found)"
        return 1
    fi
    
    PID=$(cat "$PIDFILE")
    if ! kill -0 "$PID" 2>/dev/null; then
        echo "FrankenPHP is not running (PID $PID not found)"
        rm -f "$PIDFILE"
        return 1
    fi
    
    echo "Stopping FrankenPHP (PID: $PID)..."
    kill "$PID"
    
    # Wait for process to stop
    for i in {1..10}; do
        if ! kill -0 "$PID" 2>/dev/null; then
            rm -f "$PIDFILE"
            echo "FrankenPHP stopped"
            return 0
        fi
        sleep 1
    done
    
    # Force kill if still running
    echo "Force killing FrankenPHP..."
    kill -9 "$PID" 2>/dev/null
    rm -f "$PIDFILE"
    echo "FrankenPHP force killed"
}

status() {
    if [ -f "$PIDFILE" ] && kill -0 $(cat "$PIDFILE") 2>/dev/null; then
        echo "FrankenPHP is running (PID: $(cat $PIDFILE))"
        return 0
    else
        echo "FrankenPHP is not running"
        return 1
    fi
}

restart() {
    stop
    sleep 2
    start
}

case "$1" in
    start)
        start
        ;;
    stop)
        stop
        ;;
    restart)
        restart
        ;;
    status)
        status
        ;;
    *)
        echo "Usage: $0 {start|stop|restart|status}"
        exit 1
        ;;
esac
