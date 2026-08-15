<?php

namespace App\Controller;

use App\Entity\Categoria;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Dom\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Symfony\Component\Routing\Annotation\Route;


class PruebasController extends AbstractController
{
    #[Route('/pruebas', name: 'app_pruebas')]
    public function index(): Response
    {
        return $this->render('pruebas/index.html.twig', [
            'controller_name' => 'PruebasController',
        ]);
    }

    #[Route('/pruebas/cargue', name: 'app_cargue')]
    public function cargueExcel(Request $request, EntityManagerInterface $em) : JsonResponse {        
        $file = $request->files->get('archivo');
        
        $sheet = IOFactory::load($file->getPathname());
        $hoja = $sheet->getActiveSheet(); // hoja activa 

        $errores = [];

        $header = [
            'CATEGORIA', 
            'DESCUENTO', 
            'FECHA INICIO', 
            'FECHA FIN', 
            'ESTADO'
        ];

        $datos = [];

        foreach ($hoja->getRowIterator(2) as $row) {
            
            $valoresFila = [];
            $celda = $row->getCellIterator();                    

            foreach ($celda as $cell) {
                $valoresFila[] = $cell->getValue();
            }

            $fila = array_combine($header, $valoresFila);
        
            if (!is_numeric($fila['FECHA INICIO']) || !is_numeric($fila['FECHA FIN'])) {
                $errores[] = [
                    'fila' => $fila,
                    'mensaje' => "El valor no tiene un formato de fecha"
                ];

                continue;
            }

            $fila['ESTADO'] = $fila['ESTADO'] === 'Activo' ? 1 : 0;
                
            $fila['FECHA INICIO'] = Date::excelToDateTimeObject($fila['FECHA INICIO']);
            $fila['FECHA FIN']    = Date::excelToDateTimeObject($fila['FECHA FIN']);
            
            $datos[] = $fila;            
        }

        if (!empty($errores)) {
            new JsonResponse([
                'success' => false,
                'message' => 'Ha ocurrido errores al relizar el cargue masivo'
            ]);
        }

        foreach ($datos as $value) {
            $entity = new Categoria();

            $entity->setNombre($value['CATEGORIA']);
            $entity->setSlug($value['CATEGORIA']);
            $entity->setFecharegistro(new DateTime());
            $entity->setDescuento($value['DESCUENTO']);
            $entity->setFechainicio($value['FECHA INICIO']);
            $entity->setFechafin($value['FECHA FIN']);
            $entity->setEstado($value['ESTADO']);

            $em->persist($entity);
        }
        
        $em->flush();

        return new JsonResponse([
            'success' => true,
            'message' => 'Los datos fueron cargados correctamente'
        ]);
    }
}
