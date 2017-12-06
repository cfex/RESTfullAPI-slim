<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

/*
 * Get all products
 * @return json
 */
$app->get('/api/customers', function (Request $request, Response $response){
		$db = new Database();
		$db->query('SELECT * FROM products');
		$results = $db->resultSet();
		return $response->withStatus(200)
			->withHeader('Content-Type', 'application/json')
			->write(json_encode($results));
});

/*
 * Get single product
 * @return json
 */
$app->get('/api/customer/{id}', function (Request $request, Response $response){
		$id = $request->getAttribute('id');
		$db = new Database();
		$db->query("SELECT * FROM products WHERE id = $id");
		$result = $db->resultSet();
		return $response->withStatus(200)
			->withHeader('Content-Type', 'application/json')
			->write(json_encode($result));

});

/*
 * Create product
 * @return bool
 */
$app->post('/api/customer/add', function (Request $request, Response $response){

		$name        = $request->getParam('name');
		$description = $request->getParam('description');
		$price       = $request->getParam('price');

		$db = new Database();
		$db->query('INSERT INTO products(name, description, price) VALUES (:name, :description, :price)');
		$db->bind(':name', $name);
		$db->bind(':description', $description);
		$db->bind(':price', $price);
		$db->execute();
});

/*
 * Update product
 * @return bool
 */
$app->put('/api/customer/update/{id}', function (Request $request, Response $response){
	$id          = $request->getAttribute('id');
	$name        = $request->getParam('name');
	$description = $request->getParam('description');
	$price       = $request->getParam('price');

	$db = new Database();
	$db->query("UPDATE products SET name = :name, description = :description, price = :price WHERE id = $id");
	$db->bind(':name', $name);
	$db->bind(':description', $description);
	$db->bind(':price', $price);
	$db->execute();
});

/*
 * Delete product
 * @return bool
 */
$app->delete('/api/customer/delete/{id}', function (Request $request, Response $response){
	$id          = $request->getAttribute('id');

	$db = new Database();
	$db->query("DELETE FROM products WHERE id = $id");
	$db->execute();
});