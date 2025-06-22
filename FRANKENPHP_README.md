# FrankenPHP Setup para Latin Guitar Scores

## ¿Qué es FrankenPHP?
FrankenPHP es un servidor web moderno de alto rendimiento escrito en Go que ejecuta aplicaciones PHP. Ofrece:
- Workers persistentes para mejor rendimiento
- Compilación JIT de Go
- Mejor uso de memoria
- HTTP/2 y HTTP/3 nativo
- Compresión automática

## Archivos instalados

### Binario principal
- `/home/latingu2/bin/frankenphp` - El binario de FrankenPHP

### Configuración
- `Caddyfile` - Configuración del servidor
- `frankenphp-service.sh` - Script de servicio para gestionar FrankenPHP

### Proxy (opcional)
- `/home/latingu2/domains/latinguitarscores.com/public_html/frankenphp-proxy.php` - Proxy PHP para acceso externo

## Comandos principales

### Gestión del servicio
```bash
# Iniciar FrankenPHP
./frankenphp-service.sh start

# Detener FrankenPHP
./frankenphp-service.sh stop

# Reiniciar FrankenPHP
./frankenphp-service.sh restart

# Ver estado
./frankenphp-service.sh status
```

## Estado actual
✅ FrankenPHP instalado y funcionando
✅ Servicio iniciado en puerto 8080  
✅ Logs configurados
✅ Script de gestión creado
✅ Proxy PHP disponible
