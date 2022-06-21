# Versionado 📌
## Versión 2
### 2.6.1
> 1. Fix Bug (show cameras).
> 2. Se añade gráfico de porcentaje de funcionamiento para cada cámara.
### 2.6.0
> 1. Se añade botón "i" en el listado de dispositivos para ampliar información.
### 2.5.3
> 1. Se añade validación (campo date < today) del form intervenciones.
> 2. Se modifica api.
### 2.5.2
> 1. Se agrega media anual al gráfico de intervenciones.
> 2. Se añade select al form de intervenciones.
### 2.5.1
> 1. Se agrega a Mapa TV las cámaras en mantenimiento.
> 2. Bug Fix.
### 2.5.0
> 1. Se agrega botón de mantenimiento para no recibir request desde Digifort en caso que se esté trabajando en algun dispositivo en particular.
> 2. Se modifican formatos de fechas en tablas.
### 2.4.3
> 1. Los datos del dashboard se toman directamente desde la DB.
> 2. Los datos del listado de cámaras pasan a ser dispositivos y se toman desde la DB con descripción e IP.
> 3. Se elimina datatable de listado de dispositivos y se genera con livewire.
> 4. Se agregan columnas a entidad Cameras.
> 5. Se modifica API, al añadir falla el msg por TG envía descripción de la cámara.
### 2.4.2
> 1. Se agrega usuario al listado de email-intervenciones.
> 2. Se modifican vistas (lista de roles y crear usuario).
> 3. El sistema permite crear usuarios.
> 4. Se deshabilita registro por web.
### 2.4.1
> 1. Bug Fix. (form crear intervención envia varias intervenciones.)
> 2. Se actualizan rutas por la del DNS.
> 3. Finalizada la API de carga/actualización de fallas.
### 2.4.0
> 1. El mapa de videowall, si tiene cámaras fuera de servicio se desplaza una a una para mostrarlas.
> 2. Se añade progress bar para ver cuando actualiza el mapa.
### 2.3.5
> 1. Cambia clase según cantidad de cámaras fuera de servicio en mapa de TV.
> 2. El mapa solo carga cámaras fuera de servicio si es que existen.
> 3. Se añade API para enviar request desde Digifort.
### 2.3.4
> 1. El Administrador puede ver las auditorias de todos los usuarios.
> 2. Traducciones.
> 3. Exclude remember_token audits.
> 4. Bug Fix.
> 5. Se añade favicon.
> 6. Se fija NAVBAR a la derecha.
### 2.3.3
> 1. El supervisor de monitoreo puede editar intervenciones sin necesidad de ser el creador o si ya se hizo modificación.
> 2. Se modifica API de status cámaras para poder consultar desde whatsapp.
### 2.3.2
> 1. Se modifica vista de mapa monitor.
> 2. Se añade alerta de temperatura a monitoreo mediante Digifort.
> 3. Se añade reporte de fallas.
> 3. Se añade reporte para el Concejo.
> 3. Se añade reporte de expedientes.
### 2.3.1
> 1. Se añade alerta por TG de Temperaturas.
> 2. Bug Fix
> 3. Mapa para TV Smart con actualización automática.
### 2.3.0
> 1. Se añade SNMP Sun Etherpower
> 2. Se añade gráfico en Dashboard de temperatura de servidores.
### 2.2.3
> 1. Se agregan traducciones al widget del clima.
> 2. Se agrega generación de reporte de intervenciones.
> 3. Se dejan formularios hechos para reportes de Fallas, Concejo y Expedientes.
> 4. Se agrega middleware para form de reporte.
### 2.2.2
> 1. Se elimina autenticación para ver intervenciones.
> 2. Se elimina autenticación para ver imagen en vivo de cámara.
> 3. Se añade widget del clima.
### 2.2.1
> 1. Se modifican las páginas de errores.
> 2. Se añaden políticas de seguridad al editar intervenciones.
### 2.2.0
> 1. Se añade auditoría de modelos específicos.
> 2. Se agregan validaciones a algunos campos de form.
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