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



---

## 6. Preguntas abiertas y supuestos

*La entrevista deja temas sin cerrar. Documentá cada uno: qué dijeron, qué suponés vos y por qué.*

| Tema | Qué se dijo (resumen) | Tu supuesto | Justificación |
|------|------------------------|-------------|---------------|
| | | | |
| | | | |
| | | | |
| | | | |

---

## 7. Requerimientos funcionales

*Tu especificación del módulo: qué debe hacer la pantalla desde la perspectiva del usuario.*

### Listado
**Respuesta:**



### Alta, edición y baja
**Respuesta:**



### Cambio de estado
**Respuesta:**



### Filtros y orden
**Respuesta:**



---

## 8. Fuera de alcance

*¿Qué excluirías de esta versión según la entrevista?*

**Respuesta:**



---

## 9. Plan para la Instancia 2 (opcional)

*Sin ver el código todavía: ¿cómo abordarías la implementación o corrección una vez tengas acceso al repositorio?*

**Respuesta:**



---

*Fin de Instancia 1 — A partir de aquí podés trabajar en `Instancia-2-Desarrollo/`.*
