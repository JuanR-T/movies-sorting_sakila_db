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

//Combien de pages me faut-il ?

$moviesPerPage = 10;
$pagesNumber = ceil($nbMovies / $moviesPerPage);

//Premier film de la liste
$firstMovie = ($currentPage * $moviesPerPage) - $moviesPerPage;

//Pagination

$sqlPages = "SELECT title, category, rating, FID,price FROM film_list LIMIT :firstMovie, :moviesPerPage";

$result = $databaseConnection->prepare($sqlPages);

$result->bindValue(':firstMovie', $firstMovie, PDO::PARAM_INT);
$result->bindValue(':moviesPerPage', $moviesPerPage, PDO::PARAM_INT);
$result->execute();

// On récupère les valeurs dans un tableau associatif
$movies = $result->fetchAll(PDO::FETCH_ASSOC);

//Tri des films

$columns = array('film', 'genre', 'rental', 'rating');
$column = isset($_GET['column']) && in_array($_GET['column'], $columns) ? $_GET['column'] : $columns[0];
$sort_order = isset($_GET['order']) && strtolower($_GET['order']) == 'desc' ? 'DESC' : 'ASC';
$up_or_down = str_replace(array('ASC', 'DESC'), array('up', 'down'), $sort_order);
$asc_or_desc = $sort_order == 'ASC' ? 'desc' : 'asc';
$add_class = ' class="highlight"';
$total_reg = "10";

//Display table

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGBDR</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
    <style>
        html {
            font-family: Tahoma, Geneva, sans-serif;
            padding: 10px;
        }

        table {
            border-collapse: collapse;
            width: 500px;
        }

        th {
            background-color: #54585d;
            border: 1px solid #54585d;
        }

        th:hover {
            background-color: #64686e;
        }

        th a {
            display: block;
            text-decoration: none;
            padding: 10px;
            color: #ffffff;
            font-weight: bold;
            font-size: 13px;
        }

        th a i {
            margin-left: 5px;
            color: rgba(255, 255, 255, 0.4);
        }

        td {
            padding: 10px;
            color: #636363;
            border: 1px solid #dddfe1;
        }

        tr {
            background-color: #ffffff;
        }

        tr .highlight {
            background-color: #f9fafb;
        }
    </style>
</head>

<body>
    <table>
        <tr>
            <th><a href="<?= $asc_or_desc; ?>">Film<i class="fas fa-sort<?= $column == 'name' ? '-' . $up_or_down : ''; ?>"></i></a></th>
            <th><a href="<?= $asc_or_desc; ?>">Genre<i class="fas fa-sort<?= $column == 'age' ? '-' . $up_or_down : ''; ?>"></i></a></th>
            <th><a href="<?= $asc_or_desc; ?>">Rating<i class="fas fa-sort<?= $column == 'joined' ? '-' . $up_or_down : ''; ?>"></i></a></th>
            <th><a href="<?= $asc_or_desc; ?>">FID<i class="fas fa-sort<?= $column == 'joined' ? '-' . $up_or_down : ''; ?>"></i></a></th>
            <th><a href="<?= $asc_or_desc; ?>">Rental Price<i class="fas fa-sort<?= $column == 'joined' ? '-' . $up_or_down : ''; ?>"></i></a></th>
        </tr>
        <?php foreach ($movies as $movie) { ?>
            <tr>
                <td><?= $movie['title']; ?></td>
                <td><?= $movie['category']; ?></td>
                <td><?= $movie['rating']; ?></td>
                <td><?= $movie['FID']; ?></td>
                <td><?= $movie['price']; ?></td>
            </tr>
        <?php
        } ?>
    </table>
</body>

</html>

<?php

?>