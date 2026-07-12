# Plantilla de Análisis — Instancia 1

> Completar **todas** las secciones a partir de [Escenario.md](Escenario.md).  
> **No leer ni modificar** `Instancia-2-Desarrollo/codigo-base/` hasta entregar este documento.  
> Candidato: Elías Martín Cáceres Alvez

---

## 1. Resumen del problema

*¿Qué necesidad de negocio describe la entrevista? ¿Qué problema resuelve el módulo?*

**Respuesta:**

**La entrevista describe la necesidad** de gestionar de forma centralizada, segura y transparente las solicitudes internas de servicios o tareas del organismo/empresa.

Requerimientos del negocio:

- **Estandarización del registro**: Que cada área pueda generar un pedido con los datos mínimos obligatorios (Título, descripción, área solicitante, área destinataria y prioridad).
- **Seguimiento del estado**: Conocer en tiempo real en qué instancia se encuentra cada pedido (Pendiente, En Proceso, Resuelto o Rechazado).
- **Funcionamiento básico**: Permitir acciones específicas sobre las solicitudes según su estado (borrar/editar para pedidos pendientes; tomar/resolver/rechazar por el área destinataria).


**El módulo que armó Sistemas resuelve** un poco del caos administrativo, la informalidad y la perdida de información de los pedidos internos. En el esquema anterior de trabajo los pedidos se realizaban por diferentes canales (mail, WhatsApp, planilla compartida) y, debido a esto, provocaba:

- No poder cuantificar los pedidos acumulados por área, tanto solicitados como resueltos (pedidos perdidos entre conversaciones de WhatsApp, mails, o planillas compartidas).
- Falta de comunicación y seguimiento de los estados de los pedidos.
- Ausencia de priorización y registro de resolución, lo que tal vez generaba un problema de organización de tareas y trabajos en las diferentes áreas.

---

## 2. Actores

| Actor | Rol en el proceso |
|-------|-------------------|
| Administrativo | Solicitante |
| Mesa de Ayuda | Destinatario/Soporte |
| Área de Compras | Gestión y Resolución de Pedidos |
| Área de Sistemas | Técnico |

---

## 3. Flujo del proceso

*Representá el ciclo de vida de una solicitud (estados y transiciones). Podés usar texto, lista o diagrama.*

**Respuesta:**

![diagrama-ciclo-vida-solicitud](/Instancia-1-Analisis/diagrama-ciclo-vida-solicitud.png)

---

## 4. Reglas de negocio

*Listá las reglas que inferís del escenario. Separá las que están claras de las que dependen de un supuesto (§6).*

| Regla | ¿Explícita en la entrevista? | Notas |
|-------|------------------------------|-------|
| **Obligatoriedad de campos:** Al crear una solicitud, es obligatorio ingresar: Título, Descripción, Área Solicitante, Área Destinataria y Prioridad. | Si | Si falta alguno de estos campos, el módulo deberá controlar, validar y arrojar el error correspondiente si falta la carga de información. |
| **Inmutabilidad por Estado (En Proceso):** Una vez que una solicitud pasa a estado "En Proceso", el texto del pedido se congela y no se puede editar más. | Si | El botón de "Editar" debe quedar deshabilitado en la vista del usuario para evitar adulteraciones de los requerimientos. |
| **Inmutabilidad por Estado (Resuelta):** Una solicitud en estado "Resuelta" queda cerrada definitivamente y bajo ningún concepto se puede editar. | Si | María resalta que esto se aclaró reiteradas veces. El estado "Resuelta" es el final del proceso de la solicitud. |
| **Confirmación de Borrado:** La acción de borrar una solicitud en estado "Pendiente" requiere de una confirmación explícita del usuario. | Si | Lucas reporta incidentes de pérdida de datos por clics accidentales. Se podría implementar un pop-up de confirmación antes de la eliminación de la solicitud. |
| **Restricción de Acciones por Rol:** Solo el área destinataria y los usuarios con roles asignados pueden cambiar los estados a "Tomar", "Resolver" o "Rechazar". | Si | Aunque la regla de negocio es explícita, Carlos expone que actualmente no hay login, por lo que cualquiera puede pulsar los botones. Y se observa la necesidad de la jerarquía de roles (No deberían tener los mismos permisos un administrativo del área que un supervisor o gerente). |
| **Ordenamiento por Prioridad:** Las solicitudes de prioridad "Alta" deben aparecer en el tope del listado de tareas. | No (Depende de un supuesto) | Carlos dice que sí deben ordenarse primero, María dice que es solo una columna de referencia. Ante la discrepancia de las áreas, la opción más coherente sería que las solicitudes de alta prioridad deberían aparecer en el tope del listado, y podría agregarse un ícono identificador en rojo para poder diferenciarlo de las demás solicitudes. |
| **Reapertura de Solicitudes Rechazadas:** Una solicitud en estado "Rechazada" puede ser reabierta y retornar al flujo activo si el área lo requiere. | No (Depende de un supuesto) | Lucas entiende que "Rechazada" es un estado final, mientras que Carlos (Compras) necesita reabrirlas debido a errores frecuentes. Ante la discrepancia, lo más conveniente sería crear solicitudes de reapertura, las cuales sean administradas por supervisores o gerentes del área. |
| **Cancelación de Solicitudes:** El área creadora puede "Cancelar" un pedido de manera formal mientras se encuentre "Pendiente". | No (Depende de Supuesto) | María plantea el deseo de tener esta opción, pero aclara que el sistema hoy solo permite "Borrarla" (eliminar el registro). Se puede mantener la acción de borrar y añadir y documentar la "Cancelación" (como un estado intermedio entre editar y borrar). |
| **Filtros Combinados:** El listado debe permitir filtrar por "Estado" y por "Prioridad" en simultáneo. | No (Depende de Supuesto) | La duda de los usuarios de si los filtros por estado y prioridad están funcionando correctamente y en simultaneo se resuelve estableciendo una regla de filtrado combinado que bien podría realizarse con una consulta a la base de datos mediante un **INNER JOIN** de estado y prioridad de cada solicitud. |

 

---

## 5. Modelo de datos propuesto

*Proponé tablas y campos necesarios para soportar el proceso. No hace falta coincidir con el código todavía.*

**Respuesta:**

Tabla: Áreas

| Campo | Tipo | Descripcion |
|------|------------------------|-------------|
| ID | INT (PK) | Identificador único de área |
| Nombre | Varchar (100) | Nombre del área |


Tabla: Solicitudes

| Campo | Tipo | Descripcion |
|------|------------------------|-------------|
| ID | INT (PK) | Identificador único de la solicitud |
| Titulo | Varchar (100) | Título de la solicitud |
| Descripcion | Text | Descripción detallada de la solicitud |
| Area_Solicitante_ID | INT (FK) | Área que genera la solicitud |
| Area_Destinaria_ID | INT (FK) | Área responsable de atender la solicitud |
| Prioridad | ENUM ('Baja', 'Media', 'Alta') | Nivel de prioridad asignado |
| Estado | ENUM ('Pendiente', 'En Proceso', 'Resuelta', 'Rechazada') | Estado actual de la solicitud |
| Fecha_Creacion | DATETIME | Fecha y hora de creación de la solicitud |
| Fecha_Actualizacion | DATETIME | Fecha de la última modificación |

---

## 6. Preguntas abiertas y supuestos

*La entrevista deja temas sin cerrar. Documentá cada uno: qué dijeron, qué suponés vos y por qué.*

| Tema | Qué se dijo (resumen) | Tu supuesto | Justificación |
|------|------------------------|-------------|---------------|
| Uso de la prioridad para ordenar | Carlos pidió que las solicitudes de prioridad alta aparezcan primero, pero María indicó que la prioridad es solo informativa | La prioridad se utilizará únicamente para visualización y filtrado, sin modificar el orden del listado | La entrevista no define una regla oficial de ordenamiento por prioridad y María expresa explícitamente que su función principal es informativa |
| Reapertura de solicitudes rechazadas | Carlos comentó que a veces un pedido rechazado vuelve a presentarse con más información. Lucas respondió que “rechazada es rechazada” | En esta versión, el estado Rechazada se considera final y no puede reabrirse | No existe un proceso formal definido para la reapertura y mantener “Rechazada” como estado final simplifica el flujo inicial del sistema |
| Cancelación de solicitudes | María mencionó la necesidad de cancelar pedidos, aunque el sistema actual solo permite borrarlos cuando están pendientes | No se incorporará un estado “Cancelada”; las solicitudes pendientes podrán eliminarse | El escenario no define reglas ni transiciones para un estado de cancelación, por lo que se mantiene el comportamiento existente |
| Combinación de filtros | No quedó totalmente claro si los filtros de estado y prioridad debían funcionar juntos o por separado | Los filtros se combinarán aplicando ambas condiciones simultáneamente cuando estén seleccionadas | Es el comportamiento más útil para la operación diaria y evita resultados ambiguos al consultar solicitudes |
| Permisos y autenticación | Se indicó que solo el área destinataria debería cambiar estados, pero también se aclaró que actualmente no existe login | Cualquier usuario con acceso al sistema podrá ejecutar las acciones disponibles en esta versión | La entrevista reconoce explícitamente la ausencia de autenticación, por lo que el control real de permisos queda como mejora futura |

---

## 7. Requerimientos funcionales

*Tu especificación del módulo: qué debe hacer la pantalla desde la perspectiva del usuario.*

### Listado
**Respuesta:**

La pantalla principal deberá mostrar un listado con todas las solicitudes registradas en el sistema, cada registro deberá presentar el título de la solicitud, el área solicitante, el área destinataria, la prioridad y el estado actual.

Desde el listado, el usuario deberá poder acceder a las acciones disponibles para cada solicitud, como editar, eliminar o cambiar su estado, siguiendo las reglas de negocio predefinidas. El listado deberá poder actualizarse para poder reflejar los cambios hechos por el usuario.

### Alta, edición y baja
**Respuesta:**

El sistema deberá permitir registrar nuevas solicitudes ingresando el título, la descripción, el área solicitante, el área destinataria y la prioridad. Todos estos campos serán obligatorios. Las nuevas solicitudes deberán crearse automáticamente con el estado Pendiente.

Las solicitudes únicamente podrán editarse mientras permanezcan en estado Pendiente, si la solicitud ya se encuentra "En proceso", "Resuelta" o "Rechazada", no deberá permitirse su modificación.

De igual manera, solo podrán eliminarse las solicitudes en estado Pendiente. Antes de realizar la eliminación, el sistema deberá solicitar una confirmación al usuario para evitar eliminaciones accidentales.

### Cambio de estado
**Respuesta:**

El sistema deberá permitir modificar el estado de una solicitud respetando el flujo definido por las reglas de negocio, una solicitud podrá pasar de "Pendiente" a "En proceso" cuando sea tomada por el área destinataria. Luego, una solicitud "En proceso" podrá marcarse como "Resuelta".

También deberá existir la posibilidad de marcar una solicitud "Pendiente" como "Rechazada" cuando no corresponda su atención. No deberán permitirse cambios de estado que contradigan el flujo ya establecido, ni la reapertura de solicitudes rechazadas.

### Filtros y orden
**Respuesta:**

El listado deberá permitir filtrar las solicitudes por estado y por prioridad. Cuando ambos filtros se utilicen simultáneamente, el sistema deberá mostrar únicamente aquellas solicitudes que cumplan todas las condiciones seleccionadas.

Respecto al orden del listado, se mantendrá el orden predeterminado del sistema, ya que durante la entrevista no se definió una regla de negocio que establezca un ordenamiento por prioridad u otro criterio específico. La prioridad tendrá un carácter informativo y servirá como criterio de filtrado, pero no modificará el orden de visualización.

---

## 8. Fuera de alcance

*¿Qué excluirías de esta versión según la entrevista?*

**Respuesta:**

De acuerdo con la información obtenida durante la entrevista, se considera que las siguientes funcionalidades quedan fuera del alcance de esta versión del sistema:

* Implementación de autenticación de usuarios (inicio de sesión).
* Gestión de roles y permisos según el área o tipo de usuario.
* Historial de cambios o auditoría de las solicitudes.
* Reapertura de solicitudes rechazadas, ya que no existe una definición clara del proceso.
* Incorporación de un estado "Cancelada", debido a que no fue definido como parte del flujo de trabajo.
* Envío de notificaciones por correo electrónico u otros medios cuando una solicitud cambia de estado.
* Adjuntar archivos o documentación a las solicitudes.
* Comentarios o conversaciones entre las áreas involucradas.
* Ordenamiento automático de las solicitudes por prioridad, ya que durante la entrevista no se alcanzó un consenso sobre este comportamiento.
* Reportes, estadísticas o indicadores de gestión.

Estas funcionalidades podrían incorporarse en futuras versiones del sistema, pero no forman parte del alcance definido para esta prueba técnica.

---

## 9. Plan para la Instancia 2 (opcional)

*Sin ver el código todavía: ¿cómo abordarías la implementación o corrección una vez tengas acceso al repositorio?*

**Respuesta:**

Una vez obtenido el acceso al repositorio, el trabajo lo abordaré de forma progresiva para comprender el estado actual del proyecto antes de realizar modificaciones.

En primer lugar, revisaré la estructura del proyecto y la documentación disponible para identificar la organización del código y las tecnologías utilizadas. Después, ejecutaré la aplicación para verificar su funcionamiento y detectar posibles errores o comportamientos que no coincidan con los requerimientos definidos durante el análisis.

Luego analizaré el flujo de las principales funcionalidades (listado, alta, edición, baja, cambio de estado y filtros) con el objetivo de comparar el comportamiento actual con las reglas de negocio establecidas en la Instancia 1. Los problemas encontrados serán documentados antes de aplicar cualquier corrección.

Una vez identificado el origen de cada inconveniente, se realizarán las modificaciones necesarias tratando de mantener la estructura existente del proyecto y evitando cambios innecesarios. Después de cada corrección se ejecutarán pruebas funcionales para verificar que la funcionalidad opere correctamente y que no se introduzcan nuevos errores.

En el proceso documentaré las correcciones realizadas, las decisiones tomadas durante el desarrollo y las limitaciones encontradas, dejando el proyecto listo para su entrega.

---

*Fin de Instancia 1 — A partir de aquí podés trabajar en `Instancia-2-Desarrollo/`.*
