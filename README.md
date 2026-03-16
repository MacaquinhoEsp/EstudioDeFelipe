# 📸 El Estudio de Felipe

Sitio web oficial de **El Estudio de Felipe**, un estudio de fotografía familiar ubicado en Cartagena (España). La web presenta los servicios, galerías de trabajos, información sobre el estudio y un panel de administración para gestionar presupuestos y clientes.

---

## 🚀 Características principales

- **Diseño atractivo y responsive** con Tailwind CSS y tipografías personalizadas (MiBebas + Shree Devanagari 714).
- **Galerías dinámicas** para comuniones, sesiones al aire libre, cuentos, retratos y familia/infantil.
- **Panel de administración privado** (`/php/admin.php`) para gestionar presupuestos y clientes.
- **Formulario de contacto** que guarda las solicitudes en base de datos y redirige a una página de agradecimiento.
- **Sistema de gestión de clientes** (CRUD básico) con búsqueda, filtros y exportación de emails.
- **Medidas de seguridad**: contraseñas hasheadas, consultas preparadas, tokens CSRF y protección XSS.
- **SEO optimizado** con metaetiquetas, textos ricos en palabras clave locales y atributos `alt` descriptivos.
- **Menú responsive** con menú hamburguesa funcional en móvil.
- **Botón flotante de WhatsApp** para contacto rápido.

---

## 🛠️ Tecnologías utilizadas

- **Frontend:** HTML5, Tailwind CSS, JavaScript (ES6)
- **Backend:** PHP 8.2, MySQL
- **Entorno local:** XAMPP (Apache + MySQL + PHP)
- **Control de versiones:** Git
- **Herramientas adicionales:** Font Awesome, Google Fonts

---

## 📁 Estructura del proyecto
EstudioDeFelipe/
├── home.html
├── servicios.html
├── galería.html
├── estudio.html
├── contacto.html
├── gracias.html
├── aviso-legal.html
├── politica-privacidad.html
├── politica-cookies.html
├── colecciones/ # Páginas de galerías específicas
│ ├── al-aire.html
│ ├── comuniones.html
│ ├── cuentos.html
│ ├── familiar_infantil.html
│ └── profesional.html
├── php/ # Archivos PHP (administración y lógica)
│ ├── admin.php
│ ├── clientes.php
│ ├── config.php
│ ├── config_clientes.php
│ ├── guardar_presupuesto.php
│ └── exportar_emails.php (opcional)
├── img/ # Imágenes del sitio
│ ├── sombrero.png
│ └── (subcarpetas por sección)
├── fonts/ # Tipografías locales
│ ├── BebasNeue-Regular.woff2
│ └── ShreeDev0714.woff2
└── README.md

text

---

## ⚙️ Instalación y configuración local

### 1. Requisitos previos
- [XAMPP](https://www.apachefriends.org/) (o cualquier entorno Apache + MySQL + PHP)
- Git (opcional)

### 2. Clonar el repositorio
```bash
git clone https://github.com/MacaquinhoEsp/EstudioDeFelipe.git
O descarga el ZIP y extráelo en la carpeta htdocs de XAMPP (por ejemplo, C:\xampp\htdocs\EstudioDeFelipe\).

3. Configurar la base de datos
Arranca Apache y MySQL desde el panel de XAMPP.

Abre http://localhost/phpmyadmin.

Crea una base de datos llamada estudiofelipe_db.

Importa el archivo bd_estructura.sql (si lo tienes) o ejecuta las siguientes consultas para crear las tablas:

sql
CREATE TABLE presupuestos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    telefono VARCHAR(20),
    tipo_sesion VARCHAR(50),
    mensaje TEXT,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    estado VARCHAR(30) DEFAULT 'Pendiente'
);

CREATE TABLE clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    telefono VARCHAR(20),
    email VARCHAR(100),
    direccion TEXT,
    nombre_padre VARCHAR(100),
    nombre_madre VARCHAR(100),
    como_conocio VARCHAR(100),
    notas TEXT,
    servicio VARCHAR(50),
    precio DECIMAL(10,2),
    fecha_servicio DATE,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
4. Configurar la conexión
Edita los archivos php/config.php y php/config_clientes.php con los datos de tu base de datos local (por defecto: localhost, usuario root, contraseña vacía).

5. Acceder al sitio
Abre tu navegador y visita:

text
http://localhost/EstudioDeFelipe/home.html
6. Panel de administración
URL: http://localhost/EstudioDeFelipe/php/admin.php

Usuario: (no hay usuario, solo contraseña)

Contraseña por defecto: estudio2026 (puedes cambiarla generando un nuevo hash en admin.php).

☁️ Despliegue en un hosting real
Sube todos los archivos (excepto la carpeta fonts si ya está incluida) a la raíz de tu hosting (normalmente public_html).

Crea una base de datos en el hosting y anota los datos de conexión (servidor, usuario, contraseña, nombre de la BD).

Importa la estructura de las tablas (puedes exportarlas desde tu phpMyAdmin local e importarlas en el hosting).

Modifica php/config.php y php/config_clientes.php con los datos de conexión del hosting.

Ajusta las rutas de las imágenes si es necesario (todas deberían ser relativas, por lo que no debería haber problema).

Activa SSL (certificado HTTPS) desde el panel de tu hosting para mayor seguridad.

🤝 Cómo contribuir
Si deseas contribuir al proyecto, por favor:

Haz un fork del repositorio.

Crea una rama para tu funcionalidad (git checkout -b feature/nueva-funcionalidad).

Realiza tus cambios y haz commit (git commit -m 'Añadir nueva funcionalidad').

Sube los cambios a tu fork (git push origin feature/nueva-funcionalidad).

Abre un Pull Request explicando tus modificaciones.

📄 Licencia
Este proyecto es de uso privado para El Estudio de Felipe. No está permitida su distribución o reutilización sin autorización expresa.

📞 Contacto
Para cualquier consulta o sugerencia, puedes escribir a:

Email: info@elestudiodefelipe.com (si lo tienes)

Instagram: @elestudiodefelipe

Última actualización: marzo 2026
Desarrollado con ❤️ por MacaquinhoEsp
