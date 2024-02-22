<?php

include_once "../config.inc.php";
include_once APP_PATH . "/partials/header.php";
include_once APP_PATH . "/models/contact.php";
include_once APP_PATH . "/helpers/fr_date.php";
include_once APP_PATH . "/helpers/three_dots_string.php";
include_once APP_PATH . "/helpers/float_to_price.php";
include_once APP_PATH . "/models/image.php";

// Get the sorting parameters from the query string
$search = isset($_GET['search']) ? $_GET['search'] : null;
$order_by = isset($_GET['order_by']) ? $_GET['order_by'] : 'created_at';
$order = isset($_GET['order']) && $_GET['order'] == 'desc' ? 'DESC' : 'ASC';
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// Comput new order 
$new_order = $order == 'DESC' ? 'asc' : 'desc';

// Comput offset & per_page
$per_page = 10;
$offset = ($page - 1) * $per_page;

// Fetch contacts with sorting
$contacts = getContacts();

// Bottom action: delete selected contacts, ...
if (isset($_GET['delete']) && isset($_GET['selected_contacts'])) {
    $selected_contacts = explode(",", $_GET['selected_contacts']);
    foreach ($selected_contacts as $slug) {
        deletecontact($slug);
    }
    header("Location: " . $_SERVER['PHP_SELF'] . "?delete");
    exit;
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="../assets/favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Site de vente de vêtement pour femme." />
    <meta name="author" content="LALBA Anthony et SIREYJOL Victor" />
    <title>Lise des produits - NEW VET</title>
    <link href="<?= APP_URL ?>css/bootstrap.css" rel="stylesheet">
    <link href="<?= APP_URL ?>css/main.css" rel="stylesheet">
</head>

<body>
    <main>

        <?php include_once APP_PATH . "/partials/alert_message.php"; ?>

        <div class="container p-4 p-lg-5">
            <h1 class="text-center">Liste des contacts</h1>

            <!-- Barre de recherche -->
            <form class="d-flex justify-content-between my-4" method="GET">
                <input class="form-control mr-sm-2" type="search" placeholder="Rechercher" aria-label="Search" name="search" value="<?= $search ?>">
                <button class="btn btn-primary mx-2 my-sm-0" type="submit">Rechercher</button>
            </form>

            <table class="table table-striped">
                <thead>
                    <tr class="table-primary">
                        <th scope='col' colspan='1'><input type="checkbox" onclick="toggleAll()"></th>
                        <th scope='col'><a class="text-decoration-none" href="?search=<?= $search ?>&page=<?= $page ?>&order_by=name&order=<?= $new_order ?>">Email</a></th>
                        <th scope='col'><a class="text-decoration-none" href="?search=<?= $search ?>&page=<?= $page ?>&order_by=description&order=<?= $new_order ?>">Subject</a></th>
                        <th scope='col'><a class="text-decoration-none" href="?search=<?= $search ?>&page=<?= $page ?>&order_by=price&order=<?= $new_order ?>">Message</a></th>
                        <th scope='col'><a class="text-decoration-none" href="?search=<?= $search ?>&page=<?= $page ?>&order_by=stock_quantity&order=<?= $new_order ?>">Date</a></th>
                        <th scope='col' colspan='2'>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($contacts as $contact) {
                    ?>
                        <tr class="align-middle">
                            <!-- Checkbox pour la suppression multiple -->
                            <td><input id="contact_id" type="checkbox" name="selected_contacts[]" value="<?= $contact['contact_id'] ?>"></td>
                            <!-- Email -->
                            <td><?= $contact['email'] ?></td>
                            <!-- Subject -->
                            <td><?= $contact['subject'] ?></td>
                            <!-- Message -->
                            <td><?= $contact['message']?></td>
                             <!-- Date -->
                            <td><?= fr_date($contact['created_at']) ?></td>
                            <!-- Bouton de suppression -->
                            <td> <a href="<?= APP_URL ?>contacts/delete_contact.php?contact_id=<?= $contact['contact_id'] ?>" class="btn btn-danger btn-sm">Supprimer</a> </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
            <!-- Pagination -->
            <div class="d-flex justify-content-between my-2">
                <!-- Page précédente -->
                <?php if ($page > 1) : ?>
                    <a href="?search=<?= $search ?>&page=<?= $page - 1 ?>&order_by=<?= $order_by ?>&order=<?= $order ?>">Page précédent (<?= $page - 1 ?>)</a>
                <?php else : ?>
                    <span>Page précédent</span>
                <?php endif; ?>
                <!-- Page Actuelle -->
                <span>Page <?= $page ?></span>
                <!-- Page suivante -->
                <a href="?search=<?= $search ?>&page=<?= $page + 1 ?>&order_by=<?= $order_by ?>&order=<?= $order ?>">Page suivant (<?= $page + 1 ?>)</a>
            </div>
            <!-- Actions en bas de page -->
            <div class="d-flex justify-content-start gap-2 my-5">
                <button id="delete-contacts" class="btn btn-danger" disabled onclick="deleteSelectedcontacts()">Supprimer</button>
            </div>
        </div>


    </main>
</body>

</html>

<script>
    // Fonction disbale suppr button
    function disableSupprButton() {
        var btn = document.getElementById('delete-contacts');
        btn.disabled = true;
    }

    // Fonction enable suppr button
    function enableSupprButton() {
        var btn = document.getElementById('delete-contacts');
        btn.disabled = false;
    }

    // Fonction pour cocher/décocher toutes les cases
    function toggleAll() {
        var checkboxes = document.getElementsByName('selected_contacts[]');
        for (var checkbox of checkboxes) {
            checkbox.checked = event.target.checked;
        }
        if (event.target.checked) {
            enableSupprButton();
        } else {
            disableSupprButton();
        }
    }

    // Fonction pour supprimer les contacts sélectionnés
    function deleteSelectedcontacts() {
        var checkboxes = document.getElementsByName('selected_contacts[]');
        var selected_contacts = [];
        for (var checkbox of checkboxes) {
            if (checkbox.checked) {
                selected_contacts.push(checkbox.value);
            }
        }
        console.log(selected_contacts);
        if (selected_contacts.length > 0) {
            if (confirm("Voulez-vous vraiment supprimer les éléments sélectionnés ?")) {
                window.location.href = "<?= $_SERVER['PHP_SELF'] ?>?delete&selected_contacts=" + selected_contacts.join(",");
            }
        } else {
            alert("Vous devez sélectionner au moins un élément à supprimer");
        }
    }

    // Désactiver le bouton de suppression si aucune case n'est cochée
    var checkboxes = document.getElementsByName('selected_contacts[]');
    for (var checkbox of checkboxes) {
        checkbox.addEventListener('change', function() {
            if (this.checked) {
                enableSupprButton();
            } else {
                disableSupprButton();
            }
        });
    }
</script>