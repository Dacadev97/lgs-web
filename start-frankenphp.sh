#!/bin/bash

# Navigate to the Laravel project directory
cd /home/latingu2/domains/latinguitarscores.com/lgs-web

# Set environment variables
export PATH="/home/latingu2/bin:$PATH"

# Check if .env file exists
if [ ! -f .env ]; then
    echo "Error: .env file not found"
    exit 1
fi

# Check if FrankenPHP is available
if ! command -v frankenphp &> /dev/null; then
    echo "Error: FrankenPHP not found in PATH"
    exit 1
fi

# Start FrankenPHP with the Caddyfile
echo "Starting FrankenPHP server..."
echo "Your Laravel app will be available at: http://latinguitarscores.com:8080"
echo "Press Ctrl+C to stop the server"

frankenphp run --config Caddyfile
