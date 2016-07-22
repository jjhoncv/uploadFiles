var search = (function(){
  
  var defaults = {
    service : "Musicaq",
    url     : "ajax.php",
    alfabet : ["x","y","z","0-9"],
    index_alfabet   : 0,
    page_song       : 0,
    index_artista   : 0,
    artists         : []

  };
 
  var afterCatchDom = function(){
    fn.getArtistByLetter(st.alfabet[st.index_alfabet]);
  };
  
  var fn = { 
    getSongByArtist : function(){

      artist = st.artists[st.index_artista].trim().replace(/\/.+/g,"").replace(/\&.+/g,"").replace(/\".+/g,"").replace(/ /g,"+").trim()

      $.post(st.url, {artist: artist, service: "Goear", page: st.page_song, method: "search"}, function(data){
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
      $.post(st.url, {letter: st.alfabet[st.index_alfabet], service: "Musicaq", method: "getArtistByLetter"}, function(artists){
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
      $.post(st.url, {artist:artist ,service: service, method: method, data:_data}, function(data){
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
    afterCatchDom();    
  };
  
  return{
      init:initialize
  }
})();

search.init();