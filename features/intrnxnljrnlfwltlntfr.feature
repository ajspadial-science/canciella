#language: es

Característica: Navegación por revistas del dominio www.publish.csiro.au a través del proxy
  Para testear el proxy
  Como testeador
  Necesito navegar por la revistas del dominio www.publish.csiro.au y chequear sus resultados

Escenario: Acceder al website de la revista International Journal of Wildland Fire
  Cuando navego a la revista 'International Journal of Wildland Fire' a través del proxy
  Entonces todos los enlaces devueltos acceden a traves del proxy 

Escenario: Acceder a un artículo de la revista International Journal of Wildland Fire
  Dado que la revista 'International Journal of Wildland Fire' tiene un artículo 'nombre_artículo'
  Cuando pongo 'nombre_artículo' en el cajón Buscar
  Y hago clic en primer enlace del resultado
  Entonces obtengo un artículo en formato pdf

