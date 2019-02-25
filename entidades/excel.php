<?php
require_once './datos/AccesoDatos.php';
require_once './vendor/PHPExcel-1.8/Classes/PHPExcel.php';
class excel{

    public function traerTodosUsuariosExcel($request, $response, $args) 
	{
        $todosUsuarios = usuario::traerTodos();
        $objPHPExcel = new PHPExcel();
        $num = 1; // numero de linea en el excel, empieza en uno
       // echo($todosUsuarios[1]->nombre);
        //var_dump($todosEmpleados);

// titulos del excel
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$num, "id");
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$num, "nombre");
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$num, "apellido");
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$num, "clave");
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$num, "usuario");
        $objPHPExcel->getActiveSheet()->setCellValue('F'.$num, "perfil");
        $objPHPExcel->getActiveSheet()->setCellValue('G'.$num, "ult_fecha_log");
        $objPHPExcel->getActiveSheet()->setCellValue('H'.$num, "fecha_alta");
        $objPHPExcel->getActiveSheet()->setCellValue('I'.$num, "fecha_baja");
        $objPHPExcel->getActiveSheet()->setCellValue('J'.$num, "estado");
       



        for ($i=0; $i < count($todosUsuarios); $i++) 
        {
            $num++;

// cada registro del excel
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$num, $todosUsuarios[$i]->id);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$num, $todosUsuarios[$i]->nombre);
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$num, $todosUsuarios[$i]->apellido);
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$num, $todosUsuarios[$i]->clave);
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$num, $todosUsuarios[$i]->usuario);
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$num, $todosUsuarios[$i]->perfil);
            $objPHPExcel->getActiveSheet()->setCellValue('G'.$num, $todosUsuarios[$i]->ult_fecha_log);
            $objPHPExcel->getActiveSheet()->setCellValue('H'.$num, $todosUsuarios[$i]->fecha_alta);
            $objPHPExcel->getActiveSheet()->setCellValue('I'.$num, $todosUsuarios[$i]->fecha_baja);
            $objPHPExcel->getActiveSheet()->setCellValue('J'.$num, $todosUsuarios[$i]->estado);

            if ($i==count($todosUsuarios)-1){
                var_dump($i);
	          break;
            }
        }
        $objPHPExcel->getActiveSheet()->setTitle('Usuario');
      
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
      
        if ($objWriter == false) {
            throw new Exception('Error al exportar listado a xlsx');
        }
        else{
            $objWriter->save("Listado_Usuarios.xlsx");
            if ($objWriter) {
                $ahora = date("Ymd-His");
                $extension = pathinfo("Listado_Usuarios.xlsx", PATHINFO_EXTENSION);
                rename("Listado_Usuarios.xlsx" , "entregaexportados/"."Listado_Usuarios"."-".$ahora.".".$extension);
                echo "Listado de usuarios exportado correctamente";
            }

        }
        
    }

/*    public function loginExcel($request, $response, $args) 
	{
        $login = historico::traerTodosLogin();
        $objPHPExcel = new PHPExcel();
        $num = 1;

        $objPHPExcel->getActiveSheet()->setCellValue('A'.$num, "id");
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$num, "email");
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$num, "fecha");
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$num, "hora");


        for ($i=0; $i < count($login); $i++) 
        {
            $num++;
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$num, $login[$i]['id']);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$num, empleado::TraerEmpleadoID($login[$i]['idEmpleado'])->email);
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$num, $login[$i]['fecha']);
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$num, $login[$i]['hora']);

        }
        $objPHPExcel->getActiveSheet()->setTitle('login');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        if ($objWriter == false) {
            throw new Exception('Error al exportar listado a xlsx');
        }
        else{
            $ahora = date("Ymd-His");
            $nombre = "Listado_Login-".$ahora.".xlsx";
            //$objWriter->save("Listado_Login.xlsx");
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'.$nombre.'');
            header('Cache-Control: max-age=0');
            $objWriter->save('php://output'); 
            exit;
        }
            //$extension = pathinfo("Listado_Login.xlsx", PATHINFO_EXTENSION);
            //rename("Listado_Login.xlsx" , "exportados/excel/"."Listado_Login"."-".$ahora.".".$extension);
            //echo "Listado de login exportado correctamente";
            //$objWriter->save('php://output'); 
            //exit;
    }

    public function loginUsurioExcel($request, $response, $args) 
	{
        //$ArrayDeParametros = $request->getParsedBody();
        //$id= $ArrayDeParametros['id'];
        $id = $args['id'];
        $login = historico::loginUsuario($id);
        $objPHPExcel = new PHPExcel();
        $num = 1;

        $objPHPExcel->getActiveSheet()->setCellValue('A1',"Email");
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$num, "Fecha");
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$num, "Hora");


        for ($i=0; $i < count($login); $i++) 
        {
            $num++;
            $objPHPExcel->getActiveSheet()->setCellValue('A2', empleado::TraerEmpleadoID($id)->email);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$num, $login[$i]['fecha']);
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$num, $login[$i]['hora']);

        }
        $objPHPExcel->getActiveSheet()->setTitle('login');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        if ($objWriter == false) {
            throw new Exception('Error al exportar listado a xlsx');
        }
        else{
            $ahora = date("Ymd-His");
            $nombre = "Listado_Login-".$ahora.".xlsx";
            //$objWriter->save("Listado_Login.xlsx");
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'.$nombre.'');
            header('Cache-Control: max-age=0');
            $objWriter->save('php://output'); 
            exit;
        }
            //$extension = pathinfo("Listado_Login.xlsx", PATHINFO_EXTENSION);
            //rename("Listado_Login.xlsx" , "exportados/excel/"."Listado_Login"."-".$ahora.".".$extension);
            //echo "Listado de login exportado correctamente";
            //$objWriter->save('php://output'); 
            //exit;
    }
    */

}
?>