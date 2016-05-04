#language: es

Característica: Navegación por revistas del dominio link.springer.com a través del proxy
  Para testear el proxy
  Como testeador
  Necesito navegar por la revistas del dominio link.springer.com y chequear sus resultados

Escenario: Acceder al website de la revista A Quarterly Journal of Operations Research: 4OR
  Cuando navego a la revista 'A Quarterly Journal of Operations Research: 4OR' a través del proxy
  Entonces todos los enlaces devueltos acceden a traves del proxy 

Escenario: Acceder a un artículo de la revista A Quarterly Journal of Operations Research: 4OR
  Dado que la revista 'A Quarterly Journal of Operations Research: 4OR' tiene un artículo 'Improved algorithms for single machine scheduling with release dates and rejections'
  Cuando pongo 'Improved algorithms for single machine scheduling with release dates and rejections' en el cajón Buscar
  Y hago clic en primer enlace del resultado
  Entonces obtengo un artículo en formato pdf

