jQuery(document).ready(function($) {

	ImportRate();

	function ImportRate(){

		$('body').on('submit', '#formRateImport', function(e){

            e.preventDefault();

            var fd = new FormData();    
            fd.append( 'file', $('#rateImportFile').get(0).files[0] );
            fd.append('action', 'insuranceadminrateuploadnew');
            fd.append('nonce', insuranceAdminRateImportNew.nonce);

            $.ajax({
            url: insuranceAdminRateImportNew.ajaxurl,
            data: fd,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function(response){
                console.log(response);
            }
            });

            return false;
            			
            // blankName = $('#blankName').val();
            
            // file = $('#rateImportFile').get(0).files[0];

            // formData = new FormData();

            // formData.append("file", file);


            /*file_data = $('#rateImportFile').prop('files')[0];
            form_data = new FormData($('#formRateImport')[0]);
            form_data.append('file', file_data);
            form_data.append('action', 'insurancerateimport');
            form_data.append('nonce', insuranceAdminRateImport.nonce);
            
            $.ajax({
	            url: insuranceAdminRateImport.ajaxurl,
	            type: 'POST',
	            contentType: false,
	            processData: false,
	            data: form_data,
	            beforeSend: function() {
                    

			  	},
	            success: function (response) {

                    console.log(response);
	            },
	            error: function(){
	            	alert("Сервер занят, попробуйте немного позже.");
	            }
	            
            });*/
            
            /*    
            //Создаем данные для передачи
            var data = {
                action: 'insurancerateimport',
                nonce: insuranceAdminRateImport.nonce,
                // rate: new FormData(this),
                data: file,
            };

            // console.log(user_club_title);

            //Отправляем данные
            var jqXHR = $.post( insuranceAdminRateImport.ajaxurl, data, function(response) {
                // console.log(response);
            });

            //Если получили статус 200
            jqXHR.done(function(response){

                // $('#aBidMessage .acf-input').text(response);

                // data = JSON.parse(response);

                console.log(response);

                // console.log('Сообщение: ' + data.message + 'Название компании: ' + data.blank_name);
                
            });

            //Если была ошибка
            jqXHR.fail(function(response){

                console.log(response);

                alert('Сервер занят, попробуйте немного позже');

            });
            */

            return false;
                
            
			
		})
    }

});