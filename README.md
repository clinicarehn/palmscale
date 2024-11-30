<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# PalmScale - Laravel

## Descripción
- Este proyecto es una aplicación web desarrollada en Laravel utilizando el paquete **Orchid**. Está diseñado para proporcionar una plataforma robusta y escalable para aplicaciones web avanzadas.

##  Instalación
### Requisitos Previos
- Git
- Composer
- PHP

### Clonar el Repositorio
```bash
git clone https://github.com/clinicarehn/PalmScale.git
cd palmscale/Laravel
```

### Configuración del Proyecto
```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
```
## Recomendaciones para el uso de CRUD
- Al trabajar con modelos y CRUD en Laravel con Orchid, es recomendable configurar el modelo correctamente para garantizar que funcione de manera óptima con las características de Orchid. En el modelo, debes agregar lo siguiente en `use`:

```php
use HasFactory, AsSource, Filterable, Attachable;
```

- Además, asegúrate de importar sus dependencias:

```php
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;
```
- Esto permitirá que el modelo aproveche las funcionalidades de fuentes de datos, filtros y archivos adjuntos, que son características importantes de Orchid para la gestión de CRUD.

### Configuración de la Base de Datos
- Abre el archivo **.env** en la raíz del proyecto.
- Configura las variables de entorno para la conexión a la base de datos, como

```bash
DB_CONNECTION
DB_HOST
DB_PORT
DB_DATABASE
DB_USERNAME
DB_PASSWORD.
```
## Configuración de Header y Footer
- Este proyecto incluye archivos personalizados para el **header** y **footer** ubicados en **resources/views/brand**. Estos archivos son:

**Nombre del archivo**: `header.blade.php`

```blade
@push('head')
    <link href="{{ asset('favicon.ico') }}" id="favicon" rel="icon">
@endpush

<div class="h2 d-flex align-items-center">
    @auth
        <x-orchid-icon path="bs.house" class="d-inline d-xl-none" />
    @endauth

    <p class="my-0 {{ auth()->check() ? 'd-none d-xl-block' : '' }}">
        {{ config('app.name') }}
    </p>
</div>
```

- segúrate de que el archivo **favicon.ico** esté ubicado en la raíz del directorio público de tu aplicación, es decir, en **public/favicon.ico**. Esto permite que sea accesible directamente a través de la URL **/favicon.ico**.

**Nombre del archivo**: `footer.blade.php`
```php
<p class="small m-n text-center w-100">
    © Copyright {{ date('Y') }}
    <a href="{{ config('app.url') }}" target="_blank">
        {{ config('app.name') }}
    </a>
</p>

```

# Modificación en la Configuración de Orchid
- Para aplicar estos archivos al diseño de la plataforma Orchid, actualiza el archivo **config/platform.php** reemplazando las siguientes líneas:

```php
'template' => [
    'header' => '',
    'footer' => '',
],
```
- por:
```php
  'template' => [
    'header' => 'brand.header',
    'footer' => 'brand.footer',
],
```

## Cargar Archivos JS por Separado

En este proyecto, los archivos JavaScript se cargan de forma separada utilizando el archivo `header.blade.php`. A continuación se muestra un ejemplo de cómo se realiza esta carga:

```blade
@push('head')
    <link href="{{ asset('favicon.ico') }}" id="favicon" rel="icon">

    {{-- AREA CSS --}}
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    {{-- AREA DE JS --}}
    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/utility.js') }}" defer type="text/javascript"></script>
    <script src="{{ asset('js/brio.js') }}" defer type="text/javascript"></script>
    <script src="{{ asset('js/descriptionpart.js') }}" defer type="text/javascript"></script>
@endpush

<div class="h2 d-flex align-items-center">
    @auth
        <x-orchid-icon path="bs.house" class="d-inline d-xl-none" />
    @endauth

    <p class="my-0 {{ auth()->check() ? 'd-none d-xl-block' : '' }}">
        {{ config('app.name') }}
    </p>
</div>
```

## Descripción
- El bloque **@push('head')** permite agregar scripts y estilos adicionales a la sección **<head>** de la página.
- Se incluye el **favicon**, los estilos CSS de la aplicación y los scripts JavaScript necesarios, como **jQuery** y el archivo **utility.js**.
- Utiliza el atributo defer en el script para asegurar que se ejecute después de que el documento se haya cargado completamente.

## Habilitar y Deshabilitar Selects en Orchid
- Para manejar los campos select y relation en Orchid, puedes utilizar las funciones definidas en el archivo `utility.js.blade.php`. Estas funciones permiten habilitar o deshabilitar los campos según sea necesario en la interfaz de usuario.

### Funciones Disponibles
- Deshabilitar un Select

```javascript
function disableSelect(id) {
    // Deshabilitar el campo <select> original
    $('#' + id).prop('disabled', true);

    // Deshabilitar Tom Select usando su método específico
    const tomSelectInstance = $('#' + id)[0].tomselect;
    if (tomSelectInstance) {
        tomSelectInstance.disable(); // Método interno de Tom Select para deshabilitarlo
    }

    // Añadir la clase 'disabled' para bloquear visualmente Tom Select
    $('#' + id).closest('.ts-wrapper').addClass('locked disabled');

    // Deshabilitar el dropdown de Tom Select y ocultarlo
    $('#' + id + '-ts-dropdown').css('display', 'none'); // Ocultar el menú desplegable

    // Evitar que cualquier clic o evento en el contenedor de Tom Select responda
    $('#' + id + '-ts-control').css('pointer-events', 'none');
}
```

- Habilitar un Select
```javascript
function enableSelect(id) {
    // Habilitar el campo <select> original
    $('#' + id).prop('disabled', false);

    // Habilitar Tom Select usando su método específico
    const tomSelectInstance = $('#' + id)[0].tomselect;
    if (tomSelectInstance) {
        tomSelectInstance.enable(); // Método interno de Tom Select para habilitarlo
    }

    // Quitar las clases que bloquean la funcionalidad visual
    $('#' + id).closest('.ts-wrapper').removeClass('locked disabled');

    // Mostrar el dropdown de Tom Select nuevamente
    $('#' + id + '-ts-dropdown').css('display', 'block');

    // Habilitar clics y eventos en el contenedor de Tom Select nuevamente
    $('#' + id + '-ts-control').css('pointer-events', 'auto');
}
```

## Codigo completo
**Nombre del archivo**: `utility.js`
```javascript
$(() => {
    // Inicialización o configuraciones si es necesario
});

/**
 * Deshabilita el campo <select> original y su instancia de Tom Select.
 *
 * @param {string} id - El ID del campo <select> (sin el símbolo '#' al inicio) que se desea deshabilitar.
 * @returns {void}
 */
function disableSelect(id) {
    // Deshabilitar el campo <select> original
    $('#' + id).prop('disabled', true);

    // Deshabilitar Tom Select usando su método específico
    const tomSelectInstance = $('#' + id)[0].tomselect;
    if (tomSelectInstance) {
        tomSelectInstance.disable(); // Método interno de Tom Select para deshabilitarlo
    }

    // Añadir la clase 'disabled' para bloquear visualmente Tom Select
    $('#' + id).closest('.ts-wrapper').addClass('locked disabled');

    // Deshabilitar el dropdown de Tom Select y ocultarlo
    $('#' + id + '-ts-dropdown').css('display', 'none'); // Ocultar el menú desplegable

    // Evitar que cualquier clic o evento en el contenedor de Tom Select responda
    $('#' + id + '-ts-control').css('pointer-events', 'none');
}

/**
 * Habilita el campo <select> original y su instancia de Tom Select.
 *
 * @param {string} id - El ID del campo <select> (sin el símbolo '#' al inicio) que se desea habilitar.
 * @returns {void}
 */
function enableSelect(id) {
    // Habilitar el campo <select> original
    $('#' + id).prop('disabled', false);

    // Habilitar Tom Select usando su método específico
    const tomSelectInstance = $('#' + id)[0].tomselect;
    if (tomSelectInstance) {
        tomSelectInstance.enable(); // Método interno de Tom Select para habilitarlo
    }

    // Quitar las clases que bloquean la funcionalidad visual
    $('#' + id).closest('.ts-wrapper').removeClass('locked disabled');

    // Mostrar el dropdown de Tom Select nuevamente
    $('#' + id + '-ts-dropdown').css('display', 'block');

    // Habilitar clics y eventos en el contenedor de Tom Select nuevamente
    $('#' + id + '-ts-control').css('pointer-events', 'auto');
}
```

## Cómo Utilizar las Funciones
- Para deshabilitar un campo select, simplemente llama a disableSelect('nombreDelSelect');, donde 'nombreDelSelect' es el ID del campo select sin el símbolo # al inicio.
- Para habilitar un campo select, llama a enableSelect('nombreDelSelect'); de manera similar.

# Ejemplo de Uso
- Supongamos que tienes un campo select con el ID miSelect. Puedes habilitar o deshabilitarlo de la siguiente manera:

```javascript
// Deshabilitar el select
disableSelect('miSelect');

// Habilitar el select
enableSelect('miSelect');
```

## Generar Changelog - Este se encarga de llevar el control de versiones de nuestro proyecto
- Para llevar un registro de cambios en el proyecto, utilizamos Conventional Changelog siguiendo la convención de mensajes de commits del estilo Angular. Este proceso permite generar y actualizar automáticamente el archivo **CHANGELOG.md** con los cambios más relevantes en tu proyecto, como nuevas características, correcciones de errores, y otros cambios.

### Paso 1: Instalar Node.js y npm (si no lo tienes instalado)
- Si no tienes npm (Node Package Manager) instalado, primero debes instalar Node.js, ya que npm viene incluido con Node.js.

### Instalar en Windows:
- Descarga el instalador de Node.js y sigue las instrucciones.
- Una vez instalado, verifica que npm esté disponible ejecutando el siguiente comando en la terminal o consola:

```bash
npm -v
```

### Instalar en Linux:
- En distribuciones basadas en Debian/Ubuntu, ejecuta los siguientes comandos:

```bash
sudo apt update
sudo apt install nodejs npm
```

### En distribuciones basadas en Red Hat/CentOS:
```bash
sudo yum install nodejs npm
```

### Verifica que la instalación fue correcta:
```bash
brew install node
```

### Verifica la instalación:
```bash
node -v
npm -v
```

### Instalar en macOS:
- Usa Homebrew para instalar Node.js y npm:

### En distribuciones basadas en Red Hat/CentOS:
```bash
sudo yum install nodejs npm
```

### Paso 2: Instalar Conventional Changelog CLI
- Después de instalar npm, necesitas agregar Conventional Changelog CLI como una dependencia global. Esto te permitirá generar el archivo **CHANGELOG.md** fácilmente:

```bash
npm install -g conventional-changelog-cli
```

### Paso 3: Generar el Changelog
- Si no existe el archivo CHANGELOG.md, el siguiente comando lo creará y lo llenará con los registros basados en tus commits que sigan la convención Angular. Si el archivo ya existe, lo actualizará.

```bash
npx conventional-changelog-cli -p angular -i CHANGELOG.md -s
```

### Detalles del Comando:
- -p angular: Especifica que la convención de commits que seguimos es la del estilo Angular.
- -i CHANGELOG.md: Indica que se debe generar o actualizar el archivo CHANGELOG.md.
- -s: Sobrescribe el archivo si ya existe, agregando la nueva información de los commits.

### Paso 4: Confirmar Cambios
- Después de ejecutar el comando, verifica que el archivo CHANGELOG.md contiene la información deseada. Puedes incluir este archivo en tus commits y continuar actualizándolo con cada cambio significativo en el proyecto.

## Notas Importantes
- Asegúrate de seguir la convención de mensajes de commits para que el changelog se genere correctamente. Por ejemplo:
- feat: Para agregar una nueva funcionalidad.
- fix: Para corregir un error.
- docs: Para cambios en la documentación.
- refactor: Para refactorización de código.

## Configurando el versionado automático con standard-version
- Si quieres que la versión de tu proyecto se actualice automáticamente al hacer cambios significativos, puedes seguir estos pasos:

## Paso 1: Instalar standard-version
Primero, necesitas instalar **standard-version**, que se encargará de incrementar la versión y generar el changelog:

```bash
npm install --save-dev standard-version
```
### Paso 2: Configurar el script en package.json
- Agrega un script en tu package.json para ejecutar standard-version de manera sencilla:

```json
{
  "scripts": {
    "release": "standard-version"
  }
}
```

## Debemos agregar este valor *"version": "1.0.1",*
```json
    "private": true,
    "type": "module",
    "version": "1.0.8",
```

### Paso 3: Usar el comando de release
- Cuando estés listo para hacer un release (liberar una nueva versión), ejecuta el siguiente comando:

```bash
npm run release
```

- Con esto logramos que se cambie la version de nuestro proyecto

### Este comando hará lo siguiente:
- Revisará los mensajes de commit para determinar si debe incrementar la versión de patch (parches), minor (menor) o major (mayor), según los cambios realizados:
- feat: incrementa la versión minor (1.0.0 → 1.1.0).
- fix: incrementa la versión patch (1.0.0 → 1.0.1).
- breaking change: incrementa la versión major (1.0.0 → 2.0.0).
- Actualizará el número de versión en tu package.json.
- Generará o actualizará el archivo CHANGELOG.md con los detalles de los commits más recientes

### Paso 4: Hacer commit y tag
-Una vez ejecutado el comando npm run release, standard-version hará el commit de los cambios y creará un tag con la nueva versión del proyecto. El comando también hará un commit que incluye los cambios en el archivo *CHANGELOG.md* y el *package.json* con la nueva versión.

Ejemplo del commit que generaría:

```bash
chore(release): 1.1.0
```

### Crear controlador para que esto obtener las versiones
```php
php artisan make:controller VersionController
```

- Agregamos el sguiente codigo:

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;

class VersionController extends Controller
{
    public static function getLatestVersionFromChangelog(): string
    {
        $changelogPath = base_path('CHANGELOG.md');  // Ajusta el path según tu estructura de carpetas

        if (File::exists($changelogPath)) {
            $contents = File::get($changelogPath);
            // Busca la línea que contiene la versión más reciente
            preg_match('/\[\s*([0-9]+\.[0-9]+\.[0-9]+)\s*\]/', $contents, $matches);
            return $matches[1] ?? 'Desconocida';
        }

        return 'Desconocida';
    }
}
```

## Cambiamos en el menú para poder ver la versión
- en *PlatformProvider.php* agregamos

```php
Menu::make('Versión')
	->icon('bs.box-arrow-up-right')
	->url('https://github.com/clinicarehn/PalmScale/tree/main/Laravel/CHANGELOG.md')
	->target('_blank')
	->badge(fn() => VersionController::getLatestVersionFromChangelog(), Color::DARK)
```

- Cambia la url segun tu necesidad

## Notas
- Recuerda  el codigo importante para la actualizacion de la versión es: *npm run release*

### Resumen del Flujo
- Haces commits utilizando la convención Angular (feat:, fix:, etc.).
- Ejecutas npm run release cuando quieras liberar una nueva versión.
- standard-version genera automáticamente el changelog, actualiza la versión del proyecto y crea un commit y tag.

### Notas Finales
- Conventional Changelog por sí solo no incrementa la versión del proyecto; solo genera o actualiza el changelog.
- Si quieres que todo (versión y changelog) se gestione automáticamente, debes usar standard-version o una herramienta similar.
- El proceso de release no ocurre automáticamente con cada commit. Debes ejecutar el comando de release manualmente cuando estés listo para una nueva versión.

**Este enfoque te asegura que tanto la versión como el changelog siempre estén actualizados de acuerdo con los cambios que realices en tu proyecto.**

## Uso
- Este proyecto utiliza Orchid para crear una interfaz de administración avanzada. Puedes acceder a la aplicación en http://localhost:8000 después de ejecutar php artisan serve.

## Licencia
- Este proyecto está bajo la Licencia MIT. Consulta el archivo LICENSE para más detalles.

## Contacto
- Para cualquier pregunta o sugerencia, por favor contacta a CLINICARE en edwin.velasquez@clinicarehn.com.
