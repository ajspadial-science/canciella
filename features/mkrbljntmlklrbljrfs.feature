#language: es

Característica: Navegación por revistas del dominio mmbr.asm.org a través del proxy
  Para testear el proxy
  Como testeador
  Necesito navegar por la revistas del dominio mmbr.asm.org y chequear sus resultados

Escenario: Acceder al website de la revista Microbiology and Molecular Biology Reviews
  Cuando navego a la revista 'Microbiology and Molecular Biology Reviews' a través del proxy
  Entonces todos los enlaces devueltos acceden a traves del proxy 

Escenario: Acceder a un artículo de la revista Microbiology and Molecular Biology Reviews
  Dado que la revista 'Microbiology and Molecular Biology Reviews' tiene un artículo 'nombre_artículo'
  Cuando pongo 'nombre_artículo' en el cajón Buscar
  Y hago clic en primer enlace del resultado
  Entonces obtengo un artículo en formato pdf

