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
