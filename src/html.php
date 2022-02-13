<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGBDR</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <div class="text-center d-flex flex-column align-items-center">
        <form class="text-center d-inline-flex p-2 bd-highlight" method="GET">
            <select class="browser-default custom-select mx-2" name="moviesPerPage">
                <option value="" disabled selected>Afficher <?= $moviesPerPage ?> films</option>
                <option value="10">Afficher 10 films</option>
                <option value="20">Afficher 20 films</option>
                <option value="30">Afficher 30 films</option>
                <option value="40">Afficher 40 films</option>
                <option value="50">Afficher 50 films</option>
                <option value="100">Afficher 100 films</option>
            </select>
            <select class="browser-default custom-select mx-2" name="categories">
                <option value="" disabled selected>Trier par : <?= $getSorting ?></option>
                <option value="title ASC">Titre ascendant</option>
                <option value="title DESC">Titre descendant</option>
                <option value="name ASC">Categorie ascendante</option>
                <option value="name DESC">Categorie descendante</option>
                <option value="rating ASC">Notation ascendante</option>
                <option value="rating DESC">Notation descendante</option>
                <option value="nb_rentals ASC">Locations ascendante</option>
                <option value="nb_rentals DESC">Locations descendante</option>
                <option value="rental_rate ASC">Prix ascendant</option>
                <option value="rental_rate DESC">Prix descendant</option>
            </select>
            <input type="submit" name="submit" value="Get sorting" class="btn btn-primary mx-2 "></input>
        </form>
        <nav>
            <ul class="pagination">
                <li class="page-item <?= ($currentPage == 1) ? "disabled" : "" ?>">
                    <a href="./?page=<?= $currentPage - 1 ?>&moviesPerPage=<?= urlencode($moviesPerPage) ?>&categories=<?= urlencode($getSorting) ?>" class="page-link">Previous</a>
                </li>

                <?php for ($pagesNumber = 1; $pagesNumber <= $pagesMax; $pagesNumber++) : ?><?php endfor ?>
                <li class="page-item <?= ($currentPage == $pagesNumber) ? "active" : "" ?>d-flex align-items-center border border-5 border-primary mx-2 rounded">
                    <div class="mx-2"><?= $currentPage ?>/<?= $pagesMax ?></div>
                </li>

                <li class="page-item <?= ($currentPage == $pagesMax) ? "disabled" : "" ?>">
                    <a href="./?page=<?= $currentPage + 1 ?>&moviesPerPage=<?= urlencode($moviesPerPage) ?>&categories=<?= urlencode($getSorting) ?>" class="page-link">Next</a>
                </li>
            </ul>
        </nav>
    </div>
    <table class="table table-dark">
        <tr>
            <th>Film</th>
            <th>Genre</th>
            <th>Notation</th>
            <th>Locations</th>
            <th>Prix</th>
        </tr>
        <?php foreach ($movies as $movie) { ?>
            <tr>
                <td><?= $movie['title']; ?></td>
                <td><?= $movie['name']; ?></td>
                <td><?= $movie['rating']; ?></td>
                <td><?= $movie['nb_rentals'] ?></td>
                <td><?= $movie['rental_rate']; ?></td>

            </tr>
        <?php
        } ?>
    </table>
</body>

</html>

<?php

?>