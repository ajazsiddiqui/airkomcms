(function($) {
    "use strict"
  // $('#datatable thead tr').clone(true).appendTo( '#datatable thead' );
    // $('#datatable thead tr:eq(1) th').each( function (i) {
        // var title = $(this).text();
        // $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
 
        // $( 'input', this ).on( 'keyup change', function () {
            // if ( table.column(i).search() !== this.value ) {
                // table
                    // .column(i)
                    // .search( this.value )
                    // .draw();
            // }
        // } );
    // } );

    var table = $('#datatable').DataTable({
		"iDisplayLength": 10,
		 orderCellsTop: true,
        fixedHeader: true,
		 dom: 'lBfrtip',
		  scrollY:        "400px",
        scrollX:        true,
        scrollCollapse: true,
        paging:         false,autoPrint: false,
		fixedColumns:   {
            left: 4,
        },
        buttons: [
            {
                extend: 'print',
				title: 'Airkom Group',
				messageTop: $('#reportuser').text() + $('#reportdetails').text(),
                customize: function ( win ) { 
                    $(win.document.body).css('font-size', '12px');
					$(win.document.body).find( 'table' )
                         .addClass( 'compact' )
                        .css( 'font-size', 'inherit' );
                },
				exportOptions: {
                    columns: [ ':visible' ]
                }
            },
			'colvis'
        ],
        // createdRow: function ( row, data, index ) {
           // $(row).addClass('selected')
        // } 
    });

      
    table.on('click', 'tbody tr', function() {
    var $row = table.row(this).nodes().to$();
    var hasClass = $row.hasClass('selected');
    if (hasClass) {
        $row.removeClass('selected')
    } else {
        $row.addClass('selected')
    }
    })
    
    table.rows().every(function() {
    this.nodes().to$().removeClass('selected')
    });
   
  
  

})(jQuery);