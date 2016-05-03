#language: es

Característica: Navegación por revistas del dominio www.nrcresearchpress.com a través del proxy
  Para testear el proxy
  Como testeador
  Necesito navegar por la revistas del dominio www.nrcresearchpress.com y chequear sus resultados

Escenario: Acceder al website de la revista Canadian Journal of Forest Research
  Cuando navego a la revista 'Canadian Journal of Forest Research' a través del proxy
  Entonces todos los enlaces devueltos acceden a traves del proxy 

Escenario: Acceder a un artículo de la revista Canadian Journal of Forest Research
  Dado que la revista 'Canadian Journal of Forest Research' tiene un artículo 'nombre_artículo'
  Cuando pongo 'nombre_artículo' en el cajón Buscar
  Y hago clic en primer enlace del resultado
  Entonces obtengo un artículo en formato pdf

