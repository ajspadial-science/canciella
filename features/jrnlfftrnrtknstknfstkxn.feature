#language: es

Característica: Navegación por revistas del dominio vdi.sagepub.com a través del proxy
  Para testear el proxy
  Como testeador
  Necesito navegar por la revistas del dominio vdi.sagepub.com y chequear sus resultados

Escenario: Acceder al website de la revista Journal of Veterinary Diagnostic Investigation
  Cuando navego a la revista 'Journal of Veterinary Diagnostic Investigation' a través del proxy
  Entonces todos los enlaces devueltos acceden a traves del proxy 

Escenario: Acceder a un artículo de la revista Journal of Veterinary Diagnostic Investigation
  Dado que la revista 'Journal of Veterinary Diagnostic Investigation' tiene un artículo 'nombre_artículo'
  Cuando pongo 'nombre_artículo' en el cajón Buscar
  Y hago clic en primer enlace del resultado
  Entonces obtengo un artículo en formato pdf

