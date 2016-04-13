(function() {

  function parseURL (url) {
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
    var base_url = "{{base_url}}";
    var url = "{{url}}";

    return base_url + url;
  }

  return function() {
    // 1. Modify every URL DOM 

    // 2. Capture every call to XMLHttpRequest
    window.XMLHttpRequest.prototype.open = function(method, url){
        var new_url = appendProxy(url);
        window.XMLHttpRequest.prototype.open.call(this, method, new_url);
      };
  }
})();
