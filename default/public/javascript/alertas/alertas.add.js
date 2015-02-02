jQuery(document).ready(function($) {
	$("#alertas_deptos_id").on('change', function(){
		var mid = $("#alertas_deptos_id option:selected").val();
		console.log(url + "callbacks/municipios/" + mid);
		$('#municipios_js').load(url + "callbacks/municipios/" + mid);
	});
}); 
