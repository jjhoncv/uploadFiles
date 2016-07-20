var search = (function(){
  
  var defaults = {
    service : "Goear",
    url     : "ajax.php",
    alfabet : ["a","b","c","d","e","f","g","h","i","j","k","l","m","n","ñ","o","p","q","r","s","t","u","v","w","x","y","z"],
    index   : 0,
    page    : 0

  };
 
  var st = {};

  var dom = {};
 
  var catchDom = function(){
    
  };

  var afterCatchDom = function(){
    fn.search(st.alfabet[st.index]);
  };

  var suscribeEvents = function(){
  
  };

  var events = {
    
  };

  var fn = {    
    search: function(q){      
      $.post(st.url, {q: q, service: st.service, page: st.page, method: "search"}, function(data){
        if(typeof data === 'object'){          
          if (Array.isArray(data.results) && data.results.length){            
            fn.addMp3(st.service, "add", q, data.results)            
          }else{
            if(st.index <= st.alfabet.length){
              st.index++;
              st.page = 0;
              fn.search(st.alfabet[st.index]);              
            }else{
              console.log("finish!!");
            }
          }
        }
      }, "json")
    },

    addMp3: function(service, method, q, data){
      console.log("alfabet: " + st.alfabet[st.index], "page: " + st.page,"total: " + data.length);
      $.post(st.url, {q:q ,service: service, method: method, data:data}, function(data){
        if(data.status){
          st.page++;
          fn.search(st.alfabet[st.index]);
        }
      }, "json")
    }
  };

  var initialize = function(opts){
    st = $.extend({}, defaults, opts);
    catchDom();
    afterCatchDom();   
    suscribeEvents();
  };
  
  return{
      init:initialize
  }
})();

search.init();