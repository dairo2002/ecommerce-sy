<?php

namespace App\Controller\Admin;

use App\Entity\Productos;
use App\DTO\Admin\ProductDto;
use App\Entity\Categoria;
use Doctrine\ORM\EntityManagerInterface;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Routing\Annotation\Route;

class ProductosController extends AbstractController
{
    /** @var EntityManagerInterface  */
    private $em;

    /** @var SluggerInterface */
    private $slugger;

    public function __construct(EntityManagerInterface $em, SluggerInterface $slug)
    {
        $this->em = $em;
        $this->slugger = $slug;
    }

    public function index()
    {
        $allCategory = $this->em->getRepository(Categoria::class)->findAll();
        return $this->render('admin/products.html.twig', array(
            'allCategory' => $allCategory
        ));
    }

    #[Route('/productos/store', name: 'app_admin_productos_store', methods: ['POST'])]
    public function createProducts(Request $request, ValidatorInterface $validador): JsonResponse
    {
        $uploadedImage = $request->files->get('fileImg');
        $categoryId = $request->request->get('category');

        $data = [
            'name' => $request->request->get('nombre'),
            'description' => $request->request->get('descripcion'),
            'stock' => $request->request->get('stock'),
            'imagen' => $uploadedImage instanceof UploadedFile ? $uploadedImage->getClientOriginalName() : null,
            'category' => $categoryId
        ];

        if (!$data['name'] && !$data['description'] && !$data['stock'] && !$uploadedImage) {
            return $this->json([
                'success' => false,
                'error' => ['body' => 'No se recibieron datos válidos']
            ], 400);
        }

        $category = $categoryId ? $this->em->getRepository(Categoria::class)->find($categoryId) : null;
        if (!$category) {
            return $this->json([
                'success' => false,
                'error' => ['category' => 'Debe seleccionar una categoría válida']
            ], 422);
        }

        $imageName = null;
        if ($uploadedImage instanceof UploadedFile) {
            $uploadDir = $this->getParameter('kernel.project_dir') . '/public/uploads';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $imageName = sprintf(
                '%s.%s',
                $this->slugger->slug(pathinfo($uploadedImage->getClientOriginalName(), PATHINFO_FILENAME)),
                $uploadedImage->guessExtension() ?: $uploadedImage->getClientOriginalExtension()
            );

            try {
                $uploadedImage->move($uploadDir, $imageName);
            } catch (FileException $e) {
                return $this->json([
                    'success' => false,
                    'error' => ['imagen' => 'No se pudo subir la imagen']
                ], 500);
            }
        }

        $dto = new ProductDto(
            $data['name'] ?? '',
            $data['description'] ?? '',
            $data['stock'] ?? null,
            $imageName
        );

        $errors = $validador->validate($dto);

        if (count($errors) > 0) {

            $error = [];

            foreach ($errors as $e) {
                $error[$e->getPropertyPath()] = $e->getMessage();
            }

            return $this->json([
                'success' => false,
                'error'   => $error
            ], 422);
        }

        $product = new Productos;
        $product->setNombre($dto->nombre);
        $product->setDescripcion($dto->descripcion);
        $product->setImagen($dto->imagen);
        $product->setStock((int) $dto->stock);
        $product->setSlug($dto->nombre);
        $product->setCategoria($category);

        $this->em->persist($product);
        $this->em->flush();

        return $this->json([
            'success'  => true,
            'message' => 'Producto guardado exitosamente'
        ], 201);
    }

    #[Route('/productos/list', name: 'app_admin_productos_list', methods: ['GET'])]
    public function listProduct(): JsonResponse
    {
        $products = $this->em->getRepository(Productos::class)->findProductsWithCategory();
        return new JsonResponse([
            'products' => $products
        ]);
    }

    #[Route('/productos/download', name: 'app_admin_productos_download', methods: ['POST'])]
    public function downloadExcelProducts() {        
        $file = $this->getParameter('kernel.project_dir') . '/public/assets/plantallas-xlsx/plantilla.xlsx';

        if (!file_exists($file)) {
            throw new \Exception('La plantilla no se encontró');
        }

        $spreadsheet = IOFactory::load($file);
        $sheet = $spreadsheet->getActiveSheet();
        
        $sheet->setCellValue('A1', 'Producto');
        $sheet->setCellValue('B1', 'Categoría');
        $sheet->setCellValue('C1', 'Descripcion');
        $sheet->setCellValue('D1', 'Precio');
        $sheet->setCellValue('F1', 'Stock');        

        $products = $this->em->getRepository(Productos::class)->findProductsWithCategory();
        $fila = 2;

        foreach ($products as $row) {
            $sheet->setCellValue('A' . $fila, $row['producto']);
            $sheet->setCellValue('B' . $fila, $row['categoria']);
            $sheet->setCellValue('C' . $fila, $row['descripcion']);
            $sheet->setCellValue('D' . $fila, $row['precio']);
            $sheet->setCellValue('F' . $fila, $row['stock']);

            $fila++;
        }
            
        $file = tempnam(sys_get_temp_dir(), 'productos_') . '.xlsx';
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save($file);

        // return $this->downloadFile($file, 'productos.xlsx')->deleteFileAfterSend(true);
        return $this->downloadFile($file);
    }

    public function downloadFile(string $file) : BinaryFileResponse {
        $response = new BinaryFileResponse($file);

        $response->setContentDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            basename($file)
        );

        return $response;
    }
}