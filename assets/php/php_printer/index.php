<?php
	error_reporting(0);
	if($handle = printer_open('\\\192.168.1.33\HP Deskjet 1510 series')){
		printer_set_option($handle, PRINTER_MODE, 'RAW');
		printer_start_doc($handle);
		printer_start_page($handle);
		$line1 = 'Linea 1: TITULO DEL DOCUMENTO';
		$line2 = 'Linea 2: Este es el cuerpo del documento impreso para las pruebas necesarias.';
		$line3 = 'Linea 3: Este es el cuerpo del documento impreso para las pruebas necesarias.';
		$line4 = 'Linea 4: Este es el cuerpo del documento impreso para las pruebas necesarias.';

		$font = printer_create_font('Arial', 150, 80, 700, false, false, false, 0);
		printer_select_font($handle, $font);
		printer_draw_text($handle, $line1, 150, 50);

		$font = printer_create_font('Arial', 90, 50, 100, false, false, false, 0);
		printer_select_font($handle, $font);
		printer_draw_text($handle, $line2, 150, 250);
		printer_draw_text($handle, $line3, 150, 350);
		printer_draw_text($handle, $line4, 150, 450);
		
		printer_delete_font($font);
		printer_end_page($handle);
		printer_end_doc($handle);
		printer_close($handle);
		echo 'Impresion exitosa.';
	}else{
		echo 'No se pudo conectar a la impresora.';
	}
?>