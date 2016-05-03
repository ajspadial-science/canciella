#language: es

Característica: Navegación por revistas del dominio arjournals.annualreviews.org a través del proxy
  Para testear el proxy
  Como testeador
  Necesito navegar por la revistas del dominio arjournals.annualreviews.org y chequear sus resultados

Escenario: Acceder al website de la revista Annual Review of Biochemistry
  Cuando navego a la revista 'Annual Review of Biochemistry' a través del proxy
  Entonces todos los enlaces devueltos acceden a traves del proxy 

Escenario: Acceder a un artículo de la revista Annual Review of Biochemistry
  Dado que la revista 'Annual Review of Biochemistry' tiene un artículo 'nombre_artículo'
  Cuando pongo 'nombre_artículo' en el cajón Buscar
  Y hago clic en primer enlace del resultado
  Entonces obtengo un artículo en formato pdf

