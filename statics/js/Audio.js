var musicPlayer = (function(){
  
  var defaults = {
    container  : ".music_player",
    prev        : ".prev",
    next        : ".next",
    pause       : ".pause",
    play        : ".play",
    stop        : ".stop",
    mp3         : "",
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
    dom.prev      = $(st.prev, dom.container);
    dom.next      = $(st.next, dom.container);
    dom.pause     = $(st.pause, dom.container);
    dom.play      = $(st.play, dom.container);
    dom.stop      = $(st.stop, dom.container);
  };

  var afterCatchDom = function(){
    fn.create();
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
    create : function(){
      st.audio.instance = new Audio(st.mp3);
      st.audio.instance = st.audio.options;
    },
    prevMusic : function(){
      st.audio
    }
  };

  var initialize = function(opts){
    st = $.extend({}, defaults, opts);
    catchDom();
    afterCatchDom();
    suscribeEvents();
  };
  
  return{
      init: initialize,
      show: show
  }
})();

musicPlayer.init("http://www.goear.com/action/sound/get/c238684");

1318

trab 150
