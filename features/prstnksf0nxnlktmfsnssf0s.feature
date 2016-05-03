#language: es

Característica: Navegación por revistas del dominio www.pnas.org a través del proxy
  Para testear el proxy
  Como testeador
  Necesito navegar por la revistas del dominio www.pnas.org y chequear sus resultados

Escenario: Acceder al website de la revista Proceedings of the National Academy of Sciences of the USA
  Cuando navego a la revista 'Proceedings of the National Academy of Sciences of the USA' a través del proxy
  Entonces todos los enlaces devueltos acceden a traves del proxy 

Escenario: Acceder a un artículo de la revista Proceedings of the National Academy of Sciences of the USA
  Dado que la revista 'Proceedings of the National Academy of Sciences of the USA' tiene un artículo 'nombre_artículo'
  Cuando pongo 'nombre_artículo' en el cajón Buscar
  Y hago clic en primer enlace del resultado
  Entonces obtengo un artículo en formato pdf

