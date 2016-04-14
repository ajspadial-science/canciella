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

    return baseUrl + url;
  }

  return function() {
    // 1. Modify every URL DOM 

    // 2. Capture every call to XMLHttpRequest
    window.XMLHttpRequest.prototype.open = function(method, url){
      var newUrl = appendProxy(url);
      window.XMLHttpRequest.prototype.open.call(this, method, newUrl);
    };
  }
})();
