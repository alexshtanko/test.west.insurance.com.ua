jQuery(document).ready(function($) {

	// ImportRate();

	function ImportRate(){

		$('body').on('submit', '#formRateImport', function(e){

            e.preventDefault();

            var fd = new FormData();    
            fd.append( 'file', $('#rateImportFile').get(0).files[0] );
            fd.append('action', 'covidrateimport');
            fd.append('nonce', covidAdminRateImport.nonce);

            $.ajax({
            url: covidAdminRateImport.ajaxurl,
            data: fd,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function(data){
                // console.log(data);
            }
            });

            return false;

		})
    }

});