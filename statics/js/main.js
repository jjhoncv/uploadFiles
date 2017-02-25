var main = (function(){
  //alert("aaa");
  
  var defaults = {
    frmSearch : ".frm_search",
    txtSearch : ".txt_search",
    //url       : "//dl.mp3yox.com/elastic/api.php?query=",
    url       : "ajax.php",
    list      : ".list-group",
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
    dom.list.on("click", "a.listen", events.addPlaylist)
  };

  var events = {
    addPlaylist : function(e){
      e.preventDefault();
      ele = $(e.target);
      url = ele.attr("href");
      title = ele.parents("li").find(".title").text();
      playList.addSong({url:url, title:title});
    },

    submit : function(e){
      e.preventDefault();
      var q = dom.txtSearch.val();
      if(q){
        fn.search(q);
      }
    }
  };

  var fn = {    
    search: function(q){
      $.post(st.url, {q: q, service: st.service, method:"find"}, function(data){
        if(typeof data === 'object'){
          var li = "";
          if (Array.isArray(data.results) && data.results.length){
            var results = data.results;
            console.log("results.length", results.length);
            for(var i = 0; i < results.length; i++){
              var item = results[i];              
              li+='<li class="list-group-item col-sm-3"><div class="cnt"><div class="title">'+item.duration + " : " + item.title + '<br/><strong>'+item.artist+'</strong></div><div class="options"><div><a class="listen" href="http://www.goear.com/action/sound/get/' + item.id + '"><span class="glyphicon glyphicon-plus"></span> Add</a></div><div><a href="download.php?file=' + item.id + '"><span class="glyphicon glyphicon-save"></span> Download</a></div></div></div></li>';
            }            
          }
          dom.list.html(li);
        }
      }, "json")
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

main.init();