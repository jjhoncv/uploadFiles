var playList = (function(){
  
  var defaults = {
    container   : ".music_player",
    prev        : ".prev",
    next        : ".next",
    pause       : ".pause",
    play        : ".play",
    stop        : ".stop",
    listMusic   : ".to_music_player > ul",
    tplItem     : "#tplItemList",
    songs       : [],
    index       : 0
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
    dom.tplItem   = $(st.tplItem);
  };

  var afterCatchDom = function(){
    fn.loadSongs();
    _.templateSettings = {
      evaluate: /\{\{([\s\S]+?)\}\}/g,
      interpolate: /\{\{=([\s\S]+?)\}\}/g
    };
  };

  var suscribeEvents = function(){
    dom.prev.on("click", events.prevHandler)
    dom.next.on("click", events.nextHandler)
    dom.pause.on("click", events.pauseHandler)
    dom.play.on("click", events.playHandler)
    dom.stop.on("click", events.stopHandler)    
    dom.listMusic.on("click", "a.listen", events.listenHandler);
    dom.listMusic.on("click", "a.remove", events.removeHandler);
  };

  var events = {
    prevHandler : function(e){
      fn.prevSong();
    },
    nextHandler : function(e){
      fn.nextSong();
    },
    pauseHandler : function(e){
      fn.pauseSong();
    },
    playHandler : function(e){
      e.preventDefault();
      fn.listenSong();
    },
    listenHandler : function(e){
      e.preventDefault();
      var index = $(e.target).parents("article").data("index");
      fn.listenSong(index);
    },
    removeHandler : function(e){
      e.preventDefault();
      var index = $(e.target).parents("article").data("index");
      fn.removeSong(index);
    },
    stopHandler : function(e){
      fn.stopSong();
    }
  };

  var fn = {    
    loadSongs : function(){
      for(var i=0; i < st.songs.length; i++){
        var song = st.songs[i];
        fn.renderSong(song);
      }
    },

    renderSong : function(song){
      var item = _.template(dom.tplItem.html(), {song:song}) 
      dom.listMusic.append(item);
    },  

    listenSong : function(index){
      st.index = (typeof index == "undefined") ? 0 : index;
      var song = st.songs[st.index];
      fn.refreshRender();
      Mp3.stop();
      Mp3.create(song.url);     
      Mp3.play();
    },

    prevSong : function(){
      if(st.index > 0){
        st.index--;
        fn.listenSong(st.index);
      }    
    },

    nextSong : function(){
      if(st.index < st.songs.length -1 ){
        st.index++;
        fn.listenSong(st.index);
      }      
    },

    addSong : function(song){
      song["index"] = st.songs.length
      st.songs.push(song);
      fn.renderSong(song);
    },

    stopSong : function(){
      Mp3.stop();
    },

    searchMusic : function(q){

    },

    refreshRender: function(){
      dom.listMusic.find("li").removeClass("active").eq(st.index).addClass("active");
    },

    removeSong : function(index){
      delete st.songs[index];
      dom.listMusic.find("li article[data-index="+index+"]").parents("li").remove();
    }  

  };

  var initialize = function(opts){
    st = $.extend({}, defaults, opts);
    catchDom(); 
    afterCatchDom();   
    suscribeEvents();
  };
  
  return{
      init        : initialize,
      addSong     : fn.addSong      
  }
})();

playList.init();
