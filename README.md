
## 🦖 Pequeñosaurios - Ecommerce de Ropa Infantil

**Pequeñosaurios** es una tienda en línea dedicada a la venta de ropa infantil para niños de 0 meses a 8 años.  
Este proyecto está desarrollado en **Laravel 10**, con un diseño en tonos pastel (rosa y verde), y una experiencia responsiva pensada especialmente para padres jóvenes.

---

## 💰 Valor de Desarrollo

Este sistema ha sido desarrollado íntegramente por el participante como proyecto propio.  
En caso de ser comercializado, el valor estimado de venta del sistema completo sería de:  
**USD $450**

---

## 🧑‍💻 Lenguaje Utilizado

- **Lenguaje de Programación:** PHP 8.1  
- **Framework:** Laravel 10

Laravel fue elegido por su arquitectura moderna, herramientas integradas, comunidad activa y facilidad para desarrollar aplicaciones web seguras y escalables.

---

## 🗃️ Manejador de Base de Datos

- **Gestor de Base de Datos:** MySQL 10.4 (MariaDB compatible)

Seleccionado por su eficiencia, compatibilidad con Laravel y su amplia adopción en entornos de desarrollo y producción.

---

## 🛠️ Entorno de Desarrollo

- **Editor de código:** Visual Studio Code (VSCode)  
- **Servidor local:** XAMPP 8.2.4  
- **Gestión de dependencias:** Composer  
- **Control de versiones:** Git  
- **Base de datos:** PhpMyAdmin + MySQL  
- **Navegador para pruebas:** Google Chrome  
- **Sistema operativo:** Windows 11

---

## 📋 Consideraciones del Desarrollo

- Panel de administración completo para la gestión de usuarios, productos, categorías, pedidos y más.
- Registro e inicio de sesión de clientes con sistema de autenticación seguro.
- Formularios validados en frontend y backend con operaciones CRUD completas.
- Navegación ordenada, coherente y con iconografía unificada.
- Diseño responsivo optimizado para dispositivos móviles.
- Base de datos documentada con:
  - Llaves primarias y foráneas.
  - Índices y tipos de datos.
  - Reglas de integridad y normalización.
  - Link Diagrama Entidad-Relación: [https://dbdiagram.io/d/Pequenosaurios-685978c8f039ec6d3680d3bf](https://dbdiagram.io/d/Pequenosaurios-685978c8f039ec6d3680d3bf)
  - Link del Diccionario de la Base de Datos: [https://docs.google.com/document/d/1xEGtLA6sPhq8S8Bi0NMpX2cPWatyW1Ml/edit?usp=sharing&ouid=114283021288509216231&rtpof=true&sd=true](https://docs.google.com/document/d/1xEGtLA6sPhq8S8Bi0NMpX2cPWatyW1Ml/edit?usp=sharing&ouid=114283021288509216231&rtpof=true&sd=true)

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
   npm run dev
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

# 🗂️ Documentación de Módulos

## 🛠️ Panel de Administración

1. **Dashboard (`admin.dashboard`)**  
   Muestra un resumen general del sistema: estadísticas de ventas, inventario, usuarios y métricas clave.  
   **Roles con acceso:** `admin`, `soporte`, `inventario`, `ventas`.

2. **Usuarios (`admin.users`)**  
   Gestión de usuarios del sistema: crear, editar, eliminar y asignar roles.  
   **Acceso exclusivo para:** `admin`.

3. **Mensajes (`admin.messages`)**  
   Visualización y respuesta de mensajes enviados desde el formulario de contacto del cliente.  
   **Roles con acceso:** `admin`, `soporte`.

4. **Productos (`admin.products`)**  
   Gestión del inventario: productos, categorías, tallas, stock y precios.  
   **Roles con acceso:** `admin`, `inventario`.

5. **Métodos de Pago (`admin.payments`)**  
   Configuración y administración de los métodos de pago disponibles en la tienda.  
   **Roles con acceso:** `admin`, `ventas`.

6. **Facturas (`admin.invoice`)**  
   Consulta de órdenes confirmadas y facturas generadas por los pedidos.  
   **Roles con acceso:** `admin`, `ventas`.

7. **Opiniones (`admin.reviews`)**  
   Moderación de reseñas realizadas por los clientes sobre productos comprados.  
   **Roles con acceso:** `admin`, `soporte`.

8. **Logs (`admin.logs`)**  
   Registro de actividades y eventos del sistema: accesos, errores, modificaciones.  
   **Acceso exclusivo para:** `admin`.

---

## 🛍️ Vista del Cliente

1. **Landing (`/`)**  
   Página principal pública del sitio. Presenta la marca, misión y llamados a la acción para explorar la tienda.

2. **Store (Tienda)**  
   Página general de productos disponibles.  
   Permite aplicar filtros por categoría, talla y nombre del producto.

3. **Product (Producto)**  
   Página individual con descripción detallada, imagen, tallas disponibles, precio y botón para agregar al carrito.

4. **Cart (Carrito)**  
   Lista de productos añadidos. Permite modificar cantidades, eliminar artículos y proceder al checkout.

5. **Checkout**  
   Proceso final para completar la compra: selección de método de pago, dirección y confirmación del pedido.

6. **Reviews (Reseñas)**  
   Sección donde los clientes pueden dejar opiniones sobre los productos adquiridos.

---

## 🔐 Autenticación y Acceso

1. **Login (Inicio de sesión)**  
   Acceso para usuarios registrados (clientes o administradores). Valida credenciales y redirige según el rol.

2. **Registro (Crear cuenta)**  
   Formulario para que los clientes puedan registrarse en la tienda usando su nombre, correo y contraseña.

3. **¿Olvidaste tu contraseña? (`/forgot-password`)**  
   Permite recuperar el acceso mediante el envío de un correo electrónico con enlace para restablecer contraseña.

---

📌 **Nota:** Cada módulo cuenta con control de acceso basado en roles definidos en el sistema para garantizar la seguridad y la experiencia adecuada para cada tipo de usuario.

