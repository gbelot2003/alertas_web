
jQuery(document).ready(function($) {
	//var path = "http://alertas.clibrehonduras.com/swf/copy_csv_xls_pdf.swf";
	var path = "http://localhost/ktheme/swf/copy_csv_xls_pdf.swf";
	$('.table-bordered').dataTable(
	{
		"sDom": 'T<"clear">lfrtip',
		"oTableTools": {
			"sSwfPath": path,
			 "aButtons":[
			 	 "xls",
                 "pdf",
                {
                    "sExtends":    "collection",
                    "sButtonText": "Salvar Como",
                    "aButtons":    [ "csv", "print", "copy" ]
                }
			 ],
		},
		"iDisplayLength": 25,
		"oLanguage": {
		"sProcessing": "Procesando...",
		"sLengthMenu": "Mostrar _MENU_ registros",
		"sZeroRecords": "No se encontraron resultados",
		"sEmptyTable": "Ningún dato disponible en esta tabla",
		"sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
		"sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
		"sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
		"sInfoPostFix": "",
		"sSearch": "Buscar:",
		"sUrl": "",
		"sInfoThousands": ",",
		"sLoadingRecords": "Cargando...",
		"oPaginate": {
		"sFirst": "Primero",
		"sLast": "Último",
		"sNext": "Siguiente",
		"sPrevious": "Anterior"
		},
		"fnInfoCallback": null,
		"oAria": {
			"sSortAscending": ": Activar para ordernar la columna de manera ascendente",
			"sSortDescending": ": Activar para ordernar la columna de manera descendente"
		}

	},
		"aaSorting": [[ 0, "desc" ]],
	});

}); 

