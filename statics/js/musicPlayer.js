var musicPlayer = (function(){
  
  var defaults = {
    container   : ".music_player",
    prev        : ".prev",
    next        : ".next",
    pause       : ".pause",
    play        : ".play",
    stop        : ".stop",
    listMusic   : ".to_music_player", 
    audio       : {
      instance : {},
      options  : {
        autoplay : false
      }
    }    
  };
 
  var st = {};

  var dom = {};
 
  var catchDom = function(){
    dom.container = $(st.container);
    dom.listMusic = $(st.listMusic, dom.container);    
    dom.prev      = $(st.prev, dom.container);
    dom.next      = $(st.next, dom.container);
    dom.pause     = $(st.pause, dom.container);
    dom.play      = $(st.play, dom.container);
    dom.stop      = $(st.stop, dom.container);
  };  

  var suscribeEvents = function(){
    dom.prev.on("click", events.prevHandler)
    dom.next.on("click", events.nextHandler)
    dom.pause.on("click", events.pauseHandler)
    dom.play.on("click", events.playHandler)
    dom.stop.on("click", events.stopHandler)
  };

  var events = {
    prevHandler : function(e){
      fn.prevMusic();
    },
    nextHandler : function(e){
      fn.nextMusic();
    },
    pauseHandler : function(e){
      fn.pauseMusic();
    },
    playHandler : function(e){
      fn.playMusic();
    },
    stopHandler : function(e){
      fn.stopMusic();
    }
  };

  var fn = {    
    prevMusic : function(){
      List.getPrevMusic();
      var item = List.getItem();
      fn.currentMusic(item.link);
      st.playMusic();
    },

    nextMusic : function(){
      List.getNextMusic();
      var item = List.getItem();
      fn.currentMusic(item.link);
      st.playMusic();
    },

    addMusic : function(item){      
      dom.listMusic = $(st.listMusic, dom.container); 
      ul = dom.listMusic.find("ul");
      li = dom.listMusic.find("ul li");
      console.log("li.length", li.length);
      if (li.length == 1){
        var _class = "current";
        li.filter(".empty").remove();
      }

      ul.append('<li class="'+ _class +'"><article><a href="#" class="remove">Quitar</a><div class="title">' + item.title  + '</div></article></li>');          

    },

    playMusic : function(){
      dom.listMusic = $(st.listMusic, dom.container);
      if(dom.listMusic.find("ul li").length){
        li = dom.listMusic.find("ul li.current")
        item = {title: li.attr("data-title"), link : li.attr("data-link")};
        st.audio = new Audio(item.link);
        st.audio.autoplay = false;
        st.audio.play();
      }
    },

    pauseMusic : function(){
      st.audio.pause();
    },

    searchMusic : function(q){

    }   

  };

  var initialize = function(opts){
    st = $.extend({}, defaults, opts);
    catchDom();    
    suscribeEvents();
  };
  
  return{
      init     : initialize,
      addMusic : fn.addMusic 
  }
})();

musicPlayer.init();