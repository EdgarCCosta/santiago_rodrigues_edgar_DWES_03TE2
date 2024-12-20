<?php

// Incluir el modelo ProductModel para interactuar con los datos de los productos
require_once '../app/models/ProductModel.php';

class ProductsController
{
    private $model;

    // Constructor para inicializar el modelo
    public function __construct()
    {
        $this->model = new ProductModel();
    }

    // Recuperar y devolver todos los productos
    public function getAllProducts()
    {
        $products = $this->model->getAll();
        echo json_encode(['message' => 'Productos recuperados con exito', 'data' => $products]);
    }

    // Recuperar un producto especifico por su ID
    public function getProduct($params)
    {
        $product = $this->model->getById($params['id']);
        if ($product) {
            echo json_encode(['message' => 'Producto recuperado con exito', 'data' => $product]);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Producto na encontrado']);
        }
    }

    // Agregar un nuevo producto
    public function addProduct()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        if ($this->model->add($data)) {
            echo json_encode(['message' => 'Producto creado con exito']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Erro al crear producto']);
        }
    }

    // Actualizar un producto existente
    public function updateProduct($params)
    {
        $data = json_decode(file_get_contents('php://input'), true);

        if ($this->model->update($params['id'], $data)) {
            echo json_encode(['message' => 'Producto actualizado con exito']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Producto no encontrado']);
        }
    }

    // Eliminar un producto
    public function deleteProduct($params)
    {
        if ($this->model->delete($params['id'])) {
            echo json_encode(['message' => 'Producto eliminado con exito']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Producto no encontrado']);
        }
    }
}
?>