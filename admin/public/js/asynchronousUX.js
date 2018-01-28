$(function(){

  $(document).ajaxStart(function() { Pace.restart(); });

  $(".main-sidebar .sidebar-menu li a.asyncLink").click(function(e){
    e.preventDefault();
    asyncLoadThis($(this).attr("href"),"#asyncLoadArea");
  });

  /**
  */
  function asyncLoadThis(resource,where){
    $.ajax({
      url: resource,
      method: "GET",
    }).done(function(response){
      $(where).html(response);
    });
  }

});
