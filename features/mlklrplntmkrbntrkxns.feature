#language: es

Característica: Navegación por revistas del dominio apsjournals.apsnet.org a través del proxy
  Para testear el proxy
  Como testeador
  Necesito navegar por la revistas del dominio apsjournals.apsnet.org y chequear sus resultados

Escenario: Acceder al website de la revista Molecular Plant-Microbe Interactions
  Cuando navego a la revista 'Molecular Plant-Microbe Interactions' a través del proxy
  Entonces todos los enlaces devueltos acceden a traves del proxy 

Escenario: Acceder a un artículo de la revista Molecular Plant-Microbe Interactions
  Dado que la revista 'Molecular Plant-Microbe Interactions' tiene un artículo 'nombre_artículo'
  Cuando pongo 'nombre_artículo' en el cajón Buscar
  Y hago clic en primer enlace del resultado
  Entonces obtengo un artículo en formato pdf

