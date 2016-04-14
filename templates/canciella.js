(function() {

  var parseUrl = function (url) {
    var a = document.createElement('a');
    a.href = url;
    return {
      'scheme'   : a.protocol,
      'host'    : a.hostname,
      'port'     : a.port,
      'path'     : a.pathname,
      'query'    : a.search,
      'fragment' : a.hash,
    };
  }

  function appendProxy(href) {
    var baseUrl = "{{base_url}}";
    var url = "{{url}}";

    var parsedHref = parseUrl(href);

    if (parsedHref.scheme && parsedHref.host) {
      // absolute href in other or same domain
      return baseUrl.trim() + href.trim();
    } else {
      var parsedUrl = parseUrl(url);
      var scheme = parsedUrl.scheme + '//';
      var host = parsedUrl.host;
      var port = parsedUrl.port ? ':' + parsedUrl.port : '';
      var base = scheme + host + port + '/';

      var folder = '/';
      if (parsedUrl.path) {
        folder = parsedUrl.path.indexOf('/') !== -1 ? 
          parsedUrl.path.substring(0, parsedUrl.path.lastIndexOf('/')) :
          parsedUrl.path;
      }
    
      if (href.indexOf('/') === 0) {
        // absolute address in this domain
        href = href.endsWith('/') ? href.slice(1, -1) : href.slice(1);
        return baseUrl.trim() + base.trim() + href.trim();
      } else {
        // relative address in this domain
        return baseUrl.trim() + base.trim() + folder.trim() + '/' + href.trim();
      }
    }
  }

  var oldOnload = window.onload;
  window.onload = function() {
    if (oldOnload) {
      oldOnload.apply(this, arguments);
    }

    // 1. Modify every URL DOM 
    var tags = {
      'link' : 'href',
      'script': 'src',
      'a': 'href',
      'img': 'src',
    };
    for (var tagName in tags) {
      var attrName = tags[tagName];

      var changingTags = document.getElementsByTagName(tagName);
      for (var tag of changingTags) {
        if (tag.hasAttribute('data-canciella')) {
          continue;
        }
        if (tag.hasAttribute(attrName)) {
          var attr = tag.getAttribute(attrName);
          var proxiedAttr = appendProxy(attr);
          proxiedAttr += proxiedAttr.indexOf('?') === -1 ? '?' : '&';
          proxiedAttr += 'canciella-reload=' + new Date().getTime();

          tag.setAttribute(attrName, proxiedAttr);
          tag.setAttribute('data-canciella', 'modified-js');
        }
      }
    }

    // 2. Capture every call to XMLHttpRequest
    window.XMLHttpRequest.prototype.open = function(method, url){
      var newUrl = appendProxy(url);
      window.XMLHttpRequest.prototype.open.call(this, method, newUrl);
    };
  }
})();
