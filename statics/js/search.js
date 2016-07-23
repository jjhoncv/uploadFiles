var search = (function(){
  
  var defaults = {
    service : "Musicaq",
    url     : "ajax.php",
    alfabet : ["a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z","0-9"],
    index_alfabet   : 0,
    page_song       : 0,
    index_artista   : 0,
    artists         : [],
    linkStop        : ".stop",
    linkContinue    : ".continue",
    xhr             : {}

  };
  
  dom = {};

  var catchDom = function(){
    dom.linkStop      = $(st.linkStop);
    dom.linkContinue  = $(st.linkContinue);
  }; 

  var suscribeEvents = function(){
    dom.linkStop.on("click", events.stopHandler);
    dom.linkContinue.on("click", events.continueHandler);
  };
  
  var events = { 
    stopHandler : function(e){
      e.preventDefault();
      fn.stop();
    },

    continueHandler : function(e){      
      e.preventDefault();
      fn.continue();
    }
  };

  var fn = { 
    continue : function(){
      $.post(st.url, {service: "Goear", method: "loadKeys"}, function(data){
        if (data.status){

          st.page_song     = data.key.page_song;
          st.index_alfabet = data.key.index_alfabet;
          st.index_artista = data.key.index_artista;

          fn.getArtistByLetter(st.alfabet[st.index_alfabet]);

          dom.linkContinue.addClass("hide");
          dom.linkStop.removeClass("hide");
        }
      },"json");
    },

    stop : function(){
      var keys = {
        page_song     : st.page_song,
        index_alfabet : st.index_alfabet,
        index_artista : st.index_artista
      };

      st.xhr.abort();

      $.post(st.url, {service: "Goear", keys: keys, method: "saveKeys"}, function(data){
        if (data.status){
          dom.linkStop.addClass("hide");
          dom.linkContinue.removeClass("hide");
        }
      },"json");
    },

    getSongByArtist : function(){

      artist = st.artists[st.index_artista].trim().replace(/\/.+/g,"").replace(/\&.+/g,"").replace(/\".+/g,"").replace(/ /g,"+").trim()

      st.xhr = $.post(st.url, {artist: artist, service: "Goear", page: st.page_song, method: "search"}, function(data){
        if(typeof data === 'object'){
          if (Array.isArray(data.results) && data.total > 0){
            fn.addMp3("Goear", "add", artist, data)
          }else{
            if(st.index_artista < st.artists.length -1){
              st.index_artista++;
              st.page_song = 0;
              fn.getSongByArtist();              
            }else{
              if(st.index_alfabet < st.alfabet.length -1){
                st.index_alfabet++;
                st.index_artista = 0;
                st.page_song = 0;
                fn.getArtistByLetter();                
              }else{
                console.log("finish!!");
              }
            }
          }
        }
       },"json");
    },

    getArtistByLetter: function(){
      st.xhr = $.post(st.url, {letter: st.alfabet[st.index_alfabet], service: "Musicaq", method: "getArtistByLetter"}, function(artists){
        if(typeof artists === 'object'){
          if (Array.isArray(artists) && artists.length){
            st.artists = artists;
            fn.getSongByArtist();            
          }else{
            if(st.index_alfabet < st.alfabet.length -1){
              st.index_alfabet++;
              fn.getArtistByLetter();              
            }
          }
        }
      },"json");
    },

    addMp3: function(service, method, artist, _data){
      console.log("alfabet: " + st.alfabet[st.index_alfabet], "artist: " + artist, "page: " + st.page_song,"total: " + _data.total);
      st.xhr = $.post(st.url, {artist:artist ,service: service, method: method, data:_data}, function(data){
        if(data.status){
          if(st.page_song <= 39){
            st.page_song++;
            fn.getSongByArtist(artist);            
          }else{            
            st.index_artista++;
            st.page_song = 0;
            fn.getSongByArtist();
          }
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

search.init();