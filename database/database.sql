/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 100432 (10.4.32-MariaDB)
 Source Host           : localhost:3306
 Source Schema         : pequenoasurios

 Target Server Type    : MySQL
 Target Server Version : 100432 (10.4.32-MariaDB)
 File Encoding         : 65001

 Date: 14/06/2025 19:48:42
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for cart_items
-- ----------------------------
DROP TABLE IF EXISTS `cart_items`;
CREATE TABLE `cart_items`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `cart_id` int NOT NULL,
  `product_id` int NOT NULL,
  `cantidad` int NOT NULL,
  `precio_unitario` decimal(10, 2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp ON UPDATE CURRENT_TIMESTAMP,
  `size_id` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `fk_cart_items_cart`(`cart_id` ASC) USING BTREE,
  INDEX `fk_cart_items_product`(`product_id` ASC) USING BTREE,
  INDEX `fk_cart_items_size`(`size_id` ASC) USING BTREE,
  CONSTRAINT `cart_items_ibfk_1` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `fk_cart_items_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_cart_items_size` FOREIGN KEY (`size_id`) REFERENCES `sizes` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 37 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cart_items
-- ----------------------------
INSERT INTO `cart_items` VALUES (26, 12, 14, 1, 34.99, '2025-06-13 10:48:26', '2025-06-13 10:48:26', 18);

-- ----------------------------
-- Table structure for carts
-- ----------------------------
DROP TABLE IF EXISTS `carts`;
CREATE TABLE `carts`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `status` enum('pendiente','pagado','cancelado') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pendiente',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_user_status`(`user_id` ASC, `status` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 19 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of carts
-- ----------------------------
INSERT INTO `carts` VALUES (2, 5, 'pagado', '2025-06-12 11:58:13', '2025-06-12 12:33:26');
INSERT INTO `carts` VALUES (3, 5, 'pagado', '2025-06-12 12:33:28', '2025-06-12 12:34:49');
INSERT INTO `carts` VALUES (4, 5, 'pagado', '2025-06-12 12:34:53', '2025-06-12 12:41:55');
INSERT INTO `carts` VALUES (5, 5, 'pagado', '2025-06-12 12:41:59', '2025-06-12 12:44:52');
INSERT INTO `carts` VALUES (6, 5, 'pagado', '2025-06-12 12:59:34', '2025-06-12 13:44:14');
INSERT INTO `carts` VALUES (7, 5, 'pagado', '2025-06-12 13:48:38', '2025-06-12 13:49:14');
INSERT INTO `carts` VALUES (8, 5, 'pagado', '2025-06-12 14:01:52', '2025-06-12 14:30:54');
INSERT INTO `carts` VALUES (9, 10, 'pagado', '2025-06-12 15:41:30', '2025-06-12 16:09:37');
INSERT INTO `carts` VALUES (10, 10, 'pagado', '2025-06-12 16:33:55', '2025-06-12 17:48:36');
INSERT INTO `carts` VALUES (11, 10, 'pagado', '2025-06-13 01:29:47', '2025-06-13 18:41:15');
INSERT INTO `carts` VALUES (12, 18, 'pendiente', '2025-06-13 10:47:06', '2025-06-13 10:47:06');
INSERT INTO `carts` VALUES (13, 5, 'pagado', '2025-06-13 18:39:24', '2025-06-13 19:43:32');
INSERT INTO `carts` VALUES (14, 5, 'pagado', '2025-06-14 16:44:36', '2025-06-14 19:05:43');
INSERT INTO `carts` VALUES (15, 5, 'pagado', '2025-06-14 19:06:42', '2025-06-14 19:24:11');
INSERT INTO `carts` VALUES (16, 5, 'pagado', '2025-06-14 19:24:22', '2025-06-14 19:25:43');
INSERT INTO `carts` VALUES (17, 5, 'pagado', '2025-06-14 19:31:39', '2025-06-14 19:31:56');
INSERT INTO `carts` VALUES (18, 5, 'pendiente', '2025-06-14 19:41:07', '2025-06-14 19:41:07');

-- ----------------------------
-- Table structure for categories
-- ----------------------------
DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 16 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of categories
-- ----------------------------
INSERT INTO `categories` VALUES (6, 'Camisetas', NULL, '2025-06-12 16:58:19', '2025-06-12 16:58:19');
INSERT INTO `categories` VALUES (7, 'Pantalones', NULL, '2025-06-12 16:58:19', '2025-06-12 16:58:19');
INSERT INTO `categories` VALUES (8, 'Vestidos', NULL, '2025-06-12 16:58:19', '2025-06-12 16:58:19');
INSERT INTO `categories` VALUES (9, 'Chaquetas', NULL, '2025-06-12 16:58:19', '2025-06-12 16:58:19');
INSERT INTO `categories` VALUES (10, 'Pijamas', NULL, '2025-06-12 16:58:19', '2025-06-12 16:58:19');
INSERT INTO `categories` VALUES (11, 'Ropa interior', NULL, '2025-06-12 16:58:19', '2025-06-12 16:58:19');
INSERT INTO `categories` VALUES (12, 'Conjuntos', NULL, '2025-06-12 16:58:19', '2025-06-12 16:58:19');
INSERT INTO `categories` VALUES (13, 'Ropa deportiva', NULL, '2025-06-12 16:58:19', '2025-06-12 16:58:19');
INSERT INTO `categories` VALUES (14, 'Accesorios', NULL, '2025-06-12 16:58:19', '2025-06-12 16:58:19');
INSERT INTO `categories` VALUES (15, 'Calzado', NULL, '2025-06-12 16:58:19', '2025-06-12 16:58:19');

-- ----------------------------
-- Table structure for failed_jobs
-- ----------------------------
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `failed_jobs_uuid_unique`(`uuid` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of failed_jobs
-- ----------------------------

-- ----------------------------
-- Table structure for logs
-- ----------------------------
DROP TABLE IF EXISTS `logs`;
CREATE TABLE `logs`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `accion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `user_id`(`user_id` ASC) USING BTREE,
  INDEX `idx_fecha`(`fecha` ASC) USING BTREE,
  CONSTRAINT `logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 264 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of logs
-- ----------------------------
INSERT INTO `logs` VALUES (1, 1, 'Mensaje enviado', '2025-06-10 08:40:27');
INSERT INTO `logs` VALUES (2, 5, 'El usuario ha repondido el mensaje ID: 3', '2025-06-10 08:43:06');
INSERT INTO `logs` VALUES (3, 1, 'El usuario ha repondido el mensaje al correo: xdarkvaderxx@gmail.com', '2025-06-10 08:43:38');
INSERT INTO `logs` VALUES (4, 5, 'El usuario ha repondido el mensaje al correo: xdarkvaderxx@gmail.com', '2025-06-10 11:52:38');
INSERT INTO `logs` VALUES (6, 1, 'El usuario ha repondido el mensaje al correo: nayerkatric@gmail.com', '2025-06-11 00:55:50');
INSERT INTO `logs` VALUES (7, 1, 'El usuario ha repondido el mensaje al correo: nayerkatric@gmail.com', '2025-06-11 00:55:57');
INSERT INTO `logs` VALUES (8, 1, 'El usuario ha repondido el mensaje al correo: nayerkatric@gmail.com', '2025-06-11 00:57:55');
INSERT INTO `logs` VALUES (9, 1, 'El usuario ha repondido el mensaje al correo: nayerkatric@gmail.com', '2025-06-11 00:58:42');
INSERT INTO `logs` VALUES (10, 1, 'El usuario ha repondido el mensaje al correo: nayerkatric@gmail.com', '2025-06-11 00:58:49');
INSERT INTO `logs` VALUES (11, 1, 'El usuario ha repondido el mensaje al correo: xdarkvaderxx@gmail.com', '2025-06-11 01:01:06');
INSERT INTO `logs` VALUES (12, 1, 'El usuario ha repondido el mensaje al correo: xdarkvaderxx@gmail.com', '2025-06-11 07:39:22');
INSERT INTO `logs` VALUES (13, 1, 'El usuario ha repondido el mensaje al correo: xdarkvaderxx@gmail.com', '2025-06-11 17:33:53');
INSERT INTO `logs` VALUES (14, 1, 'El usuario accedió al listado de usuarios.', '2025-06-12 16:52:04');
INSERT INTO `logs` VALUES (15, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-12 16:52:06');
INSERT INTO `logs` VALUES (16, 1, 'El usuario ha visualizado el listado de métodos de pago.', '2025-06-12 16:52:06');
INSERT INTO `logs` VALUES (17, 1, 'El usuario ha visualizado el listado de métodos de pago.', '2025-06-12 16:52:13');
INSERT INTO `logs` VALUES (18, 1, 'El usuario ha ingresado al formulario para editar el método de pago ID: 5', '2025-06-12 16:52:14');
INSERT INTO `logs` VALUES (19, 1, 'El usuario ha actualizado el método de pago ID: 5', '2025-06-12 16:52:15');
INSERT INTO `logs` VALUES (20, 1, 'El usuario ha visualizado el listado de métodos de pago.', '2025-06-12 16:52:15');
INSERT INTO `logs` VALUES (21, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-12 16:52:17');
INSERT INTO `logs` VALUES (22, 1, 'El usuario ha ingresado al formulario para editar el producto ID: 10', '2025-06-12 16:52:19');
INSERT INTO `logs` VALUES (23, 1, 'El usuario ha actualizado el producto ID: 10', '2025-06-12 16:52:20');
INSERT INTO `logs` VALUES (24, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-12 16:52:21');
INSERT INTO `logs` VALUES (25, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-12 16:53:06');
INSERT INTO `logs` VALUES (26, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-12 16:53:12');
INSERT INTO `logs` VALUES (27, 1, 'El usuario ha ingresado al formulario para crear un nuevo producto.', '2025-06-12 16:53:14');
INSERT INTO `logs` VALUES (28, 1, 'El usuario ha ingresado al formulario para crear un nuevo producto.', '2025-06-12 16:58:30');
INSERT INTO `logs` VALUES (29, 1, 'El usuario ha visualizado el listado de métodos de pago.', '2025-06-12 16:58:35');
INSERT INTO `logs` VALUES (30, 1, 'El usuario accedió al listado de usuarios.', '2025-06-12 16:58:39');
INSERT INTO `logs` VALUES (31, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-12 16:58:40');
INSERT INTO `logs` VALUES (32, 1, 'El usuario ha accedido al listado de tallas.', '2025-06-12 16:58:41');
INSERT INTO `logs` VALUES (33, 1, 'El usuario ha ingresado al formulario para editar el producto ID: 10', '2025-06-12 16:58:45');
INSERT INTO `logs` VALUES (34, 1, 'El usuario ha ingresado al formulario para editar el producto ID: 10', '2025-06-12 16:59:07');
INSERT INTO `logs` VALUES (35, 1, 'El usuario ha ingresado al formulario para editar el producto ID: 10', '2025-06-12 17:01:24');
INSERT INTO `logs` VALUES (36, 1, 'El usuario ha actualizado el producto ID: 10', '2025-06-12 17:02:17');
INSERT INTO `logs` VALUES (37, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-12 17:02:17');
INSERT INTO `logs` VALUES (38, 1, 'El usuario ha ingresado al formulario para editar el producto ID: 10', '2025-06-12 17:02:22');
INSERT INTO `logs` VALUES (39, 1, 'El usuario ha actualizado el producto ID: 10', '2025-06-12 17:02:30');
INSERT INTO `logs` VALUES (40, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-12 17:02:30');
INSERT INTO `logs` VALUES (41, 1, 'El usuario ha ingresado al formulario para editar el producto ID: 10', '2025-06-12 17:02:34');
INSERT INTO `logs` VALUES (42, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-12 17:02:38');
INSERT INTO `logs` VALUES (43, 1, 'El usuario ha ingresado al formulario para crear un nuevo producto.', '2025-06-12 17:02:49');
INSERT INTO `logs` VALUES (44, 1, 'El usuario ha ingresado al formulario para crear un nuevo producto.', '2025-06-12 17:04:04');
INSERT INTO `logs` VALUES (45, 1, 'El usuario ha ingresado al formulario para crear un nuevo producto.', '2025-06-12 17:04:11');
INSERT INTO `logs` VALUES (46, 1, 'El usuario ha creado un nuevo producto: Vestido Primavera', '2025-06-12 17:04:38');
INSERT INTO `logs` VALUES (47, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-12 17:04:38');
INSERT INTO `logs` VALUES (48, 1, 'El usuario ha ingresado al formulario para crear un nuevo producto.', '2025-06-12 17:04:45');
INSERT INTO `logs` VALUES (49, 1, 'El usuario ha ingresado al formulario para editar el producto ID: 11', '2025-06-12 17:04:48');
INSERT INTO `logs` VALUES (50, 1, 'El usuario ha ingresado al formulario para editar el producto ID: 11', '2025-06-12 17:04:59');
INSERT INTO `logs` VALUES (51, 1, 'El usuario ha ingresado al formulario para crear un nuevo producto.', '2025-06-12 17:05:05');
INSERT INTO `logs` VALUES (52, 1, 'El usuario ha ingresado al formulario para editar el producto ID: 11', '2025-06-12 17:05:08');
INSERT INTO `logs` VALUES (53, 1, 'El usuario ha actualizado el producto ID: 11', '2025-06-12 17:05:11');
INSERT INTO `logs` VALUES (54, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-12 17:05:12');
INSERT INTO `logs` VALUES (55, 1, 'El usuario ha ingresado al formulario para editar el producto ID: 11', '2025-06-12 17:05:22');
INSERT INTO `logs` VALUES (56, 1, 'El usuario ha actualizado el producto ID: 11', '2025-06-12 17:05:24');
INSERT INTO `logs` VALUES (57, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-12 17:05:24');
INSERT INTO `logs` VALUES (58, 1, 'El usuario ha ingresado al formulario para crear un nuevo producto.', '2025-06-12 17:05:31');
INSERT INTO `logs` VALUES (59, 1, 'El usuario ha creado un nuevo producto: Conjunto Dinosaurio', '2025-06-12 17:06:28');
INSERT INTO `logs` VALUES (60, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-12 17:06:29');
INSERT INTO `logs` VALUES (61, 1, 'El usuario ha accedido al listado de categorías.', '2025-06-12 17:06:32');
INSERT INTO `logs` VALUES (62, 1, 'El usuario ha eliminado la categoría con Nombre: Test 1', '2025-06-12 17:06:35');
INSERT INTO `logs` VALUES (63, 1, 'El usuario ha accedido al listado de categorías.', '2025-06-12 17:06:35');
INSERT INTO `logs` VALUES (64, 1, 'El usuario ha eliminado la categoría con Nombre: Test 2', '2025-06-12 17:06:36');
INSERT INTO `logs` VALUES (65, 1, 'El usuario ha accedido al listado de categorías.', '2025-06-12 17:06:37');
INSERT INTO `logs` VALUES (66, 1, 'El usuario ha eliminado la categoría con Nombre: Test 3', '2025-06-12 17:06:38');
INSERT INTO `logs` VALUES (67, 1, 'El usuario ha accedido al listado de categorías.', '2025-06-12 17:06:38');
INSERT INTO `logs` VALUES (68, 1, 'El usuario ha eliminado la categoría con Nombre: Test 4', '2025-06-12 17:06:39');
INSERT INTO `logs` VALUES (69, 1, 'El usuario ha accedido al listado de categorías.', '2025-06-12 17:06:40');
INSERT INTO `logs` VALUES (70, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-12 17:06:44');
INSERT INTO `logs` VALUES (71, 1, 'El usuario ha accedido al listado de categorías.', '2025-06-12 17:06:46');
INSERT INTO `logs` VALUES (72, 1, 'El usuario ha accedido al listado de tallas.', '2025-06-12 17:06:48');
INSERT INTO `logs` VALUES (73, 1, 'El usuario ha ingresado al formulario para crear un nuevo producto.', '2025-06-12 17:06:57');
INSERT INTO `logs` VALUES (74, 1, 'El usuario ha creado un nuevo producto: Vestido con short y correa', '2025-06-12 17:09:11');
INSERT INTO `logs` VALUES (75, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-12 17:09:11');
INSERT INTO `logs` VALUES (76, 1, 'El usuario ha ingresado al formulario para editar el producto ID: 10', '2025-06-12 17:09:20');
INSERT INTO `logs` VALUES (77, 1, 'El usuario ha actualizado el producto ID: 10', '2025-06-12 17:09:24');
INSERT INTO `logs` VALUES (78, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-12 17:09:24');
INSERT INTO `logs` VALUES (79, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-12 17:10:00');
INSERT INTO `logs` VALUES (80, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-12 17:10:01');
INSERT INTO `logs` VALUES (81, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-12 17:10:01');
INSERT INTO `logs` VALUES (82, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-12 17:10:03');
INSERT INTO `logs` VALUES (83, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-12 17:10:07');
INSERT INTO `logs` VALUES (84, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-12 17:10:08');
INSERT INTO `logs` VALUES (85, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-12 17:10:08');
INSERT INTO `logs` VALUES (86, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-12 17:10:20');
INSERT INTO `logs` VALUES (87, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-12 17:10:22');
INSERT INTO `logs` VALUES (88, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-12 17:10:23');
INSERT INTO `logs` VALUES (89, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-12 17:10:23');
INSERT INTO `logs` VALUES (90, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-12 17:10:23');
INSERT INTO `logs` VALUES (91, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-12 17:10:25');
INSERT INTO `logs` VALUES (92, 1, 'El usuario ha ingresado al formulario para crear un nuevo producto.', '2025-06-12 17:11:32');
INSERT INTO `logs` VALUES (93, 1, 'El usuario ha creado un nuevo producto: Conjunto Superhéroe Batman', '2025-06-12 17:12:15');
INSERT INTO `logs` VALUES (94, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-12 17:12:15');
INSERT INTO `logs` VALUES (95, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-12 17:12:27');
INSERT INTO `logs` VALUES (96, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-12 17:12:29');
INSERT INTO `logs` VALUES (97, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-12 17:12:29');
INSERT INTO `logs` VALUES (98, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-12 17:12:30');
INSERT INTO `logs` VALUES (99, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-12 17:13:18');
INSERT INTO `logs` VALUES (100, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-12 17:13:19');
INSERT INTO `logs` VALUES (101, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-12 17:13:20');
INSERT INTO `logs` VALUES (102, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-12 17:14:19');
INSERT INTO `logs` VALUES (103, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-12 17:14:19');
INSERT INTO `logs` VALUES (104, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-12 17:14:19');
INSERT INTO `logs` VALUES (105, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-12 17:14:20');
INSERT INTO `logs` VALUES (106, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-12 17:14:36');
INSERT INTO `logs` VALUES (107, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-12 17:14:38');
INSERT INTO `logs` VALUES (108, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-12 17:14:38');
INSERT INTO `logs` VALUES (109, 1, 'El usuario ha ingresado al formulario para editar el producto ID: 14', '2025-06-12 17:14:46');
INSERT INTO `logs` VALUES (110, 1, 'El usuario ha visualizado el listado de métodos de pago.', '2025-06-12 17:14:51');
INSERT INTO `logs` VALUES (111, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-12 17:14:52');
INSERT INTO `logs` VALUES (112, 1, 'El usuario ha borrado el mensaje recibido desde:  xdarkvaderxx@gmail.com', '2025-06-12 17:14:58');
INSERT INTO `logs` VALUES (113, 1, 'El usuario accedió al listado de usuarios.', '2025-06-12 17:15:03');
INSERT INTO `logs` VALUES (114, 1, 'El usuario accedió al formulario de creación de usuario.', '2025-06-12 17:15:09');
INSERT INTO `logs` VALUES (115, 1, 'El usuario accedió al listado de usuarios.', '2025-06-12 17:16:41');
INSERT INTO `logs` VALUES (116, 1, 'El usuario accedió al listado de usuarios.', '2025-06-12 17:16:42');
INSERT INTO `logs` VALUES (117, 1, 'Se eliminó el usuario ID: 9 (pruebacliente@gmail.com)', '2025-06-12 17:16:52');
INSERT INTO `logs` VALUES (118, 1, 'El usuario accedió al listado de usuarios.', '2025-06-12 17:16:52');
INSERT INTO `logs` VALUES (119, 1, 'Error al eliminar el usuario ID: 5. SQLSTATE[23000]: Integrity constraint violation: 1451 Cannot delete or update a parent row: a foreign key constraint fails (`pequenoasurios`.`logs`, CONSTRAINT `logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)) (Connection: mysql, SQL: delete from `users` where `id` = 5)', '2025-06-12 17:16:55');
INSERT INTO `logs` VALUES (120, 1, 'El usuario accedió al listado de usuarios.', '2025-06-12 17:16:55');
INSERT INTO `logs` VALUES (121, 1, 'Error al eliminar el usuario ID: 10. SQLSTATE[23000]: Integrity constraint violation: 1451 Cannot delete or update a parent row: a foreign key constraint fails (`pequenoasurios`.`orders`, CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)) (Connection: mysql, SQL: delete from `users` where `id` = 10)', '2025-06-12 17:17:01');
INSERT INTO `logs` VALUES (122, 1, 'El usuario accedió al listado de usuarios.', '2025-06-12 17:17:01');
INSERT INTO `logs` VALUES (123, 1, 'Se actualizó el usuario ID: 5 (cliente@gmail.com)', '2025-06-12 17:17:28');
INSERT INTO `logs` VALUES (124, 1, 'El usuario accedió al listado de usuarios.', '2025-06-12 17:17:28');
INSERT INTO `logs` VALUES (125, 14, 'El usuario ha visualizado el listado de métodos de pago.', '2025-06-12 17:19:36');
INSERT INTO `logs` VALUES (126, 1, 'El usuario accedió al listado de usuarios.', '2025-06-12 17:21:48');
INSERT INTO `logs` VALUES (127, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-12 17:21:49');
INSERT INTO `logs` VALUES (128, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-12 17:21:50');
INSERT INTO `logs` VALUES (129, 1, 'El usuario accedió al listado de usuarios.', '2025-06-12 17:21:50');
INSERT INTO `logs` VALUES (130, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-12 17:22:30');
INSERT INTO `logs` VALUES (131, 1, 'El usuario accedió al listado de usuarios.', '2025-06-12 17:22:30');
INSERT INTO `logs` VALUES (132, 1, 'El usuario accedió al listado de usuarios.', '2025-06-12 17:22:39');
INSERT INTO `logs` VALUES (133, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-12 17:29:42');
INSERT INTO `logs` VALUES (134, 1, 'El usuario ha ingresado al formulario para editar el producto ID: 10', '2025-06-12 17:29:45');
INSERT INTO `logs` VALUES (135, 1, 'El usuario ha actualizado el producto ID: 10', '2025-06-12 17:29:54');
INSERT INTO `logs` VALUES (136, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-12 17:29:54');
INSERT INTO `logs` VALUES (137, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-12 17:32:09');
INSERT INTO `logs` VALUES (138, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-12 17:33:13');
INSERT INTO `logs` VALUES (139, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-12 17:33:28');
INSERT INTO `logs` VALUES (140, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-12 17:33:42');
INSERT INTO `logs` VALUES (141, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-12 17:33:48');
INSERT INTO `logs` VALUES (142, 1, 'El usuario accedió al listado de usuarios.', '2025-06-12 17:49:16');
INSERT INTO `logs` VALUES (143, 1, 'El usuario accedió al listado de usuarios.', '2025-06-12 17:49:20');
INSERT INTO `logs` VALUES (144, 1, 'El usuario accedió al listado de usuarios.', '2025-06-12 17:49:26');
INSERT INTO `logs` VALUES (145, 1, 'El usuario accedió al listado de usuarios.', '2025-06-12 17:49:28');
INSERT INTO `logs` VALUES (146, 1, 'Se actualizó el usuario ID: 11 (maria.gonzalez@pequenosaurios.com)', '2025-06-12 17:50:15');
INSERT INTO `logs` VALUES (147, 1, 'El usuario accedió al listado de usuarios.', '2025-06-12 17:50:15');
INSERT INTO `logs` VALUES (148, 1, 'Se actualizó el usuario ID: 11 (maria.gonzalez@pequenosaurios.com)', '2025-06-12 17:50:21');
INSERT INTO `logs` VALUES (149, 1, 'El usuario accedió al listado de usuarios.', '2025-06-12 17:50:21');
INSERT INTO `logs` VALUES (150, 1, 'El usuario ha repondido el mensaje al correo: dani.salas.uba@gmail.com', '2025-06-12 17:50:35');
INSERT INTO `logs` VALUES (151, 1, 'El usuario ha visualizado el listado de métodos de pago.', '2025-06-12 17:50:50');
INSERT INTO `logs` VALUES (152, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-12 17:50:52');
INSERT INTO `logs` VALUES (153, 1, 'El usuario ha accedido al listado de tallas.', '2025-06-12 17:50:57');
INSERT INTO `logs` VALUES (154, 1, 'El usuario ha accedido al listado de categorías.', '2025-06-12 17:51:01');
INSERT INTO `logs` VALUES (155, 1, 'El usuario ha accedido al listado de categorías.', '2025-06-12 17:51:05');
INSERT INTO `logs` VALUES (156, 1, 'El usuario ha accedido al listado de categorías.', '2025-06-12 17:51:14');
INSERT INTO `logs` VALUES (157, 1, 'El usuario ha ingresado al formulario para crear un nuevo producto.', '2025-06-12 17:51:21');
INSERT INTO `logs` VALUES (158, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-12 17:51:38');
INSERT INTO `logs` VALUES (159, 1, 'El usuario ha ingresado al formulario para editar el producto ID: 14', '2025-06-12 17:52:03');
INSERT INTO `logs` VALUES (160, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-12 17:52:10');
INSERT INTO `logs` VALUES (161, 1, 'Intento fallido de eliminar producto ID: 13 debido a ventas asociadas.', '2025-06-12 17:52:26');
INSERT INTO `logs` VALUES (162, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-12 17:52:26');
INSERT INTO `logs` VALUES (163, 1, 'El usuario ha visualizado el listado de métodos de pago.', '2025-06-12 17:52:30');
INSERT INTO `logs` VALUES (164, 1, 'El usuario ha ingresado al formulario para editar el método de pago ID: 5', '2025-06-12 17:52:36');
INSERT INTO `logs` VALUES (165, 1, 'El usuario ha actualizado el método de pago ID: 5', '2025-06-12 17:52:38');
INSERT INTO `logs` VALUES (166, 1, 'El usuario ha visualizado el listado de métodos de pago.', '2025-06-12 17:52:38');
INSERT INTO `logs` VALUES (167, 1, 'El usuario ha ingresado al formulario para editar el método de pago ID: 5', '2025-06-12 17:52:40');
INSERT INTO `logs` VALUES (168, 1, 'El usuario ha actualizado el método de pago ID: 5', '2025-06-12 17:52:45');
INSERT INTO `logs` VALUES (169, 1, 'El usuario ha visualizado el listado de métodos de pago.', '2025-06-12 17:52:46');
INSERT INTO `logs` VALUES (170, 1, 'El usuario ha visualizado el listado de métodos de pago.', '2025-06-12 18:53:42');
INSERT INTO `logs` VALUES (171, 1, 'El usuario ha visualizado el listado de métodos de pago.', '2025-06-12 18:54:01');
INSERT INTO `logs` VALUES (172, 1, 'El usuario ha visualizado el listado de métodos de pago.', '2025-06-12 18:54:08');
INSERT INTO `logs` VALUES (173, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-12 18:54:16');
INSERT INTO `logs` VALUES (174, 1, 'El usuario ha visualizado el listado de métodos de pago.', '2025-06-12 18:54:17');
INSERT INTO `logs` VALUES (175, 1, 'El usuario ha visualizado el listado de métodos de pago.', '2025-06-12 18:55:02');
INSERT INTO `logs` VALUES (176, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-12 18:55:02');
INSERT INTO `logs` VALUES (177, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-12 18:55:03');
INSERT INTO `logs` VALUES (178, 1, 'El usuario ha visualizado el listado de métodos de pago.', '2025-06-12 18:55:04');
INSERT INTO `logs` VALUES (179, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-12 18:55:08');
INSERT INTO `logs` VALUES (180, 1, 'El usuario ha visualizado el listado de métodos de pago.', '2025-06-12 18:55:08');
INSERT INTO `logs` VALUES (181, 1, 'El usuario ha visualizado el listado de métodos de pago.', '2025-06-12 18:58:32');
INSERT INTO `logs` VALUES (182, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-12 18:58:32');
INSERT INTO `logs` VALUES (183, 1, 'El usuario ha visualizado el listado de métodos de pago.', '2025-06-12 19:01:34');
INSERT INTO `logs` VALUES (184, 1, 'El usuario ha visualizado el listado de métodos de pago.', '2025-06-12 19:03:06');
INSERT INTO `logs` VALUES (185, 1, 'El usuario ha visualizado el listado de métodos de pago.', '2025-06-12 19:03:23');
INSERT INTO `logs` VALUES (186, 1, 'El usuario ha visualizado el listado de métodos de pago.', '2025-06-12 19:03:40');
INSERT INTO `logs` VALUES (187, 1, 'El usuario ha visualizado el listado de métodos de pago.', '2025-06-12 19:04:45');
INSERT INTO `logs` VALUES (188, 1, 'El usuario ha visualizado el listado de métodos de pago.', '2025-06-12 19:05:34');
INSERT INTO `logs` VALUES (189, 1, 'El usuario ha visualizado el listado de métodos de pago.', '2025-06-12 19:09:10');
INSERT INTO `logs` VALUES (190, 1, 'El usuario ha visualizado el listado de métodos de pago.', '2025-06-12 22:47:38');
INSERT INTO `logs` VALUES (191, 1, 'El usuario accedió al listado de usuarios.', '2025-06-12 23:16:26');
INSERT INTO `logs` VALUES (192, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-12 23:16:32');
INSERT INTO `logs` VALUES (193, 1, 'El usuario ha visualizado el listado de métodos de pago.', '2025-06-12 23:16:37');
INSERT INTO `logs` VALUES (194, 1, 'El usuario ha visualizado el listado de métodos de pago.', '2025-06-12 23:16:40');
INSERT INTO `logs` VALUES (195, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-12 23:16:42');
INSERT INTO `logs` VALUES (196, 1, 'El usuario accedió al listado de usuarios.', '2025-06-12 23:16:44');
INSERT INTO `logs` VALUES (197, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-12 23:16:48');
INSERT INTO `logs` VALUES (198, 1, 'El usuario accedió al listado de usuarios.', '2025-06-12 23:17:17');
INSERT INTO `logs` VALUES (199, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-12 23:17:23');
INSERT INTO `logs` VALUES (200, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-12 23:17:46');
INSERT INTO `logs` VALUES (201, 1, 'El usuario accedió al listado de usuarios.', '2025-06-12 23:17:49');
INSERT INTO `logs` VALUES (202, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-12 23:17:50');
INSERT INTO `logs` VALUES (203, 1, 'El usuario accedió al listado de usuarios.', '2025-06-12 23:17:50');
INSERT INTO `logs` VALUES (204, 1, 'El usuario accedió al listado de usuarios.', '2025-06-12 23:18:35');
INSERT INTO `logs` VALUES (205, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-12 23:18:42');
INSERT INTO `logs` VALUES (206, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-12 23:19:10');
INSERT INTO `logs` VALUES (207, 1, 'El usuario accedió al listado de usuarios.', '2025-06-12 23:19:13');
INSERT INTO `logs` VALUES (208, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-12 23:19:13');
INSERT INTO `logs` VALUES (209, 1, 'El usuario accedió al listado de usuarios.', '2025-06-12 23:19:14');
INSERT INTO `logs` VALUES (210, 1, 'El usuario accedió al listado de usuarios.', '2025-06-12 23:19:19');
INSERT INTO `logs` VALUES (211, 1, 'Se actualizó el usuario ID: 5 (cliente@gmail.com)', '2025-06-12 23:19:24');
INSERT INTO `logs` VALUES (212, 1, 'El usuario accedió al listado de usuarios.', '2025-06-12 23:19:24');
INSERT INTO `logs` VALUES (213, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-12 23:19:30');
INSERT INTO `logs` VALUES (214, 1, 'El usuario ha visualizado el listado de métodos de pago.', '2025-06-12 23:19:35');
INSERT INTO `logs` VALUES (215, 1, 'El usuario ha visualizado el listado de métodos de pago.', '2025-06-12 23:34:23');
INSERT INTO `logs` VALUES (216, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-12 23:34:23');
INSERT INTO `logs` VALUES (217, 1, 'El usuario ha visualizado el listado de métodos de pago.', '2025-06-12 23:34:30');
INSERT INTO `logs` VALUES (218, 1, 'El usuario accedió al listado de usuarios.', '2025-06-12 23:34:31');
INSERT INTO `logs` VALUES (219, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-13 01:01:26');
INSERT INTO `logs` VALUES (220, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-13 01:02:54');
INSERT INTO `logs` VALUES (221, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-13 01:02:56');
INSERT INTO `logs` VALUES (222, 1, 'El usuario ha visualizado el listado de métodos de pago.', '2025-06-13 01:06:29');
INSERT INTO `logs` VALUES (223, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-13 01:06:32');
INSERT INTO `logs` VALUES (224, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-13 01:07:22');
INSERT INTO `logs` VALUES (225, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-13 01:07:22');
INSERT INTO `logs` VALUES (226, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-13 01:07:34');
INSERT INTO `logs` VALUES (227, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-13 01:07:35');
INSERT INTO `logs` VALUES (228, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-13 01:07:50');
INSERT INTO `logs` VALUES (229, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-13 01:08:20');
INSERT INTO `logs` VALUES (230, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-13 01:08:20');
INSERT INTO `logs` VALUES (231, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-13 01:08:45');
INSERT INTO `logs` VALUES (232, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-13 01:08:45');
INSERT INTO `logs` VALUES (233, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-13 01:09:01');
INSERT INTO `logs` VALUES (234, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-13 01:09:02');
INSERT INTO `logs` VALUES (235, 1, 'El usuario ha ingresado al formulario para editar el producto ID: 14', '2025-06-13 01:09:05');
INSERT INTO `logs` VALUES (236, 1, 'El usuario ha visualizado el listado de métodos de pago.', '2025-06-13 01:09:10');
INSERT INTO `logs` VALUES (237, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-13 01:09:31');
INSERT INTO `logs` VALUES (238, 1, 'El usuario accedió al listado de usuarios.', '2025-06-13 01:09:33');
INSERT INTO `logs` VALUES (239, 1, 'El usuario ha visualizado el listado de métodos de pago.', '2025-06-13 02:35:47');
INSERT INTO `logs` VALUES (240, 1, 'El usuario accedió al listado de usuarios.', '2025-06-13 08:44:16');
INSERT INTO `logs` VALUES (241, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-13 08:44:22');
INSERT INTO `logs` VALUES (242, 1, 'El usuario ha visualizado el listado de métodos de pago.', '2025-06-13 08:44:27');
INSERT INTO `logs` VALUES (243, 1, 'El usuario ha repondido el mensaje al correo: dani.salas.uba@gmail.com', '2025-06-13 18:27:21');
INSERT INTO `logs` VALUES (244, 1, 'El usuario ha repondido el mensaje al correo: dani.salas.uba@gmail.com', '2025-06-13 18:27:38');
INSERT INTO `logs` VALUES (245, 1, 'El usuario ha repondido el mensaje al correo: dani.salas.uba@gmail.com', '2025-06-13 18:27:51');
INSERT INTO `logs` VALUES (246, 1, 'El usuario accedió al listado de usuarios.', '2025-06-13 18:38:14');
INSERT INTO `logs` VALUES (247, 1, 'Se actualizó el usuario ID: 5 (cliente@gmail.com)', '2025-06-13 18:38:20');
INSERT INTO `logs` VALUES (248, 1, 'El usuario accedió al listado de usuarios.', '2025-06-13 18:38:20');
INSERT INTO `logs` VALUES (249, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-14 18:01:59');
INSERT INTO `logs` VALUES (250, 1, 'El usuario ha ingresado al formulario para editar el producto ID: 13', '2025-06-14 18:02:04');
INSERT INTO `logs` VALUES (251, 1, 'El usuario ha actualizado el producto ID: 13', '2025-06-14 18:02:14');
INSERT INTO `logs` VALUES (252, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-14 18:02:14');
INSERT INTO `logs` VALUES (253, 1, 'El usuario ha ingresado al formulario para editar el producto ID: 13', '2025-06-14 18:04:47');
INSERT INTO `logs` VALUES (254, 1, 'El usuario ha actualizado el producto ID: 13', '2025-06-14 18:04:53');
INSERT INTO `logs` VALUES (255, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-14 18:04:53');
INSERT INTO `logs` VALUES (256, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-14 19:45:54');
INSERT INTO `logs` VALUES (257, 1, 'El usuario ha ingresado al formulario para editar el producto ID: 14', '2025-06-14 19:45:56');
INSERT INTO `logs` VALUES (258, 1, 'El usuario ha actualizado el producto ID: 14', '2025-06-14 19:45:59');
INSERT INTO `logs` VALUES (259, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-14 19:45:59');
INSERT INTO `logs` VALUES (260, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-14 19:47:34');
INSERT INTO `logs` VALUES (261, 1, 'El usuario ha ingresado al formulario para editar el producto ID: 14', '2025-06-14 19:47:36');
INSERT INTO `logs` VALUES (262, 1, 'El usuario ha actualizado el producto ID: 14', '2025-06-14 19:47:38');
INSERT INTO `logs` VALUES (263, 1, 'El usuario ha visualizado el listado de productos.', '2025-06-14 19:47:39');

-- ----------------------------
-- Table structure for messages
-- ----------------------------
DROP TABLE IF EXISTS `messages`;
CREATE TABLE `messages`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mensaje` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `respondido` tinyint NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_respondido`(`respondido` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 17 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of messages
-- ----------------------------
INSERT INTO `messages` VALUES (11, 'Daniela Salas', 'dani.salas.uba@gmail.com', 'Esto es una prueba a verificar', '2025-06-12 14:40:21', '2025-06-12 17:50:35', 1);
INSERT INTO `messages` VALUES (12, 'Daniela Salas', 'dani.salas.uba@gmail.com', 'esto es una prueba', '2025-06-12 15:06:41', '2025-06-13 18:27:21', 1);
INSERT INTO `messages` VALUES (13, 'Daniela Salas', 'dani.salas.uba@gmail.com', 'esto es una prueba', '2025-06-12 15:13:55', '2025-06-12 15:13:55', 0);
INSERT INTO `messages` VALUES (14, 'Daniela Salas', 'dani.salas.uba@gmail.com', 'Esto es un prueba', '2025-06-12 15:20:35', '2025-06-12 15:20:35', 0);
INSERT INTO `messages` VALUES (15, 'Daniela Salas', 'dani.salas.uba@gmail.com', 'Esto es una prueba', '2025-06-12 15:38:24', '2025-06-12 15:38:24', 0);
INSERT INTO `messages` VALUES (16, 'Daniela Salas', 'mail@mail.com', 'Esto es un prueba', '2025-06-12 17:24:28', '2025-06-12 17:24:28', 0);

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (1, '2014_10_12_000000_create_users_table', 1);
INSERT INTO `migrations` VALUES (2, '2014_10_12_100000_create_password_reset_tokens_table', 1);
INSERT INTO `migrations` VALUES (3, '2019_08_19_000000_create_failed_jobs_table', 1);
INSERT INTO `migrations` VALUES (4, '2019_12_14_000001_create_personal_access_tokens_table', 1);
INSERT INTO `migrations` VALUES (5, '2025_05_21_031406_create_products_table', 2);

-- ----------------------------
-- Table structure for order_items
-- ----------------------------
DROP TABLE IF EXISTS `order_items`;
CREATE TABLE `order_items`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_id` int UNSIGNED NOT NULL,
  `product_id` int NOT NULL,
  `cantidad` int UNSIGNED NOT NULL,
  `precio_unitario` decimal(10, 2) NOT NULL,
  `size_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `fk_order_items_order`(`order_id` ASC) USING BTREE,
  INDEX `fk_order_items_product`(`product_id` ASC) USING BTREE,
  INDEX `fk_order_items_size`(`size_id` ASC) USING BTREE,
  CONSTRAINT `fk_order_items_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `fk_order_items_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_order_items_size` FOREIGN KEY (`size_id`) REFERENCES `sizes` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 21 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of order_items
-- ----------------------------
INSERT INTO `order_items` VALUES (5, 6, 10, 1, 15.00, 3, '2025-06-12 13:44:14', '2025-06-12 13:44:14');
INSERT INTO `order_items` VALUES (6, 7, 10, 1, 15.00, 3, '2025-06-12 13:49:14', '2025-06-12 13:49:14');
INSERT INTO `order_items` VALUES (7, 8, 10, 1, 15.00, 3, '2025-06-12 14:30:54', '2025-06-12 14:30:54');
INSERT INTO `order_items` VALUES (8, 8, 10, 1, 15.00, 1, '2025-06-12 14:30:54', '2025-06-12 14:30:54');
INSERT INTO `order_items` VALUES (9, 9, 10, 8, 15.00, 3, '2025-06-12 16:09:37', '2025-06-12 16:09:37');
INSERT INTO `order_items` VALUES (10, 10, 10, 1, 15.00, 3, '2025-06-12 17:48:36', '2025-06-12 17:48:36');
INSERT INTO `order_items` VALUES (11, 10, 11, 10, 29.99, 18, '2025-06-12 17:48:36', '2025-06-12 17:48:36');
INSERT INTO `order_items` VALUES (12, 10, 11, 5, 29.99, 17, '2025-06-12 17:48:36', '2025-06-12 17:48:36');
INSERT INTO `order_items` VALUES (13, 10, 13, 1, 29.99, 18, '2025-06-12 17:48:36', '2025-06-12 17:48:36');
INSERT INTO `order_items` VALUES (14, 11, 14, 10, 34.99, 17, '2025-06-13 18:41:15', '2025-06-13 18:41:15');
INSERT INTO `order_items` VALUES (15, 13, 14, 3, 34.99, 18, '2025-06-13 19:43:32', '2025-06-13 19:43:32');
INSERT INTO `order_items` VALUES (16, 14, 11, 3, 29.99, 17, '2025-06-14 19:05:43', '2025-06-14 19:05:43');
INSERT INTO `order_items` VALUES (17, 14, 14, 2, 34.99, 18, '2025-06-14 19:05:43', '2025-06-14 19:05:43');
INSERT INTO `order_items` VALUES (18, 15, 10, 1, 34.99, 1, '2025-06-14 19:24:11', '2025-06-14 19:24:11');
INSERT INTO `order_items` VALUES (19, 16, 14, 1, 34.99, 18, '2025-06-14 19:25:43', '2025-06-14 19:25:43');
INSERT INTO `order_items` VALUES (20, 17, 14, 1, 34.99, 18, '2025-06-14 19:31:56', '2025-06-14 19:31:56');

-- ----------------------------
-- Table structure for orders
-- ----------------------------
DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `total` decimal(10, 2) NOT NULL,
  `status` enum('pendiente','pagado','enviado','cancelado','completado') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pendiente',
  `direccion_envio` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `pago_id` int UNSIGNED NULL DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `pago_id`(`pago_id` ASC) USING BTREE,
  INDEX `idx_user_status`(`user_id` ASC, `status` ASC) USING BTREE,
  INDEX `idx_fecha_status`(`fecha` ASC, `status` ASC) USING BTREE,
  INDEX `idx_user_fecha`(`user_id` ASC, `fecha` ASC) USING BTREE,
  CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`pago_id`) REFERENCES `payments` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 18 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of orders
-- ----------------------------
INSERT INTO `orders` VALUES (6, 5, 15.00, 'pendiente', 'Residencias Invica, Torre 1 Chaguaramos, Piso 2 Apt 25 Las mercedesApartamento 25', 1, '2025-06-12 13:44:14', '2025-06-12 13:44:14', '2025-06-12 13:44:14');
INSERT INTO `orders` VALUES (7, 5, 15.00, 'pendiente', 'Residencias Invica, Torre 1 Chaguaramos, Piso 2 Apt 25 Las mercedesApartamento 25', 2, '2025-06-12 13:49:14', '2025-06-12 13:49:14', '2025-06-12 13:49:14');
INSERT INTO `orders` VALUES (8, 5, 30.00, 'pendiente', 'Residencias Invica, Torre 1 Chaguaramos, Piso 2 Apt 25 Las mercedesApartamento 25', 3, '2025-06-12 14:30:54', '2025-06-12 14:30:54', '2025-06-12 14:30:54');
INSERT INTO `orders` VALUES (9, 10, 120.00, 'pendiente', 'Maracay, Aragua, Venezuela', 4, '2025-06-12 16:09:37', '2025-06-12 16:09:37', '2025-06-12 16:09:37');
INSERT INTO `orders` VALUES (10, 10, 494.84, 'pendiente', 'Maracay, Aragua, Venezuela', 5, '2025-06-12 17:48:36', '2025-06-12 17:48:36', '2025-06-14 19:28:18');
INSERT INTO `orders` VALUES (11, 10, 349.90, 'pendiente', 'Maracay, Aragua, Venezuela', 6, '2025-06-13 18:41:15', '2025-06-13 18:41:15', '2025-06-13 18:41:15');
INSERT INTO `orders` VALUES (13, 5, 104.97, 'pendiente', 'Calle Los Pinos 123, Urbanización El Bosque, Caracas, Venezuela', 8, '2025-06-13 19:43:32', '2025-06-13 19:43:32', '2025-06-13 19:43:32');
INSERT INTO `orders` VALUES (14, 5, 159.95, 'pagado', 'Calle Los Pinos 123, Urbanización El Bosque, Caracas, Venezuela', 9, '2025-06-14 19:05:43', '2025-06-14 19:05:43', '2025-06-14 19:33:27');
INSERT INTO `orders` VALUES (15, 5, 34.99, 'pagado', 'Calle Los Pinos 123, Urbanización El Bosque, Caracas, Venezuela', 14, '2025-06-14 19:24:11', '2025-06-14 19:24:11', '2025-06-14 19:33:22');
INSERT INTO `orders` VALUES (16, 5, 34.99, 'pendiente', 'Calle Los Pinos 123, Urbanización El Bosque, Caracas, Venezuela', 17, '2025-06-14 19:25:43', '2025-06-14 19:25:43', '2025-06-14 19:28:23');
INSERT INTO `orders` VALUES (17, 5, 34.99, 'pagado', 'Calle Los Pinos 123, Urbanización El Bosque, Caracas, Venezuela', 18, '2025-06-14 19:31:56', '2025-06-14 19:31:56', '2025-06-14 19:31:56');

-- ----------------------------
-- Table structure for password_reset_tokens
-- ----------------------------
DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens`  (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of password_reset_tokens
-- ----------------------------
INSERT INTO `password_reset_tokens` VALUES ('admin@pequesaurios.com', '$2y$12$SVfzBARQF34dlQ8gdYvF0uOhjYNefyXmvTpDEmmbF7oySELFMi7Zq', '2025-06-01 15:53:39');
INSERT INTO `password_reset_tokens` VALUES ('xdarkvaderxx@gmail.com', '$2y$12$P/14HDTArt3v8PboiQ4YB.MV.8BsdUxsiFtCjChdGl95JC.65eWm.', '2025-06-05 18:08:05');

-- ----------------------------
-- Table structure for payment_types
-- ----------------------------
DROP TABLE IF EXISTS `payment_types`;
CREATE TABLE `payment_types`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of payment_types
-- ----------------------------
INSERT INTO `payment_types` VALUES (1, 'Transferencia', 'Puedes realizar el pago mediante transferencia desde tu banco a nuestra cuenta:\r\nBanco: Banco Nacional de Venezuela\r\nTitular: Pequeñosaurios C.A.\r\nRIF: J-12345678-9\r\nCuenta Corriente: 0102-0123-4567-8901-2345\r\nCorreo para confirmación: pagos@pequenosaurios.com\r\nRequiere confirmación manual.', '2025-06-12 13:20:00', '2025-06-12 13:34:47', 1);
INSERT INTO `payment_types` VALUES (2, 'Tarjeta de Crédito', 'Pago seguro y rápido con tarjetas de crédito Visa, MasterCard, American Express y otras. Permite pagos en cuotas y autorización inmediata.', '2025-06-12 13:24:48', '2025-06-12 13:24:48', 1);
INSERT INTO `payment_types` VALUES (3, 'Tarjeta de Débito', 'Pago directo desde tu cuenta bancaria a través de tarjetas de débito, sin intereses ni cuotas. Aceptamos la mayoría de bancos nacionales.', '2025-06-12 13:24:56', '2025-06-12 13:24:56', 1);
INSERT INTO `payment_types` VALUES (4, 'Pago en Efectivo', 'Puedes pagar en efectivo en nuestra tienda física o en puntos autorizados.\r\nDirección tienda: Av. Los Próceres, C.C. Plaza Pequeña, Nivel PB, Local 24, Caracas.\r\nHorario: Lunes a viernes de 9:00 a.m. a 5:00 p.m.\r\nSolicita tu comprobante al momento de pagar.', '2025-06-12 13:28:58', '2025-06-12 13:35:35', 1);
INSERT INTO `payment_types` VALUES (5, 'Pago con PayPal', 'Para pagar con PayPal, envía el monto exacto a la siguiente cuenta:\r\nPayPal Email: pagos@pequenosaurios.com\r\nReferencia del pedido: Incluye tu número de orden en el mensaje.\r\nLa verificación es automática y recibirás confirmación por correo.', '2025-06-12 16:17:59', '2025-06-12 17:52:45', 0);

-- ----------------------------
-- Table structure for payments
-- ----------------------------
DROP TABLE IF EXISTS `payments`;
CREATE TABLE `payments`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `payment_type_id` int NOT NULL,
  `monto` decimal(10, 2) NOT NULL,
  `estado` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `referencia` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp,
  `created_at` datetime NULL DEFAULT current_timestamp,
  `updated_at` datetime NULL DEFAULT current_timestamp ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `user_id`(`user_id` ASC) USING BTREE,
  INDEX `payment_type_id`(`payment_type_id` ASC) USING BTREE,
  INDEX `idx_estado`(`estado` ASC) USING BTREE,
  INDEX `idx_fecha`(`fecha` ASC) USING BTREE,
  CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `payments_ibfk_2` FOREIGN KEY (`payment_type_id`) REFERENCES `payment_types` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 19 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of payments
-- ----------------------------
INSERT INTO `payments` VALUES (1, 5, 1, 15.00, 'pendiente', 'ASDASDAD', '2025-06-12 13:44:14', '2025-06-12 13:44:14', '2025-06-14 15:00:21');
INSERT INTO `payments` VALUES (2, 5, 1, 15.00, 'pendiente', '151515', '2025-06-12 13:49:14', '2025-06-12 13:49:14', '2025-06-14 15:00:21');
INSERT INTO `payments` VALUES (3, 5, 1, 30.00, 'pendiente', '151511', '2025-06-12 14:30:54', '2025-06-12 14:30:54', '2025-06-14 15:00:21');
INSERT INTO `payments` VALUES (4, 10, 1, 120.00, 'pendiente', '1597814616514', '2025-06-12 16:09:37', '2025-06-12 16:09:37', '2025-06-14 15:00:21');
INSERT INTO `payments` VALUES (5, 10, 1, 494.84, 'pendiente', '18651684168', '2025-06-12 17:48:36', '2025-06-12 17:48:36', '2025-06-14 15:00:21');
INSERT INTO `payments` VALUES (6, 10, 1, 349.90, 'pendiente', '1065846516', '2025-06-13 18:41:15', '2025-06-13 18:41:15', '2025-06-13 18:41:15');
INSERT INTO `payments` VALUES (8, 5, 1, 104.97, 'pendiente', '156846516', '2025-06-13 19:43:32', '2025-06-13 19:43:32', '2025-06-13 19:43:32');
INSERT INTO `payments` VALUES (9, 5, 1, 159.95, 'pendiente', '116516', '2025-06-14 19:05:43', '2025-06-14 19:05:43', '2025-06-14 19:05:43');
INSERT INTO `payments` VALUES (14, 5, 1, 34.99, 'pendiente', '1615651615', '2025-06-14 19:24:11', '2025-06-14 19:24:11', '2025-06-14 19:24:11');
INSERT INTO `payments` VALUES (17, 5, 2, 34.99, 'completado', 'TARJ-A3430101DC', '2025-06-14 19:25:43', '2025-06-14 19:25:43', '2025-06-14 19:25:43');
INSERT INTO `payments` VALUES (18, 5, 2, 34.99, 'completado', 'TARJ-56FAE783C6', '2025-06-14 19:31:56', '2025-06-14 19:31:56', '2025-06-14 19:31:56');

-- ----------------------------
-- Table structure for personal_access_tokens
-- ----------------------------
DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `personal_access_tokens_token_unique`(`token` ASC) USING BTREE,
  INDEX `personal_access_tokens_tokenable_type_tokenable_id_index`(`tokenable_type` ASC, `tokenable_id` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of personal_access_tokens
-- ----------------------------

-- ----------------------------
-- Table structure for product_size
-- ----------------------------
DROP TABLE IF EXISTS `product_size`;
CREATE TABLE `product_size`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_id` int NOT NULL,
  `size_id` int NOT NULL,
  `stock` int NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_product_stock`(`product_id` ASC, `stock` ASC) USING BTREE,
  INDEX `idx_size_stock`(`size_id` ASC, `stock` ASC) USING BTREE,
  CONSTRAINT `product_size_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `product_size_ibfk_2` FOREIGN KEY (`size_id`) REFERENCES `sizes` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 34 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of product_size
-- ----------------------------
INSERT INTO `product_size` VALUES (18, 10, 3, 0, '2025-06-12 16:16:01', '2025-06-12 17:48:36');
INSERT INTO `product_size` VALUES (19, 10, 1, 8, '2025-06-12 16:16:01', '2025-06-14 19:24:11');
INSERT INTO `product_size` VALUES (20, 10, 18, 10, '2025-06-12 17:02:17', '2025-06-12 17:02:17');
INSERT INTO `product_size` VALUES (21, 10, 19, 12, '2025-06-12 17:02:17', '2025-06-12 17:02:17');
INSERT INTO `product_size` VALUES (23, 11, 17, 2, '2025-06-12 17:04:38', '2025-06-14 19:05:43');
INSERT INTO `product_size` VALUES (24, 11, 18, 0, '2025-06-12 17:04:38', '2025-06-12 17:48:36');
INSERT INTO `product_size` VALUES (25, 11, 19, 10, '2025-06-12 17:04:38', '2025-06-12 17:04:38');
INSERT INTO `product_size` VALUES (26, 12, 16, 10, '2025-06-12 17:06:28', '2025-06-12 17:06:28');
INSERT INTO `product_size` VALUES (27, 12, 17, 10, '2025-06-12 17:06:28', '2025-06-12 17:06:28');
INSERT INTO `product_size` VALUES (28, 12, 18, 10, '2025-06-12 17:06:28', '2025-06-12 17:06:28');
INSERT INTO `product_size` VALUES (29, 13, 18, 3, '2025-06-12 17:09:11', '2025-06-12 17:48:36');
INSERT INTO `product_size` VALUES (30, 13, 19, 6, '2025-06-12 17:09:11', '2025-06-12 17:09:11');
INSERT INTO `product_size` VALUES (31, 14, 17, 0, '2025-06-12 17:12:15', '2025-06-13 18:41:15');
INSERT INTO `product_size` VALUES (32, 14, 18, 3, '2025-06-12 17:12:15', '2025-06-14 19:31:56');
INSERT INTO `product_size` VALUES (33, 14, 19, 10, '2025-06-12 17:12:15', '2025-06-12 17:12:15');

-- ----------------------------
-- Table structure for products
-- ----------------------------
DROP TABLE IF EXISTS `products`;
CREATE TABLE `products`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(150) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL,
  `precio` decimal(10, 2) NOT NULL,
  `stock` int NULL DEFAULT 0,
  `color` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `categoria_id` int NOT NULL,
  `imagen` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `status` tinyint NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `categoria_id`(`categoria_id` ASC) USING BTREE,
  INDEX `idx_status`(`status` ASC) USING BTREE,
  INDEX `idx_precio`(`precio` ASC) USING BTREE,
  FULLTEXT INDEX `idx_busqueda`(`nombre`, `descripcion`),
  CONSTRAINT `products_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `categories` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 15 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of products
-- ----------------------------
INSERT INTO `products` VALUES (10, 'Conjunto Deprotivo', 'Conjunto deportivo para niños — Cómodo y resistente', 34.99, 0, 'Rojo', 13, 'productos/9dZSi49IvxpfKwJQU4T9ETRVm9bETBw7DwY1uMEz.png', 1, '2025-06-11 07:40:53', '2025-06-12 17:29:54');
INSERT INTO `products` VALUES (11, 'Vestido Primavera', 'Vestido ligero y fresco con un delicado estampado floral que evoca la alegría de la primavera. Fabricado en algodón suave, tiene un corte cómodo y detalles encantadores en los hombros. Ideal para ocasiones casuales, salidas familiares o días soleados.', 29.99, 0, 'Rosa', 8, 'productos/jpIA1D7VPdu30knPDnClZo6pXEm9aS85szcneVwx.png', 1, '2025-06-12 17:04:38', '2025-06-12 17:05:24');
INSERT INTO `products` VALUES (12, 'Conjunto Dinosaurio', 'Divertido conjunto con estampado de dinosaurios coloridos que encantará a los pequeños aventureros. Confeccionado en algodón suave y transpirable, incluye camiseta de manga corta y pantalones cómodos con cintura elástica. Perfecto para el día a día y actividades al aire libre, combinando estilo y comodidad.', 24.99, 0, 'Azul', 12, 'productos/WKa0UYpiVOPhUJKoF9uMud45BoY0ZFvHeIsjhgjj.png', 1, '2025-06-12 17:06:28', '2025-06-12 17:06:28');
INSERT INTO `products` VALUES (13, 'Vestido con short y correa', 'Conjunto encantador que incluye un vestido ligero con estampado de puntos en azul y un short cómodo a juego. La correa ajustable realza la figura y añade un toque de estilo clásico. Perfecto para días cálidos y actividades al aire libre, combina comodidad con un diseño delicado y moderno.', 29.99, 0, 'Azul Punteado', 12, 'productos/KWID1sXM1sIijYr3LNasG2Fy52sw6xyI2BY1t14A.webp', 1, '2025-06-12 17:09:11', '2025-06-14 18:04:53');
INSERT INTO `products` VALUES (14, 'Conjunto Superhéroe Batman', 'Divertido conjunto inspirado en Batman, ideal para pequeños fanáticos de los superhéroes. La camiseta amarilla brillante presenta el logo icónico de Batman en el pecho, combinada con un short azul cómodo para libertad total de movimiento. Perfecto para juegos, disfraces o uso diario con estilo.', 34.99, 0, 'Amarillo y Azul', 12, 'productos/VL9zmgyDhBqKKmFU0hwcqzr8tfpzBPFGoO6rFrJX.webp', 1, '2025-06-12 17:12:15', '2025-06-12 17:12:15');

-- ----------------------------
-- Table structure for reviews
-- ----------------------------
DROP TABLE IF EXISTS `reviews`;
CREATE TABLE `reviews`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `comentario` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `producto_id` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp,
  `puntuacion` int NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `fk_reviews_producto`(`producto_id` ASC) USING BTREE,
  INDEX `idx_puntuacion`(`puntuacion` ASC) USING BTREE,
  CONSTRAINT `fk_reviews_producto` FOREIGN KEY (`producto_id`) REFERENCES `products` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of reviews
-- ----------------------------
INSERT INTO `reviews` VALUES (1, 'Daniela Salas', 'Excelente calidad', 10, '2025-06-12 18:39:49', 5, '2025-06-12 18:39:49');
INSERT INTO `reviews` VALUES (2, 'Daniela Salas', '¡Encantada con la calidad!', 11, '2025-06-12 18:39:49', 4, '2025-06-12 18:39:49');
INSERT INTO `reviews` VALUES (3, 'Daniela Salas', 'Muy bonita y cómoda', 12, '2025-06-12 18:39:49', 4, '2025-06-12 18:39:49');
INSERT INTO `reviews` VALUES (4, 'Daniela Salas', 'Diseños únicos y delicados', 14, '2025-06-12 18:39:49', 5, '2025-06-12 18:39:49');
INSERT INTO `reviews` VALUES (5, 'Daniela Salas', 'Buena atención al cliente', 12, '2025-06-12 18:39:49', 4, '2025-06-12 18:39:49');
INSERT INTO `reviews` VALUES (6, 'Daniela Salas', 'Excelente calidad y Atención', 10, '2025-06-12 23:51:35', 5, '2025-06-12 23:51:35');

-- ----------------------------
-- Table structure for sizes
-- ----------------------------
DROP TABLE IF EXISTS `sizes`;
CREATE TABLE `sizes`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `etiqueta` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 23 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sizes
-- ----------------------------
INSERT INTO `sizes` VALUES (1, 'S', '2025-06-10 16:34:28', '2025-06-10 16:34:31');
INSERT INTO `sizes` VALUES (3, 'M', '2025-06-10 16:34:35', '2025-06-10 16:34:39');
INSERT INTO `sizes` VALUES (7, 'XXL', '2025-06-11 01:32:19', '2025-06-11 01:32:19');
INSERT INTO `sizes` VALUES (9, 'Recien Nacidos', '2025-06-12 16:58:19', '2025-06-12 16:58:19');
INSERT INTO `sizes` VALUES (10, '0-3 meses', '2025-06-12 16:58:19', '2025-06-12 16:58:19');
INSERT INTO `sizes` VALUES (11, '3-6 meses', '2025-06-12 16:58:19', '2025-06-12 16:58:19');
INSERT INTO `sizes` VALUES (12, '6-9 meses', '2025-06-12 16:58:19', '2025-06-12 16:58:19');
INSERT INTO `sizes` VALUES (13, '9-12 meses', '2025-06-12 16:58:19', '2025-06-12 16:58:19');
INSERT INTO `sizes` VALUES (14, '12-18 meses', '2025-06-12 16:58:19', '2025-06-12 16:58:19');
INSERT INTO `sizes` VALUES (15, '18-24 meses', '2025-06-12 16:58:19', '2025-06-12 17:01:19');
INSERT INTO `sizes` VALUES (16, '2 años', '2025-06-12 16:58:19', '2025-06-12 17:01:10');
INSERT INTO `sizes` VALUES (17, '3 años', '2025-06-12 16:58:19', '2025-06-12 17:01:11');
INSERT INTO `sizes` VALUES (18, '4 años', '2025-06-12 16:58:19', '2025-06-12 17:01:14');
INSERT INTO `sizes` VALUES (19, '5 años', '2025-06-12 16:58:19', '2025-06-12 16:58:19');
INSERT INTO `sizes` VALUES (20, '6 años', '2025-06-12 16:58:19', '2025-06-12 16:58:19');
INSERT INTO `sizes` VALUES (21, '7 años', '2025-06-12 16:58:19', '2025-06-12 16:58:19');
INSERT INTO `sizes` VALUES (22, '8 años', '2025-06-12 16:58:19', '2025-06-12 16:58:19');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `tipo` enum('admin','cliente','inventario','ventas','soporte') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'cliente',
  `direccion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NULL DEFAULT 1 COMMENT '1=activo,0=inactivo',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `users_email_unique`(`email` ASC) USING BTREE,
  INDEX `idx_tipo_status`(`tipo` ASC, `status` ASC) USING BTREE,
  INDEX `idx_email_status`(`email` ASC, `status` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 19 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'Administrador', 'admin@pequenosaurios.com', NULL, '$2y$12$lC2KMsuSNa0cOsVroivkQukN7TErgEydF9vw949QwrMesWTB2D/3O', 'wsk2il55G7aR3bGRNjJ7g6SYV9NORbatHjErSETE9L8d8c2wfDRiY6ilegVA', '2025-05-21 04:26:27', '2025-06-14 19:48:12', 'admin', 'Maracay, Aragua, Venezuela', 1);
INSERT INTO `users` VALUES (5, 'Valentina Torres', 'cliente@gmail.com', NULL, '$2y$12$lC2KMsuSNa0cOsVroivkQukN7TErgEydF9vw949QwrMesWTB2D/3O', NULL, '2025-06-06 18:11:27', '2025-06-13 18:38:20', 'cliente', 'Calle Los Pinos 123, Urbanización El Bosque, Caracas, Venezuela', 1);
INSERT INTO `users` VALUES (10, 'Daniela Salas', 'dani.salas.uba@gmail.com', NULL, '$2y$12$ALFyY0gqpLsCN9V20aQIeeLF3A9yRBSmOkollqMZySg01PwOA7nSK', 'yntixAXQghSHfFDYnRwNgJWJwF0poRNnx1VD9NOLZ4LAEROnF49qMk2k2pxf', '2025-06-12 14:59:23', '2025-06-14 18:01:47', 'cliente', 'Maracay, Aragua, Venezuela', 1);
INSERT INTO `users` VALUES (11, 'María González', 'maria.gonzalez@pequenosaurios.com', NULL, '$2y$12$lC2KMsuSNa0cOsVroivkQukN7TErgEydF9vw949QwrMesWTB2D/3O', NULL, '2025-06-12 17:16:35', '2025-06-12 17:50:15', 'admin', 'Maracay, Aragua, Venezuela', 1);
INSERT INTO `users` VALUES (12, 'Carlos Pérez', 'carlos.perez@pequenosaurios.com', NULL, '$2y$12$lC2KMsuSNa0cOsVroivkQukN7TErgEydF9vw949QwrMesWTB2D/3O', NULL, '2025-06-12 17:16:35', '2025-06-12 18:04:19', 'cliente', 'Maracay, Aragua, Venezuela', 1);
INSERT INTO `users` VALUES (13, 'Ana Martínez', 'ana.martinez@pequenosaurios.com', NULL, '$2y$12$lC2KMsuSNa0cOsVroivkQukN7TErgEydF9vw949QwrMesWTB2D/3O', NULL, '2025-06-12 17:16:35', '2025-06-12 18:04:19', 'inventario', 'Maracay, Aragua, Venezuela', 1);
INSERT INTO `users` VALUES (14, 'Luis Fernández', 'luis.fernandez@pequenosaurios.com', NULL, '$2y$12$lC2KMsuSNa0cOsVroivkQukN7TErgEydF9vw949QwrMesWTB2D/3O', NULL, '2025-06-12 17:16:35', '2025-06-12 18:04:19', 'ventas', 'Maracay, Aragua, Venezuela', 1);
INSERT INTO `users` VALUES (15, 'Sofía Ramírez', 'sofia.ramirez@pequenosaurios.com', NULL, '$2y$12$lC2KMsuSNa0cOsVroivkQukN7TErgEydF9vw949QwrMesWTB2D/3O', NULL, '2025-06-12 17:16:35', '2025-06-12 18:04:19', 'soporte', 'Maracay, Aragua, Venezuela', 1);
INSERT INTO `users` VALUES (16, 'Cliente Test', 'cliente1@gmail.com', NULL, '$2y$12$vfyFdItwJOzzKnRI.5.lv.hP0lpBfBa4g2ppLo/z1JU3vbDzPIXZW', NULL, '2025-06-12 17:26:30', '2025-06-12 17:26:30', 'cliente', 'Maracay, Aragua, Venezuela', 1);
INSERT INTO `users` VALUES (17, 'Nayerlin Salazar', 'ing.jds.dev@gmail.com', NULL, '$2y$12$LdCQtX2hBlVLZ3dMYh1CcO0mRWO/uYKMDE4kNGpnlkYn0faif58RK', NULL, '2025-06-13 10:31:12', '2025-06-13 10:31:12', 'cliente', 'Maracay', 1);
INSERT INTO `users` VALUES (18, 'jose leonardo', 'xdarkvaderxx@gmail.com', NULL, '$2y$12$azkN08g/GaMPcxDJQm7eu.wcyoJ4VLyGDqzWprFx6Nl6WcDz7Hhpy', NULL, '2025-06-13 10:31:45', '2025-06-13 10:31:45', 'cliente', 'Residencias Invica, Torre 1 Chaguaramos, Piso 2 Apt 25 Las mercedes\r\nApartamento 25', 1);

SET FOREIGN_KEY_CHECKS = 1;
