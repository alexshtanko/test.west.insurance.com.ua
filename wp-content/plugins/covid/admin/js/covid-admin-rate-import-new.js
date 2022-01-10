jQuery(document).ready(function($) {

	ImportRate();

	function ImportRate(){

		$('body').on('submit', '#formRateImport', function(e){

            e.preventDefault();

            var fd = new FormData();    
            fd.append( 'file', $('#rateImportFile').get(0).files[0] );
            fd.append('action', 'covidadminrateuploadnew');
            fd.append('nonce', covidAdminRateImportNew.nonce);

            $.ajax({
            url: covidAdminRateImportNew.ajaxurl,
            data: fd,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function(response){
                console.log(response);
            }
            });

            return false;
			
		})
    }

});