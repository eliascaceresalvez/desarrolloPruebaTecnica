# Plantilla de Entrega — Instancia 2

> Completar junto con el código corregido.  
> Nombre del candidato: _______________________  
> Fecha de entrega: _______________________  
> URL del repositorio público: _______________________  
> **Enviar la URL por email antes del jueves 16/07/2026, 23:00 hs** al contacto principal: **direcciondegestioninformatica@diputadosmisiones.gov.ar** (Lun–Vie, 8:00–12:00 hs). Contacto secundario: ver [Consigna-General.md](../Consigna-General.md#entrega-y-contacto).

**Orden sugerido:** Instancia 1 terminada → levantar entorno → §1 (diagnóstico, **antes** de corregir) → corregir `codigo-base/` → §2–4 → §5 (log IA, al final).

**Análisis de negocio:** entregado en `Instancia-1-Analisis/Plantilla-Analisis.md`.

---

## 1. Diagnóstico de bugs (antes de corregir)

| # | Bug / síntoma | Archivo | Evidencia | Hipótesis de causa |
|---|---------------|---------|-----------|-------------------|
| 1 | | | | |
| 2 | | | | |
| 3 | | | | |
| 4 | | | | |
| 5 | | | | |

*(Agregar filas si encontrás más fallos.)*

---

## 2. Resumen de cambios realizados

| Archivo modificado | Qué se cambió | Por qué (vincular con Instancia 1 si aplica) |
|--------------------|---------------|---------------------------------------------|
| | | |

---

## 3. Funcionalidades implementadas

- [ ] ABM básico funcional
- [ ] Reglas de edición/eliminación según estado
- [ ] Cambio de estado con reglas de negocio
- [ ] Filtros / orden según Instancia 1
- [ ] Otro: _______________________

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


### Prompt 1
* **Usuario  :** "Tengo una duda sobre este escenario, estoy haciendo una prueba técnica y necesito saber ¿Qué necesidad de negocio describe esta entrevista? y qué problema resuelve el módulo"
* **Respuesta de la IA:** Identificó la necesidad central del negocio (gestionar de forma centralizada y transparente el ciclo de vida de las solicitudes internas de servicios o tareas entre diferentes áreas) y el problema raíz que viene a resolver el módulo (el caos operativo, la informalidad de WhatsApp/mails y la pérdida de información que ocurrían con el esquema anterior).
* **Validación Manual:** Se agregó contenido y se modificaron los nombres de categorías de necesidades y algunos conceptos.

### Prompt 2
* **Usuario  :** "¿Qué actores salen de esta entrevista? y cual es su rol"
* **Respuesta de la IA:** Clasificó y detalló los tres roles principales del negocio representados por los entrevistados (Área Solicitante - María, Área Destinataria/Resolutora - Lucas, Área de Gestión/Compras - Carlos) y el rol técnico indirecto (Área de Sistemas).

### Prompt 3
* **Usuario  :** "el area de compras es mas una gestion de pedidos?"
* **Respuesta de la IA:** Confirmó que operativamente funciona como un área de gestión y resolución de pedidos en este software, pero destacó su particularidad crítica: la necesidad excepcional de reabrir solicitudes rechazadas debido a errores frecuentes en la confección.

### Prompt 4
* **Usuario  :** "arma un DER en formato markdown para representar el flujo de procesos del negocio"
* **Respuesta de la IA:** Proveyó un Diagrama Entidad-Relación en código Mermaid estructurando las tablas `SOLICITUD`, `ESTADO` y `PRIORIDAD`, acompañado de su correspondiente diccionario de datos con tipos de campos, claves primarias/foráneas y restricciones `NOT NULL`.

### Prompt 5
* **Usuario  :** "arma un UML del flujo de ciclo de vida de una solicitud (estados y transiciones). Formato grafico para Markdown"
* **Respuesta de la IA:** Generó un Diagrama de Máquina de Estados UML en sintaxis Mermaid que modela el ciclo de vida (Pendiente, En Proceso, Resuelta, Rechazada), incluyendo las condiciones de bloqueo de edición y la transición especial de reapertura sugerida por Compras.

### Prompt 6
* **Usuario  :** "en el documento markdown no se puede ver el grafico con el codigo que has hecho"
* **Respuesta de la IA:** Explicó que el código Mermaid requiere un entorno compatible para renderizarse de forma gráfica. Brindó tres alternativas para solucionarlo (Mermaid Live Editor, extensiones para VS Code y el soporte nativo de GitHub) y ofreció un diagrama alternativo en formato de texto plano (ASCII).

### Prompt 7
* **Usuario  :** "*Listá las reglas que inferís del escenario. Separá las que están claras de las que dependen de un supuesto (§6).*

| Regla | ¿Explícita en la entrevista? | Notas |
|-------|------------------------------|-------|
|  |  |  |
|  |  |  |"
* **Respuesta de la IA:** Completó la matriz de análisis solicitada, distribuyendo las reglas identificadas entre explícitas (obligatoriedad, inmutabilidad, confirmación de borrado) y aquellas que dependen de un supuesto por contradicción de los usuarios (ordenamiento, reapertura, filtros combinados).

### Prompt 8
* **Usuario  :** "las que dejaste como explicitas en la entrevista, actualmente ¿Cuenta con funcionalidad? Es decir, estan implementadas al momento de la entrevista"
* **Respuesta de la IA:** Detalló el diagnóstico técnico real del módulo legacy en el momento de la conversación, aclarando que la mayoría de las reglas explícitas del negocio no están implementadas o fallan en el sistema (por falta de login, falta de confirmación de borrado y falta de bloqueo de updates en base de datos).

### Prompt 9
* **Usuario  :** "**Analista:** Vi filtros arriba del listado.

**María:** Sí, por **estado** y por **prioridad**. Los pusieron hace poco; no estamos seguros de que hagan lo que cada área necesita. Nadie me explicó si filtran solo lo que ya está en pantalla o si van a la base.

**Lucas:** Yo asumo que si elijo “pendiente” y “alta” me muestra solo esas. Las dos cosas juntas.

---

Me parece que acá podría haber una regla pero los usuarios del sistema no deberían estar confundidos si esto va a la base o no porque ellos desconocen como trabaja el área de sistemas con la base de datos. Pero lo que si estamos seguros es que todo lo que ven en pantalla debería provenir de la base de datos. Necesito que expliques mas en detalle lo que escribiste como posible regla"
* **Respuesta de la IA:** Validó el análisis del usuario. Explicó que la confusión del negocio devela un mal comportamiento técnico (filtros no acumulativos o filtrado local del navegador). Definió la regla formal como un mecanismo de filtrado combinado acumulativo (Lógica `AND`) procesado estrictamente del lado del servidor.

### Prompt 10
* **Usuario  :** "entonces esta puede ser la regla final para la documentacion?

| **Filtros Combinados:** El listado debe permitir filtrar por "Estado" y por "Prioridad" en simultáneo. | No (Depende de Supuesto) | La duda de los usuarios de si los filtros por estado y prioridad están funcionando correctamente y en simultaneo se resuelve estableciendo una regla de filtrado combinado que bien podría realizarse con una consulta a la base de datos mediante un **INNER JOIN** de estado y prioridad de cada solicitud. |"
* **Respuesta de la IA:** Validó la propuesta técnica del usuario y sugirió un refinamiento formal en la redacción de la nota del supuesto, reemplazando el potencial por una definición firme de diseño técnico basado en lógica `AND` e `INNER JOIN` de base de datos.

---

## 6. Autoevaluación (opcional)

| Criterio | 0 | 1 | 2 | 3 | Comentario |
|----------|---|---|---|---|------------|
| Diagnóstico de bugs | | | | | |
| Coherencia Inst. 1 ↔ código | | | | | |
| Calidad del código | | | | | |
