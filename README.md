<div align="center">

# 🔌 CRUD Electrónica · Angular + MySQL

### Aplicación **CRUD** de productos con **Angular 15 + Angular Material** y **backend PHP** sobre **MySQL**

Gestión completa (listar, buscar, ver, crear, editar y borrar) de un catálogo de productos de electrónica, con un frontend Angular y un **backend PHP integrado** que expone una API REST. Diseñada para desplegarse por FTP en hosting compartido.

<br>

![Angular](https://img.shields.io/badge/Angular-15.0-DD0031?style=for-the-badge&logo=angular&logoColor=white)
![Angular Material](https://img.shields.io/badge/Angular_Material-15.2-757de8?style=for-the-badge&logo=angular&logoColor=white)
![TypeScript](https://img.shields.io/badge/TypeScript-4.8-3178C6?style=for-the-badge&logo=typescript&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-REST_API-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-InnoDB-4479A1?style=for-the-badge&logo=mysql&logoColor=white)

</div>

---

## 📋 Tabla de contenidos

- [Descripción](#-descripción)
- [Arquitectura](#-arquitectura)
- [Características](#-características)
- [Stack tecnológico](#-stack-tecnológico)
- [Estructura del proyecto](#-estructura-del-proyecto)
- [API REST](#-api-rest)
- [Modelo de datos](#-modelo-de-datos)
- [Puesta en marcha](#-puesta-en-marcha)
  - [Requisitos](#requisitos)
  - [Backend PHP + base de datos](#1-backend-php--base-de-datos)
  - [Frontend Angular](#2-frontend-angular)
- [Configuración y entornos](#-configuración-y-entornos)
- [Despliegue en producción](#-despliegue-en-producción)
- [⚠️ Seguridad](#️-seguridad-léelo)
- [Diagnóstico del backend](#-diagnóstico-del-backend)
- [Notas honestas sobre el estado del repo](#-notas-honestas-sobre-el-estado-del-repo)
- [Licencia](#-licencia)

---

## 🎯 Descripción

Aplicación de ejemplo que implementa un **CRUD clásico** sobre una única entidad, **`producto`**:

- **Listado** de productos en una tabla, con **búsqueda por nombre**.
- **Detalle** de un producto concreto.
- **Formulario** de alta / edición.
- **Borrado** con confirmación.

El frontend está hecho con **Angular 15** usando **Angular Material** (tabla, paginador, formularios, diálogos, snackbars) y **Bootstrap 5** para el layout. El backend es un **único punto de entrada PHP** (`index.php`) que actúa como *front controller* REST sobre **MySQL** mediante **PDO**.

Según los comentarios del propio backend, este PHP **sustituye a un backend Node anterior**, reutilizando su misma base de datos.

---

## 🏗️ Arquitectura

```
┌───────────────────────────────┐      HTTP / JSON      ┌───────────────────────────────┐
│         FRONTEND (SPA)         │  ─────────────────▶   │        BACKEND (API REST)      │
│                                │                       │                               │
│   Angular 15 + Material +      │  ◀─────────────────   │   PHP puro (sin framework)     │
│   Bootstrap 5                  │                       │   index.php = front controller │
│   - productos-list             │                       │   CORS + PDO                   │
│   - producto-detalle           │                       │   Ruta única: /productos       │
│   - producto-form              │                       │                               │
│   - producto.service (HTTP)    │                       └───────────────┬───────────────┘
└───────────────────────────────┘                                       │ PDO
                                                                         ▼
                                                        ┌───────────────────────────────┐
                                                        │      MySQL (InnoDB, utf8mb4)   │
                                                        │        tabla: productos        │
                                                        └───────────────────────────────┘
```

- El servicio Angular (`ProductoService`) llama a `${environment.apiUrl}/productos`.
- `index.php` resuelve la ruta de forma **tolerante a la falta de `mod_rewrite`**: acepta `/productos`, `index.php/productos` y `?path=productos`, e incluso un prefijo opcional `api/`.
- **CORS** con lista blanca de orígenes, gestionado antes de cargar nada más (para responder siempre al *preflight* `OPTIONS`).

---

## ✨ Características

| | Característica | Detalle |
|---|---|---|
| 📋 | **Listado** | Tabla de productos con Angular Material (`MatTable`, `MatPaginator`) |
| 🔎 | **Búsqueda** | Filtrado por nombre (`GET /productos?nombre=...`) |
| 👁️ | **Detalle** | Vista de un producto por id |
| ➕ | **Alta** | Formulario reactivo para crear productos |
| ✏️ | **Edición** | Actualización de un producto existente |
| 🗑️ | **Borrado** | Eliminación con diálogo de confirmación (`MatDialog`) |
| 💬 | **Feedback** | Notificaciones con `MatSnackBar` |
| 🎨 | **UI** | Angular Material (tema *indigo-pink*) + Bootstrap 5 |
| 🌐 | **API REST** | Backend PHP de un solo recurso, tolerante a subcarpetas |
| 🈺 | **i18n (preparado)** | Ficheros de traducción ES/EU presentes *(ver nota más abajo)* |

---

## 🧰 Stack tecnológico

### Frontend

| Tecnología | Versión | Uso |
|---|---|---|
| [Angular](https://angular.io/) | `15.0.x` | Framework SPA (builder webpack) |
| [Angular Material](https://material.angular.io/) | `15.2.x` | Componentes UI (tabla, formularios, diálogos, snackbar) |
| [Angular CDK](https://material.angular.io/cdk) | `15.2.x` | Utilidades base de Material |
| [Bootstrap](https://getbootstrap.com/) | `5.3.x` | Estilos y layout |
| [TypeScript](https://www.typescriptlang.org/) | `4.8.x` | Lenguaje |
| [RxJS](https://rxjs.dev/) | `7.5.x` | Programación reactiva (HTTP) |
| Karma + Jasmine | — | Testing (configuración por defecto de Angular CLI) |

### Backend

| Tecnología | Uso |
|---|---|
| **PHP** (sin framework, sin Composer) | API REST en un único `index.php` (front controller) |
| **PDO** | Acceso a MySQL |
| **CORS** | Lista blanca de orígenes en `index.php` |

### Base de datos

| Tecnología | Uso |
|---|---|
| **MySQL** (InnoDB, `utf8mb4_unicode_ci`) | Persistencia. Esquema en `backend-php/sql/crud.sql` |

---

## 📁 Estructura del proyecto

```
crud-ang-mysql-electronica/
│
├── src/                                   # 🅰️ FRONTEND ANGULAR
│   ├── app/
│   │   ├── components/
│   │   │   ├── productos-list/             # Tabla + búsqueda
│   │   │   ├── producto-detalle/           # Detalle de un producto
│   │   │   └── producto-form/              # Alta / edición
│   │   ├── services/
│   │   │   └── producto.service.ts         # Cliente HTTP del CRUD
│   │   ├── models/
│   │   │   └── producto.model.ts           # Interfaz Producto
│   │   ├── app-routing.module.ts           # Rutas
│   │   ├── app.module.ts                   # Módulos Material + Forms + HttpClient
│   │   └── app.component.*
│   ├── assets/i18n/                        # es.json / eu.json (ver nota)
│   ├── environments/                       # environment.ts / environment.prod.ts
│   ├── styles.scss                         # Bootstrap + tema Material indigo-pink
│   ├── index.html
│   └── main.ts
│
├── backend-php/                           # 🐘 BACKEND PHP (API REST)
│   ├── index.php                           # Front controller / router REST
│   ├── productos.php                       # Lógica CRUD de productos (PDO)
│   ├── db.php                              # Conexión PDO
│   ├── helpers.php                         # Respuestas JSON, utilidades
│   ├── config.php                          # Config base + carga config.local.php
│   ├── config.local.php                    # ⚠️ Config local (VER SEGURIDAD)
│   ├── diag.php / diag2.php                # Scripts de diagnóstico del servidor
│   ├── .htaccess                           # Rewrite a index.php + Authorization
│   └── sql/
│       └── crud.sql                        # Esquema de la tabla productos
│
├── angular.json                           # Config Angular (proyecto crud-angular-mysql)
├── package.json
├── tsconfig*.json
├── CRUD mySQL Angular - FrontEnd.pdf       # Documentación en PDF del frontend
└── README.md
```

---

## 🌐 API REST

Un único recurso: **`/productos`**. El frontend antepone la base de `environment.apiUrl`.

| Método | Ruta | Descripción |
|---|---|---|
| `GET` | `/productos` | Lista todos los productos (admite `?nombre=xxx` para buscar) |
| `GET` | `/productos/{id}` | Devuelve un producto por id |
| `POST` | `/productos` | Crea un producto |
| `PUT` | `/productos/{id}` | Actualiza un producto |
| `DELETE` | `/productos/{id}` | Borra un producto |

El router acepta además las variantes `index.php/productos`, `?path=productos` y un prefijo opcional `api/productos`, para funcionar aunque el hosting no tenga `mod_rewrite`.

**Ejemplos:**

```bash
# Listar
curl http://localhost:8888/crud-electronica/backend-php/productos

# Buscar por nombre
curl "http://localhost:8888/crud-electronica/backend-php/productos?nombre=cable"

# Crear
curl -X POST http://localhost:8888/crud-electronica/backend-php/productos \
  -H "Content-Type: application/json" \
  -d '{"nombre":"Resistencia 220Ω","descripcion":"1/4W","precio":0.10,"stock":500}'
```

---

## 🗄️ Modelo de datos

Una sola tabla, **`productos`** (InnoDB, `utf8mb4`). Esquema en `backend-php/sql/crud.sql`:

| Columna | Tipo | Notas |
|---|---|---|
| `id` | `INT AUTO_INCREMENT` | Clave primaria |
| `nombre` | `VARCHAR(100)` | Obligatorio |
| `descripcion` | `TEXT` | Opcional |
| `precio` | `DECIMAL(10,2)` | Obligatorio |
| `stock` | `INT` | Obligatorio |
| `createdAt` | `TIMESTAMP` | Por defecto `CURRENT_TIMESTAMP` |

La interfaz TypeScript equivalente (`producto.model.ts`):

```ts
export interface Producto {
  id?: number;
  nombre: string;
  descripcion: string;
  precio: number;
  stock: number;
  createdAt?: Date;
}
```

---

## 🚀 Puesta en marcha

### Requisitos

- **Node.js 18+** y **npm** (para Angular 15).
- **PHP 7.4+** con **PDO / pdo_mysql**.
- **MySQL** (en local, MAMP/XAMPP sirven).
- Angular CLI 15 (`npm i -g @angular/cli@15`) o usar el binario local vía `npm run`.

### 1. Backend PHP + base de datos

```bash
# Crear la base de datos e importar el esquema
mysql -u root -p -e "CREATE DATABASE crud_angular_mysql CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
mysql -u root -p crud_angular_mysql < backend-php/sql/crud.sql
```

Crea tu **`config.local.php`** para sobrescribir la config base con tus datos (este fichero **no debería subirse a Git**, ver [Seguridad](#️-seguridad-léelo)):

```php
// backend-php/config.local.php
<?php
return [
    'db' => [
        'host' => 'localhost',
        'port' => '3306',      // MAMP suele usar 8889
        'name' => 'crud_angular_mysql',
        'user' => 'root',
        'pass' => 'root',
    ],
];
```

Sirve el backend (servidor embebido de PHP o Apache/MAMP):

```bash
cd backend-php
php -S localhost:8888
```

Puedes comprobar el entorno con `diag.php` (muestra versión de PHP y si `pdo_mysql` está cargado).

### 2. Frontend Angular

```bash
npm install
npm start        # ng serve → http://localhost:4200
```

Ajusta `src/environments/environment.ts` para que `apiUrl` apunte a tu backend local:

```ts
export const environment = {
  production: false,
  apiUrl: 'http://localhost:8888/backend-php'   // el servicio le añade /productos
};
```

Otros comandos:

```bash
npm run build    # ng build → dist/crud-angular-mysql
npm run watch    # build en modo desarrollo con --watch
npm test         # ng test (Karma)
```

---

## ⚙️ Configuración y entornos

**Frontend** — `src/environments/`:

| Archivo | `apiUrl` | Cuándo se usa |
|---|---|---|
| `environment.ts` | Backend PHP local (MAMP) | `ng serve` (desarrollo) |
| `environment.prod.ts` | `/angular/crudelectronicasimplificado-backend` | `ng build` (producción) |

**Backend** — `backend-php/config.php`:
- Trae valores por defecto (`localhost`, `root`/`root`, BD `crud_angular_mysql`).
- Si existe **`config.local.php`**, lo carga y **sobrescribe** con `array_replace_recursive`.

---

## 📤 Despliegue en producción

Pensado para **hosting compartido por FTP**:

1. **Frontend**: `npm run build` genera `dist/crud-angular-mysql/`; sube su contenido a la carpeta pública.
2. **Backend**: sube `backend-php/` al servidor y crea allí tu `config.local.php` con las credenciales reales del hosting (y **no lo subas al repositorio**).
3. El `.htaccess` reescribe todo a `index.php` y recupera la cabecera `Authorization`.
4. Como el router tolera subcarpetas y ausencia de `mod_rewrite`, funciona aunque el backend cuelgue de una ruta como `/angular/crudelectronicasimplificado-backend/`.

> El `environment.prod.ts` de este repo apunta a `/angular/crudelectronicasimplificado-backend`. Ajusta esa ruta a la carpeta real donde subas el backend.

---

## ⚠️ Seguridad (léelo)

> **Aviso real sobre el estado actual del repositorio.**
>
> El fichero **`backend-php/config.local.php` está versionado en Git** y contiene credenciales de conexión a una base de datos remota (host, nombre, usuario y contraseña). El `.gitignore` de este repo **solo excluye `.angular/`**, por lo que ese fichero de configuración local **no** está ignorado.
>
> **Recomendaciones:**
> 1. **Rota la contraseña** de esa base de datos en el panel del hosting.
> 2. Deja de rastrear el fichero: `git rm --cached backend-php/config.local.php`.
> 3. Añádelo a `.gitignore`:
>    ```gitignore
>    backend-php/config.local.php
>    ```
> 4. Recuerda que el valor **sigue en el historial de Git** aunque lo borres ahora; para eliminarlo por completo hay que reescribir el historial (p. ej. `git filter-repo` o BFG) y hacer *force-push*.
>
> Buenas prácticas generales que ya aplica el proyecto: mantener los secretos en `config.local.php` (fuera del `config.php` versionado) y usar CORS con lista blanca. El único punto a corregir es que **este `config.local.php` concreto llegó a subirse**.

Además, `diag.php` y `diag2.php` activan `display_errors`; son útiles en desarrollo, pero conviene **no dejarlos accesibles en producción** para no filtrar información del servidor.

---

## 🩺 Diagnóstico del backend

El backend incluye dos utilidades pensadas para depurar despliegues en hosting (p. ej. Arsys):

| Script | Qué hace |
|---|---|
| `diag.php` | Muestra versión de PHP y si `pdo_mysql` está cargado |
| `diag2.php` | Captura errores fatales aunque `display_errors` esté desactivado en el servidor |

---

## 📝 Notas honestas sobre el estado del repo

Aclaraciones verificadas leyendo el código, para que no haya sorpresas:

- **i18n presente pero, al parecer, no conectado.** Existen `src/assets/i18n/es.json` y `eu.json` (con textos en castellano y euskera), pero **`ngx-translate` no figura en `package.json`** y no se han encontrado usos del pipe `| translate` ni de un servicio de traducción en el código. Es decir, la traducción está **preparada como recurso** pero no parece estar activa en la app en su estado actual. *(Si me equivoco y la conectas por otra vía, corrígelo en esta sección.)*
- **El backend PHP sustituye a un Node anterior.** Los comentarios de `index.php` y `config.local.php` indican que este backend reutiliza la base de datos que usaba un backend Node previo. En este repositorio **no hay** código Node de servidor.
- **Nombres que no coinciden.** El paquete se llama `crud-angular-mysql` y la build sale en `dist/crud-angular-mysql`, mientras que el repositorio es `crud-ang-mysql-electronica` y el backend de producción apunta a `crudelectronicasimplificado-backend`. Son solo nombres distintos, no un error.
- **`.gitignore` mínimo.** Solo ignora `.angular/` (caché). No ignora `node_modules/`, `dist/` ni `config.local.php` (ver seguridad).
- **Documentación incluida.** Hay un PDF (`CRUD mySQL Angular - FrontEnd.pdf`) con documentación del frontend.
- **Sin archivo `LICENSE`** y `package.json` no declara licencia (`"private": true`).

*(No se ha inventado ninguna dependencia, endpoint, columna ni comportamiento: todo procede del código del repositorio. Donde no he podido confirmar algo con certeza —el cableado de i18n— lo he indicado explícitamente.)*

---

## 📄 Licencia

El repositorio no incluye archivo de licencia y `package.json` está marcado como `"private": true`. Si quieres permitir su reutilización, añade una licencia (por ejemplo MIT).

---

<div align="center">

Hecho con 🅰️ **Angular 15 + Material** · 🐘 **PHP** · 🐬 **MySQL** — CRUD desplegable por FTP.

</div>
