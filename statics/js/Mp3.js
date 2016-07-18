var Mp3 = (function(){
  
  var defaults = {
    audio : {},
    playing: false
  };
 
  var st = {};

  var fn = {    
    create : function(url){
      st.audio = new Audio(url);
      st.audio.autoplay = false;
    },

    play : function(){      
      st.audio.play();
      st.playing = true;
    },

    stop : function(){
      if(st.playing){        
        st.audio.pause();
        st.playing = false;
      }
    }
  };

  var initialize = function(opts){
    st = $.extend({}, defaults, opts);
  };
  
  return{
      init     : initialize,
      create   : fn.create,
      play     : fn.play,
      stop     : fn.stop
  }
})();

Mp3.init();