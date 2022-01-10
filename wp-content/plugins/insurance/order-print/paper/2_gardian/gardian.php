<?php

if( !defined('ACCESSCNSTINSURANCE' ) ) {
    die('Direct access not permitted');
}
else
{

    $order_id = $_GET['order_id'];

//    $gardian = new GardianPaper(__DIR__);
    $gardian = new Gardian(__DIR__);

    $order_data = $gardian->get_gardian_order( $order_id );

    if( ! empty( $order_data ) )
    {
        // ВЕРНУТЬ PDF ФАЙЛ
        $orderGUID = $order_data['gardian_GUID']; // Это для теста вставил.
        $pdfData = [
            'GUID' => $orderGUID,
            'formName' => 'ВЗРКон'
        ];

        if($gardian->loginPage()){
            if($gardian->login() == 200){
//                $gardian->printPaperBlank($pdfData);
                $gardian->printBlank($pdfData);
            }
        }
    }
    else
    {
        echo 'Не вдалося знайти данi про договiр.';
    }

}