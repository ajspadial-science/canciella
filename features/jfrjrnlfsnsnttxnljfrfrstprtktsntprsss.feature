#language: es

Característica: Navegación por revistas del dominio www.paptac.ca a través del proxy
  Para testear el proxy
  Como testeador
  Necesito navegar por la revistas del dominio www.paptac.ca y chequear sus resultados

Escenario: Acceder al website de la revista J-FOR Journal of Science and Technology for Forest Products and Processes
  Cuando navego a la revista 'J-FOR Journal of Science and Technology for Forest Products and Processes' a través del proxy
  Entonces todos los enlaces devueltos acceden a traves del proxy 

Escenario: Acceder a un artículo de la revista J-FOR Journal of Science and Technology for Forest Products and Processes
  Dado que la revista 'J-FOR Journal of Science and Technology for Forest Products and Processes' tiene un artículo 'nombre_artículo'
  Cuando pongo 'nombre_artículo' en el cajón Buscar
  Y hago clic en primer enlace del resultado
  Entonces obtengo un artículo en formato pdf

