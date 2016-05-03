#language: es

Característica: Navegación por revistas del dominio ovidsp.tx.ovid.com a través del proxy
  Para testear el proxy
  Como testeador
  Necesito navegar por la revistas del dominio ovidsp.tx.ovid.com y chequear sus resultados

Escenario: Acceder al website de la revista Biological Abstracts (base de datos)
  Cuando navego a la revista 'Biological Abstracts (base de datos)' a través del proxy
  Entonces todos los enlaces devueltos acceden a traves del proxy 

Escenario: Acceder a un artículo de la revista Biological Abstracts (base de datos)
  Dado que la revista 'Biological Abstracts (base de datos)' tiene un artículo 'nombre_artículo'
  Cuando pongo 'nombre_artículo' en el cajón Buscar
  Y hago clic en primer enlace del resultado
  Entonces obtengo un artículo en formato pdf

