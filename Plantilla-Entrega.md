# Plantilla de Entrega — Instancia 2

> Completar junto con el código corregido.  
> Nombre del candidato: Elías Martín Cáceres Alvez  
> Fecha de entrega: _______________________  
> URL del repositorio público: https://github.com/eliascaceresalvez/desarrolloPruebaTecnica  
> **Enviar la URL por email antes del jueves 16/07/2026, 23:00 hs** al contacto principal: **direcciondegestioninformatica@diputadosmisiones.gov.ar** (Lun–Vie, 8:00–12:00 hs). Contacto secundario: ver [Consigna-General.md](../Consigna-General.md#entrega-y-contacto).

**Orden sugerido:** Instancia 1 terminada → levantar entorno → §1 (diagnóstico, **antes** de corregir) → corregir `codigo-base/` → §2–4 → §5 (log IA, al final).

**Análisis de negocio:** entregado en `Instancia-1-Analisis/Plantilla-Analisis.md`.

---

## 1. Diagnóstico de bugs (antes de corregir)

| # | Bug / síntoma | Archivo | Evidencia | Hipótesis de causa |
|---|---------------|---------|-----------|-------------------|
| 1 | La aplicación no inicia correctamente | src/models/Database.php y src/controllers/api.php | Se detectó la ausencia de un punto y coma en Database.php y una llave de cierre faltante en api.php, lo que provoca Parse Error al ejecutar la aplicación | Es probable que los archivos hayan quedado con errores durante una refactorización o edición y no se hayan ejecutado pruebas de sintaxis antes de incorporarlos al proyecto |
| 2 | No es posible crear nuevas solicitudes | index.html y assets/js/app.js | El campo titulo no tiene name y createSolicitud() usa await sin async | Es probable que el formulario y la lógica JavaScript hayan sido modificados de forma independiente, generando inconsistencias entre la vista y el código del cliente |
| 3 | Los filtros no funcionan | assets/js/app.js y src/models/Solicitud.php | La interfaz permite seleccionar filtros, la API los recibe, pero el modelo no los utiliza | La funcionalidad parece haber quedado implementada solo de forma parcial, completando la interfaz y la API, pero sin finalizar la lógica de consulta en el modelo |
| 4 | Se permite editar y eliminar solicitudes que no deberían modificarse | src/models/Solicitud.php y src/controllers/api.php | No existen validaciones sobre el estado antes de actualizar o eliminar registros. | Es probable que inicialmente se implementara únicamente el CRUD básico y que las reglas de negocio definidas posteriormente no se incorporaran al backend |
| 5 | El cambio de estado acepta cualquier transición | src/models/Solicitud.php y src/controllers/api.php | No se valida el flujo de estados ni los valores permitidos | Es probable que la implementación priorizara la actualización del estado sin incorporar las restricciones del proceso definidas por el negocio |

*(Agregar filas si encontrás más fallos.)*

---

## 2. Resumen de cambios realizados

| Archivo modificado | Qué se cambió | Por qué (vincular con Instancia 1 si aplica) |
|--------------------|---------------|---------------------------------------------|
| src/models/Database.php | Se corrigió un error de sintaxis agregando el punto y coma faltante entre las llamadas a setAttribute() de PDO | Permitir que la conexión a la base de datos se inicialice correctamente y evitar un error de sintaxis que impedía ejecutar la aplicación |
| src/controllers/api.php | Se cerró correctamente el bloque try/catch y el método handleRequest() agregando la llave faltante | Corregir un error de sintaxis que impedía cargar la API y procesar las solicitudes HTTP |
| assets/js/app.js | Se declaró la función createSolicitud() como asíncrona (async) para permitir el uso correcto de await | Corregir un error de JavaScript que impedía ejecutar la lógica de creación de solicitudes y el funcionamiento del frontend |
| index.html | Se agregó el atributo name="titulo" al campo de título del formulario | Permitir que el formulario envíe correctamente el título al backend, cumpliendo con el requerimiento funcional de registrar nuevas solicitudes |
| assets/js/app.js | Se modificó la carga del listado para enviar los filtros seleccionados al backend | Implementar el requerimiento funcional de filtrado por estado y prioridad |
| src/models/Solicitud.php | Se implementó el filtrado dinámico en la consulta SQL según los parámetros recibidos | Permitir que el sistema muestre únicamente las solicitudes que cumplen los criterios seleccionados por el usuario |
| src/models/Solicitud.php | Se agregaron validaciones para impedir editar solicitudes cuyo estado sea distinto de pendiente | Aplicar la regla de negocio definida durante el análisis funcional |
| src/models/Solicitud.php | Se agregaron validaciones para impedir eliminar solicitudes que ya iniciaron su tratamiento o fueron finalizadas | Garantizar la integridad del proceso y respetar las reglas de negocio establecidas |
| src/models/Solicitud.php | Se validaron las transiciones permitidas entre estados antes de realizar el cambio | Evitar cambios de estado inconsistentes con el flujo definido en la Instancia 1 |
| src/controllers/api.php | Se modificó el manejo de excepciones para devolver mensajes claros al cliente cuando se incumplen reglas de negocio. | Mejorar la respuesta de la API y evitar clasificar errores funcionales como errores internos del servidor |

---

## 3. Funcionalidades implementadas

- [x] ABM básico funcional
- [x] Reglas de edición/eliminación según estado
- [x] Cambio de estado con reglas de negocio
- [x] Filtros / orden según Instancia 1
- [x] Otro: Validaciones de campos obligatorios en frontend y backend

---

## 4. Instrucciones de ejecución

**Requisitos:** PHP 7+, MySQL, servidor web local.

1. Base de datos:
   ```
   mysql -u root -p < Instancia-2-Desarrollo/codigo-base/sql/database.sql
   ```
2. Configuración:
   ```
   cp Instancia-2-Desarrollo/codigo-base/config/config_example.php \
      Instancia-2-Desarrollo/codigo-base/config/config.php
   ```
3. Servidor (ejemplo):
   ```
   cd Instancia-2-Desarrollo/codigo-base && php -S localhost:8080
   ```
4. URL: `http://localhost:8080/index.html`
5. Problemas conocidos / pendientes:

---

## 5. Declaración de IA

**¿Usaste herramientas de IA?** (Sí)

**Herramientas utilizadas:** Gemini 3.5 Flash

## Log de prompts y validaciones manuales:

Instancia-1-Analisis/log-prompts-validaciones-manuales.md

## Uso realizado:
* apoyo en el análisis funcional;
* revisión del código;
* explicación de errores;
* propuestas de corrección;
* validación manual de los cambios implementados.

Todas las modificaciones fueron revisadas, adaptadas y probadas manualmente antes de incorporarlas al proyecto.

---

## 6. Autoevaluación (opcional)

| Criterio | 0 | 1 | 2 | 3 | Comentario |
|----------|---|---|---|---|------------|
| Diagnóstico de bugs | | | | | |
| Coherencia Inst. 1 ↔ código | | | | | |
| Calidad del código | | | | | |
