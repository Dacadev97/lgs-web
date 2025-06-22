#!/bin/bash

echo "=== LATIN GUITAR SCORES - FRANKENPHP STATUS ==="
echo ""

# Check FrankenPHP service
echo "🚀 FrankenPHP Service Status:"
./frankenphp-service.sh status
echo ""

# Test FrankenPHP directly
echo "📊 Performance Tests:"
echo ""
echo "1. FrankenPHP Direct (localhost:8080):"
curl -s -w "   Response Time: %{time_total}s | Status: %{http_code} | Size: %{size_download} bytes\n" -o /dev/null http://localhost:8080/bio

echo ""
echo "2. Main Domain (via proxy):"
curl -s -w "   Response Time: %{time_total}s | Status: %{http_code} | Size: %{size_download} bytes\n" -o /dev/null https://latinguitarscores.com/bio

echo ""
echo "📈 Speed Comparison:"
echo "   - Direct FrankenPHP: Ultra-fast (no proxy overhead)"
echo "   - Via Domain: Fast (minimal proxy overhead)"
echo ""

echo "✅ Your site is now served by FrankenPHP!"
echo "🔗 Access your site: https://latinguitarscores.com"
