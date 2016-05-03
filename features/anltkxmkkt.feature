#language: es

Característica: Navegación por revistas del dominio www.sciencedirect.com a través del proxy
  Para testear el proxy
  Como testeador
  Necesito navegar por la revistas del dominio www.sciencedirect.com y chequear sus resultados

Escenario: Acceder al website de la revista Analytica Chimica Acta
  Cuando navego a la revista 'Analytica Chimica Acta' a través del proxy
  Entonces todos los enlaces devueltos acceden a traves del proxy 

Escenario: Acceder a un artículo de la revista Analytica Chimica Acta
  Dado que la revista 'Analytica Chimica Acta' tiene un artículo 'nombre_artículo'
  Cuando pongo 'nombre_artículo' en el cajón Buscar
  Y hago clic en primer enlace del resultado
  Entonces obtengo un artículo en formato pdf

