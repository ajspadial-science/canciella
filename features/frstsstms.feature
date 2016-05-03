#language: es

Característica: Navegación por revistas del dominio www.inia.es a través del proxy
  Para testear el proxy
  Como testeador
  Necesito navegar por la revistas del dominio www.inia.es y chequear sus resultados

Escenario: Acceder al website de la revista Forest Systems
  Cuando navego a la revista 'Forest Systems' a través del proxy
  Entonces todos los enlaces devueltos acceden a traves del proxy 

Escenario: Acceder a un artículo de la revista Forest Systems
  Dado que la revista 'Forest Systems' tiene un artículo 'nombre_artículo'
  Cuando pongo 'nombre_artículo' en el cajón Buscar
  Y hago clic en primer enlace del resultado
  Entonces obtengo un artículo en formato pdf

