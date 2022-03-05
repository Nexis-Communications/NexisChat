(function($) {
    'use strict';
    $(function() {
  
      //basic config
      if ($("#js-grid").length) {
        $("#js-grid").jsGrid({
          height: "500px",
          width: "100%",
          filtering: false,
          editing: false,
          inserting: true,
          sorting: true,
          paging: true,
          autoload: true,
          pageSize: 15,
          pageButtonCount: 5,
          deleteConfirm: "Do you really want to delete the room?",
          
          controller: {
            loadData: function(filter){
             return $.ajax({
              type: "GET",
              url: "/admin/dashboard/ajax/rooms",
              dataType: "json",
              data: filter,
              success: function (html)
                {
                  //alert('successful : ' + html);
                },
              error: function (jqXHR, textStatus, errorThrown)
                {
                  if (jqXHR.status == 500) {
                    //alert('Internal error: ' + jqXHR.responseText);
                  } else {
                    //alert('Unexpected error.');
                  }
                }
              });
            },
            insertItem: function(item){
             return $.ajax({
              type: "POST",
              url: "/admin/dashboard/ajax/rooms",
              data:item
             });
            },
            updateItem: function(item){
             return $.ajax({
              type: "PUT",
              url: "/admin/dashboard/ajax/rooms",
              data: item
             });
            },
            deleteItem: function(item){
             return $.ajax({
              type: "DELETE",
              url: "/admin/dashboard/ajax/rooms",
              data: item
             });
            },
           },

          fields: [
            {
              name: "Name",
              type: "text",
              width: 150
            },
            {
              name: "Group",
              type: "text",
              width: 150
            },
            {
              name: "Users",
              type: "number",
              width: 50
            },
            {
              name: "Status",
              type: "text",
              width: 50
            },
            {
              type: "control"
            }
          ]
        });
      }
  
  
  
      if ($("#sort").length) {
        $("#sort").on("click", function() {
          var field = $("#sortingField").val();
          $("#js-grid-sortable").jsGrid("sort", field);
        });
      }
  
    });
  })(jQuery);