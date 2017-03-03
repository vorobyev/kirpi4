function updatePage(){
    $.ajax({
        type: "POST",
        url: window.location.protocol+"//"+window.location.hostname+window.location.pathname+"?r=taskuser/newtaskid",
        success: function(msg){
          if (msg != $('#hiddenid').html()){
              location.reload();
          }
        }
      });
}

setInterval(updatePage,2000);