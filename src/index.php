<?php
//Sur quelle page suis-je

if (isset($_GET['page']) && !empty($_GET['page'])) {
    $currentPage = (int) strip_tags($_GET['page']);
} else {
    $currentPage = 1;
}

require_once('db_connect.php');

//Combien de films y a t-il ?

$sqlTotalMovies = "SELECT COUNT(film_id) AS nb_film FROM film_category";
$query = $databaseConnection->prepare($sqlTotalMovies);
$query->execute();
$resultMovies = $query->fetch();
$nbMovies = (int) $resultMovies['nb_film'];

//Sorting

if (isset($_GET['categories']) && !empty($_GET['categories'])) {
    $getSorting = $_GET['categories'];
    $order = "ORDER BY" . " " . $_GET['categories'];
} else {
    $getSorting = "";
    $order = "";
}


if (isset($_GET['moviesPerPage']) && !empty($_GET['moviesPerPage'])) {
    $moviesPerPage = $_GET['moviesPerPage'];
} else {
    $moviesPerPage = 10;
}

//Combien de pages me faut-il ?

$pagesNumber = ceil($nbMovies / $moviesPerPage);
$pagesMax = $pagesNumber;

//Premier film de la liste

$firstMovie = ($currentPage * $moviesPerPage) - $moviesPerPage;

//Sql request

$sqlPages = "SELECT film.film_id, title, rental_rate, rating, category.name, 
COUNT(rental.rental_id) as nb_rentals FROM film 
LEFT JOIN film_category ON film.film_id = film_category.film_id
LEFT JOIN category ON film_category.category_id = category.category_id
LEFT JOIN inventory ON film.film_id = inventory.film_id
LEFT JOIN rental ON rental.inventory_id = inventory.inventory_id
GROUP BY film.film_id $order
LIMIT :firstMovie, :moviesPerPage";

$result = $databaseConnection->prepare($sqlPages);
$result->bindValue(':firstMovie', $firstMovie, PDO::PARAM_INT);
$result->bindValue(':moviesPerPage', $moviesPerPage, PDO::PARAM_INT);
$result->execute();

// On récupère les valeurs dans un tableau associatif

$movies = $result->fetchAll(PDO::FETCH_ASSOC);

//Display table

?>

<?php require_once('html.php'); ?>