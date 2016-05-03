#language: es

Característica: Navegación por revistas del dominio www.forestprodjournals.org a través del proxy
  Para testear el proxy
  Como testeador
  Necesito navegar por la revistas del dominio www.forestprodjournals.org y chequear sus resultados

Escenario: Acceder al website de la revista &quot;Forest Products Journal.                     Poner en &quot;&quot;I am a nonmember suscriber&quot;&quot;   :13597  &quot;
  Cuando navego a la revista '&quot;Forest Products Journal.                     Poner en &quot;&quot;I am a nonmember suscriber&quot;&quot;   :13597  &quot;' a través del proxy
  Entonces todos los enlaces devueltos acceden a traves del proxy 

Escenario: Acceder a un artículo de la revista &quot;Forest Products Journal.                     Poner en &quot;&quot;I am a nonmember suscriber&quot;&quot;   :13597  &quot;
  Dado que la revista '&quot;Forest Products Journal.                     Poner en &quot;&quot;I am a nonmember suscriber&quot;&quot;   :13597  &quot;' tiene un artículo 'nombre_artículo'
  Cuando pongo 'nombre_artículo' en el cajón Buscar
  Y hago clic en primer enlace del resultado
  Entonces obtengo un artículo en formato pdf

