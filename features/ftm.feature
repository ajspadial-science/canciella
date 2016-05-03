#language: es

Característica: Navegación por revistas del dominio www.phytomadigital.com a través del proxy
  Para testear el proxy
  Como testeador
  Necesito navegar por la revistas del dominio www.phytomadigital.com y chequear sus resultados

Escenario: Acceder al website de la revista Phytoma
  Cuando navego a la revista 'Phytoma' a través del proxy
  Entonces todos los enlaces devueltos acceden a traves del proxy 

Escenario: Acceder a un artículo de la revista Phytoma
  Dado que la revista 'Phytoma' tiene un artículo 'nombre_artículo'
  Cuando pongo 'nombre_artículo' en el cajón Buscar
  Y hago clic en primer enlace del resultado
  Entonces obtengo un artículo en formato pdf

