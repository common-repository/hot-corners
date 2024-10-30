jQuery(document).ready(function($){

var setup_backend_editor = function( ){

    var from_list = document.getElementById("wphc-draggable-items");
    var trash = document.getElementById('wphc-trash');
    var droppable_areas = [
        'tl-drop',
        'tr-drop',
        'bl-drop',
        'br-drop'
    ];
    function setup_everything( ){

        Sortable.create(from_list,{
            sort: false,
            ghostClass: 'just-a-clone',
            group: {
                pull: 'clone',
                put: false
            }
        });

        for( var i=0; i<droppable_areas.length; i++ ){
            Sortable.create(document.getElementById(droppable_areas[i]),{
                animation: 200,
                group: {
                    put: true
                },
                onSort: function( event ){ wphc_get_all_items_in_json( event ); }
            });
        }


        Sortable.create(trash,{
            ghostClass: 'no',
            sort: false,
            delay: 1000000,
            scrollSensitivity: 399990,
            group: {
                put: true,
                pull: false
            },
            // dragging started
            onAdd: function (event) {
                event.oldIndex;  // element index within parent
                trash.className = 'over';

                trash.innerHTML = '';

                setTimeout(function(){
                    trash.className = '';
                }, 200);
            }
        });


    } // end setup_everything
    function wphc_get_all_items_in_json( event ){

        var json_rocks = {
            "top_left" : [],
            "top_right" : [],
            "bottom_left" : [],
            "bottom_right" : []
        }

        for(var i=0; i<droppable_areas.length;i++){

            var ul = document.getElementById(droppable_areas[i]);
            var items = ul.querySelectorAll('.draggable');

            if( items.length > 0 ){

                for(var c=0; c<items.length; c++){

                    if( ul.id == 'tl-drop' ){
                        json_rocks.top_left.push( items[c].getAttribute('data-id') )
                    }
                    if( ul.id == 'tr-drop' ){
                        json_rocks.top_right.push( items[c].getAttribute('data-id') )
                    }
                    if( ul.id == 'bl-drop' ){
                        json_rocks.bottom_left.push( items[c].getAttribute('data-id') )
                    }
                    if( ul.id == 'br-drop' ){
                        json_rocks.bottom_right.push( items[c].getAttribute('data-id') )
                    }

                }

            }


        }
        $.ajax({
            url: ajaxurl,
            method: "POST",
            data: {
                action: 'wphc_save_corners',
                corners: json_rocks
            }
        }).done(function(res){
            $('#wphc-saved-notice').fadeIn().text('Saved');
            setTimeout(function(){
                $('#wphc-saved-notice').fadeOut();
            }, 500);
        }).error(function(res){
            $('#wphc-saved-notice').fadeIn().text('Error: check connection.');
        });

    } // end wphc_get_all_items_in_json

    // console.log( from_list );

    if( from_list ){
        setup_everything();
    }
}
setup_backend_editor();


}); // end jquery