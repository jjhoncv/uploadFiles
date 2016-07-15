var List = (function(){
  
  var defaults = {
    items   : [],
    content : ".to_music_player",
    pos     : 0
  };
 
  var st = {};

  var dom = {};
 
  var catchDom = function(){
    dom.list  = $(st.content).find("ul")
  };

  var afterCatchDom = function(){
   
  };

  var suscribeEvents = function(){
   
  };

  var events = {
   
  };

  var fn = {
    addMusic : function(item){
      st.items.push(item);
      fn.render();
    },
    del : function(item){
      delete st.items[item];
      fn.render();
    },
    getPrevMusic : function(){
      if(st.pos >= 0)
        st.pos--;
    },

    getNextMusic : function(){
      if(st.pos <= st.items)
        st.pos++;
    },

    render : function(){
      var item = st.items[st.pos];      
      dom.list.append('<li><article><a href="#" class="remove">Quitar</a><div class="title">' + item.title  + '</div></article></li>');
    },

    setPos : function(pos){
      st.pos = pos;
    },

    getPos : function(){
      return st.pos;
    },

    getItem : function(){
      return st.items[st.pos];
    }
  };

  var initialize = function(opts){
    st = $.extend({}, defaults, opts);
    catchDom();
    afterCatchDom();
    suscribeEvents();
  };
  
  return{
      init          : initialize,
      addMusic      : fn.addMusic,
      getNextMusic  : fn.getNextMusic,
      getPrevMusic  : fn.getPrevMusic,
      getItem       : fn.getItem,
      setPos        : fn.setPos
  }

})();

List.init();
