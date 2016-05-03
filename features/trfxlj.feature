#language: es

Característica: Navegación por revistas del dominio treephys.oxfordjournals.org a través del proxy
  Para testear el proxy
  Como testeador
  Necesito navegar por la revistas del dominio treephys.oxfordjournals.org y chequear sus resultados

Escenario: Acceder al website de la revista Tree Physiology
  Cuando navego a la revista 'Tree Physiology' a través del proxy
  Entonces todos los enlaces devueltos acceden a traves del proxy 

Escenario: Acceder a un artículo de la revista Tree Physiology
  Dado que la revista 'Tree Physiology' tiene un artículo 'nombre_artículo'
  Cuando pongo 'nombre_artículo' en el cajón Buscar
  Y hago clic en primer enlace del resultado
  Entonces obtengo un artículo en formato pdf

