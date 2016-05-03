#language: es

Característica: Navegación por revistas del dominio jgv.sgmjournals.org a través del proxy
  Para testear el proxy
  Como testeador
  Necesito navegar por la revistas del dominio jgv.sgmjournals.org y chequear sus resultados

Escenario: Acceder al website de la revista Journal of General Virology
  Cuando navego a la revista 'Journal of General Virology' a través del proxy
  Entonces todos los enlaces devueltos acceden a traves del proxy 

Escenario: Acceder a un artículo de la revista Journal of General Virology
  Dado que la revista 'Journal of General Virology' tiene un artículo 'nombre_artículo'
  Cuando pongo 'nombre_artículo' en el cajón Buscar
  Y hago clic en primer enlace del resultado
  Entonces obtengo un artículo en formato pdf

