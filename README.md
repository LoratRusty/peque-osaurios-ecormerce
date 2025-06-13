
# Pequeñosaurios - Ecommerce de Ropa Infantil

Pequeñosaurios es una tienda en línea dedicada a la venta de ropa infantil para niños de 0 meses a 8 años. Este proyecto está desarrollado en Laravel con un diseño pastel (rosa y verde) y una experiencia responsiva ideal para padres jóvenes.

---

## 🚀 Instalación Rápida

### 📋 Requisitos previos

- PHP 8.1+
- MySQL / MariaDB
- Node.js 16+
- Composer 2.0+

---

### ⚙️ Pasos de instalación

1. **Configuración inicial**:
   ```bash
   -unzip pequenosaurios.zip
   -Colocar la carpeta del proyecto dentro de htdocs
   -cd pequenosaurios
   ```

   Editar el archivo `.env` con los siguientes valores:

   ```ini
   APP_NAME=Pequeñosaurios
   APP_ENV=local
   APP_KEY=base64:8gNvE8vbTSdGssiRmk5sMFAmFAg1LdgkRA83kopq9oY=
   APP_DEBUG=true
   APP_URL=http://localhost/pequenosaurios/public/

   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=pequenoasurios
   DB_USERNAME=root
   DB_PASSWORD=
   ```

2. **Importar la base de datos**:
   ```bash
   Crear la base de datos "pequenoasurios"
   Ejecutar el Script en database/database.sql
   ```

3. **Instalar dependencias**:
   ```bash
   composer install
   npm install
   npm run build
   ```

4. **Iniciar el servidor**:
   ```bash
   npm run serve
   ```

   Acceder desde: [http://localhost/pequenosaurios/public/](http://localhost/pequenosaurios/public/)

---

## 🔐 Credenciales de Acceso

### Administrador
- **Usuario:** `admin@pequesaurios.com`
- **Contraseña:** `America2011.`

### Cliente Demo
- **Usuario:** `cliente@gmail.com`
- **Contraseña:** `America2011.`

---

## ⚠️ Solución de Problemas Comunes

### ❌ Error en la URL base

- Asegúrate de que `APP_URL` en el archivo `.env` coincida con tu URL real.

### ❌ Problemas con la base de datos

- Verifica que el servicio de MySQL esté en ejecución.
- Asegúrate de que el usuario `root` no requiere contraseña (o ajústalo en `.env`).
- La base de datos la puedes encotnrar en database/database.sql

### ❌ Problemas con npm

- Si ocurren errores al compilar assets:
  ```bash
  npm cache clean --force
  npm install
  npm run build
  ```
---

## 🌟 Características Técnicas

- Entorno de desarrollo local optimizado
- Debug habilitado (`APP_DEBUG=true`)
- Configuración SMTP con Mailpit (puerto 1025)
- Soporte para Vue.js mediante Vite
- Sesiones almacenadas en archivos (`file`)

---

## 📌 Notas Importantes

- Configuración ideal para XAMPP/WAMP (usuario root sin contraseña)

---
