# Versionado 📌
## Versión 2
### 2.1.1
> 1. Se corrige redireccionamiento desde la pantalla de login.
> 2. Se agregan traducciones al español.
### 2.1.0
> 1. Se implementa login de usuario.
> 2. Se agrega middleware para trabajar roles y permisos.
> 3. Se solicita verificación de correo electrónico mediante email.
> 4. Se genera sección "Mi Cuenta" para visualizar y modificar información del perfil del usuario.
> 5. Se automatiza envio de email para usuarios con jerarquía al finalizar el día con las intervenciones del día.
### 2.0.0
>  1. Se implementa panel AdminLTE para Laravel 8.
>  2. Se genera dashboard con indicadores útiles y automatizados de cámaras.
>  3. Se implementa CRUD de intervenciones con aviso mediante bot a Telegram a su canal correspondiente. Se colocan 3 filtros (fecha, detalle y cámara) para facilitar búsqueda.
>  4. Se implementa CRUD de fallas de cámaras manual con aviso mediante bot a Telegram a su canal correspondiente. Se colocan 2 filtros para facilitar búsqueda (fecha y cámara)
>  5. Se automatiza la carga de fallas (de comunicación) de cámaras mediante solicitud HTTP realizada desde el VMS. Se contemplan dos minutos hasta que se envie la solicitud.
>  6. Se implementa CRUD de seguimiento de solicitudes realizadas desde ámbitos externos/internos.
>  7. Se coloca tabla con datos automatizados y relevantes de las cámaras, los mismos son solicitados mediante API a Digifort. Se agrega como novedad la visualización en vivo de cada una de las cámaras.
>  8. Se agrega mapa interactivo (biblioteca leaflet) para visualizar el estado y la ubicación de cada una de las cámaras. Datos consultados desde BD que se actualizan según información brindada por el VMS.