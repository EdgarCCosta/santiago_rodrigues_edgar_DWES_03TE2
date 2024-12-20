<?php

class ProductModel
{
    // Ruta del fichero JSON donde se almacenan los productos
    private $pathFichero = '../data/products.json';

    // Obtener todos los productos
    public function getAll()
    {
        $data = file_get_contents($this->pathFichero);
        return json_decode($data, true);
    }

    // Obtener un producto por su ID
    public function getById($id)
    {
        $products = $this->getAll();
        foreach ($products as $product) {
            if ($product['id'] == $id) {
                return $product;
            }
        }
        return null;
    }

    // Agregar un nuevo producto
    public function add($data)
    {
        $products = $this->getAll();
        if (!isset($data['id']) || empty($data['id'])) {
            $data['id'] = uniqid();
        }
        $products[] = $data;
        return file_put_contents($this->pathFichero, json_encode($products, JSON_PRETTY_PRINT));
    }


    // Actualizar un producto existente
    public function update($id, $data)
    {
        $products = $this->getAll();
        foreach ($products as &$product) {
            if ($product['id'] == $id) {
                $product = array_merge($product, $data);
                return file_put_contents($this->pathFichero, json_encode($products, JSON_PRETTY_PRINT));
            }
        }
        return false;
    }

    // Eliminar un producto por su ID
    public function delete($id)
    {
        $products = $this->getAll();
        foreach ($products as $index => $product) {
            if ($product['id'] == $id) {
                array_splice($products, $index, 1);
                return file_put_contents($this->pathFichero, json_encode($products, JSON_PRETTY_PRINT));
            }
        }
        return false;
    }
}
?>