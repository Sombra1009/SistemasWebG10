# SistemasWebG10

# Feedback de la P2

## Funcionalidades implementadas

1. 
2. 

## Calificación: 10 / 10
## Memoria (hasta 2 puntos) (2 / 2)

- [ ] La memoria tiene al menos las secciones solicitadas (0.5 puntos)

- [ ] Los listados de scripts se limitan a las funcionalidades implementadas (0.5 puntos)
- [ ] Los listados de scripts parece que cubren todas las funcionalidades de la aplicación (1 punto)

- [ ] El diagrama de base de datos cubre las funcionalidades implementadas (0.25 puntos)
- [ ] El diagrama de base de datos parece cubrir todas las funcionalidades de la aplicación (0.5 puntos)

Contenido:
- [ ] Listado de scripts para las vistas
- [ ] Listado de scripts adicionales
- [ ] Estructura de la base de datos
- [ ] Prototipo funcional del proyecto

### Comentarios sobre la memoria

#### Listado de scripts de vista

#### Listado de otros scripts

#### Estructura de la BD

## HTML (hasta 1 puntos) (1 / 1)

- [ ] Hay errores graves en el HTML (0 puntos)
- [ ] Hay bastantes errores en el HTML (0.5 puntos)
- [ ] Hay algunos errores en el HTML (0.75 puntos)
- [ ] Se hace un uso adecuado de las etiquetas (1 punto)

## Prototipo del Proyecto (hasta 7 puntos) (7 / 7)

- [ ] La primera funcionalidad no funciona o tiene bastantes errores (0 puntos)
- [ ] La primera funcionalidad tiene bastantes errores o no funciona adecuadamente (0.75 puntos)
- [ ] La primera funcionalidad implementada falla en algunos casos (1.5 puntos)
- [ ] La primera funcionalidad implementada funciona correctamente (2 puntos)

- [ ] La segunda funcionalidad no funciona o tiene bastantes errores (0 puntos)
- [ ] La segunda funcionalidad tiene bastantes errores o no funciona adecuadamente (0.75 puntos)
- [ ] La segunda funcionalidad implementada falla en algunos casos (1.5 puntos)
- [ ] La segunda funcionalidad implementada funcionada correctamente (2 puntos)

- [ ] No existe una separación clara entre scripts de vista y scripts de lógica (0 puntos)
- [ ] Existe una separación clara entre scripts de vista y scripts de lógica (1 puntos).
- [ ] Existe una separación clara entre scripts de vista y scripts de lógica. Además la lógica en los scripts de vista es concentrada al comienzo del script y se utilizan funciones de apoyo para simplificar la generación y el mantenimiento del HTML de las páginas. (1.5 puntos)


- [ ] El código contiene bastantes errores comunes (0 puntos)
- [ ] El código contiene algunos errores comunes (0.75 puntos)
- [ ] El código no contiene errores comunes (1.5 puntos)
Puntos adicionales que compensan los errores de este apartado:
- [ ] La solución utiliza orientación a objetos al menos para las clases de entidad de la aplicación (+0.5 puntos)
- [ ] Las clases de entidad se encargan de la gestión de acceso a la base de datos (o bien se aplica otro patrón más avanzado como el DAO) (+0.5 puntos)

Errores comunes encontrados:
- [ ] No se liberan recursos $rs->free() cuando se lanza una consulta SELECT.
- [ ] Las operaciones de base de datos no escapan ($conn->real_escape_string()) los parámetros del usuario.
- [ ] No se utiliza HTTP POST cuando la operación modifica el estado del servidor.
- [ ] Los datos que provienen del usuario no se validan adecuadamente.
- [ ] Las clases de entidad (e.g. Usuario, Mensaje, etc.) generan HTML. Las clases de entidad no deben de tener esa responsabilidad.
- [ ] Las operaciones de BD devuelven arrays cuyo contenido son directamente las filas que se obtienen de la base de datos y no instancias de la clase correspondiente.

# Feedback de la P1 Nota: 
## Evaluación de las páginas (hasta 4 puntos) 

### index.html (hasta 0.5 puntos) 
    Contenido solicitado:
        - [ ] Incluye título 
        - [ ] Incluye logotipo 
        - [ ] Incluye descripción / breve resumen 

    Evaluación de este apartado: 
        - [ ] No se incluye el contenido solicitado en el enunciado (0 puntos) 
        - [ ] No se incluye todo el contenido solicitado en el enunciado (0.25 puntos) 
        - [ ] Se incluye el contenido solicitado en el enunciado (0.5 puntos) 
        - [ ] Valida W3C 
    
### miembros.html (hasta 0.5 puntos) 
    Contenido solicitado: 
        - [ ] Incluye el listado con todos los integrantes del grupo al comienzo de la página. 
        - [ ] Las descripciones contienen la información solicitada 
    
    Evaluación de este apartado: 
        - [ ] No se incluye el contenido solicitado en el enunciado (0 puntos) 
        - [ ] No se incluye todo el contenido solicitado en el enunciado (0.25 puntos) 
        - [ ] Se incluye el contenido solicitado en el enunciado (0.5 puntos) 
        - [ ] Valida W3C 
    
### planificacion.html (hasta 0.5 puntos) 
    - [ ] No se incluye el contenido solicitado en el enunciado (0 puntos) 
    - [ ] Se incluye la tabla de hitos solicitada con los hitos del proyecto (+0.25 puntos) 
    - [ ] Incluye información acerca de la planificación del proyecto (descripción, gantt o similar) (+0.25 puntos) 
    - [ ] Valida W3C 
    
### contacto.html (hasta 0.5 puntos) 
    - [ ] No se incluye el contenido solicitado en el enunciado y no funciona (0 puntos) 
    - [ ] El formulario incluye todo el contenido solicitado (+0.25 puntos) 
    - [ ] Se puede interactuar con el formulario (+0.25 puntos) 
    - [ ] Valida W3C 
    
    Comentarios:
    Errores habituales: 
        - El formulario no es interactivo. 
        - Utilizando enctype="text/plain" en el contenido del mensaje es legible. 
        - Las etiquetas no están relacionadas con sus componentes con el atributo for. 

### Uso adecuado del HTML (hasta 2 puntos) 
    - [ ] Hay errores graves en el HTML (0 puntos) 
    - [ ] Hay bastantes errores en el HTML (0.5 puntos) 
    - [ ] Hay algunos errores en el HTML (0.75 puntos) 
    - [ ] Se hace un uso adecuado de las etiquetas (1.25 puntos) 
    - [ ] Se utiliza una amplia variedad de etiquetas HTML (+0.25 puntos). 
    - [ ] La mayoría de las páginas pasan el validador W3C (+0.25 puntos). 
    - [ ] Todas las páginas pasan el validador W3C (+0.5 puntos). 

    Comentarios: 
    Errores habituales: 
        - No se puede utilizar
        - Se han utilizado para modificar el aspecto pero no tiene sentido representar la información mediante una tabla. 

## Evaluación de la descripción del proyecto (hasta 6 puntos) 
### Evaluación de los bocetos (hasta 4 puntos) 
    - [ ] No se proporcionan los bocetos mínimos para entender las funcionalidades de la aplicación (0 puntos) 
    - [ ] Faltan bastantes bocetos para las funcionalidades de la aplicación (1 puntos). 
    - [ ] Faltan bocetos para algunas de las funcionalidades de la aplicación (1.5 puntos). 
    - [ ] Todas funcionalidades tienen al menos 2 bocetos (2 puntos). 
    - [ ] No se proporcionan las descripciones adecuadas para entender el flujo entre páginas (0 puntos) 
    - [ ] Algunos de los bocetos tienen descripciones adecuadas para entender el flujo entre páginas (0.5 puntos) 
    - [ ] La mayoría de los bocetos tienen descripciones adecuadas para entender el flujo entre páginas (1 puntos) 
    - [ ] Todos los bocetos tienen descripciones adecuadas para entender el flujo entre páginas (1.5 puntos) 
    - [ ] El HTML es adecuado (+0.25 puntos) 
    - [ ] La página valida en el validador del W3C (+0.25) 

### Evaluación de la descripción (hasta 2 puntos) 
    - [ ] Descripción de la funcionalidad y/o roles insuficiente (0 puntos) 
    - [ ] Se proporciona suficiente detalle de la funcionalidad de la aplicación (+0.5 puntos) 
    - [ ] Se proporciona suficiente detalle de los tipos de usuarios / roles de la aplicación (+0.5 puntos) 
    - [ ] La descripción es suficiente para entender la idea general de la aplicación (+0.5 puntos) 
    - [ ] El HTML es adecuado (+0.25 puntos) 
    - [ ] La página valida en el validador del W3C (+0.25 puntos) 
    Comentarios: