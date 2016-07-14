var search = (function(){
  
  var defaults = {
    frmSearch : ".frm_search",
    txtSearch : ".txt_search",
    //url       : "//dl.mp3yox.com/elastic/api.php?query=",
    url       : "ajax.php",
    list      : ".list",
    service   : "Goear" // "Mp3yox" |  Soundcloud | Goear
  };
 
  var st = {};

  var dom = {};
 
  var catchDom = function(){
    dom.frmSearch = $(st.frmSearch);
    dom.txtSearch = $(st.txtSearch, dom.frmSearch);
    dom.list      = $(st.list);
  };

  var suscribeEvents = function(){
    dom.frmSearch.on("submit", events.submit)
  };

  var events = {
    submit : function(e){
      e.preventDefault();
      var q = dom.txtSearch.val().replace(/ /gi,"+");
      if(q){
        fn.search(q);
      }
    }
  };

  var fn = {
    search: function(q){
      $.post("http://www.goear.com/action/suggest/sounds", {skey:"arcangel"}, function(data){
        console.log(data);
      })
      /*$.post(st.url, {q: q, service: st.service}, function(data){
        if(typeof data === 'object'){
          if (Array.isArray(data.results) && data.results.length){
            var results = data.results;
            console.log("results.length", results.length);
            var li = "";
            for(var i = 0; i < results.length; i++){
              var item = results[i];              
              li+='<li><div class="title">' + item.title + '</div><div><a href="download.php?file=' + item.id + '"></a></div></li>';
            }            
            dom.list.html(li);
          }
        }
      }, "json")*/
    }
  };

  var initialize = function(opts){
    st = $.extend({}, defaults, opts);
    catchDom();
    suscribeEvents();
  };
  
  return{
      init:initialize
  }
})();

search.init();