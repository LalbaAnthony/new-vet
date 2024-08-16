<?php if (isset($_GET['created'])) : ?>
    <?php if ($_GET['created'] === '1') : ?>
        <div class="alert alert-success" role="alert">
            La création a bien été effectuée !
        </div>
    <?php else : ?>
        <div class="alert alert-danger" role="alert">
            La création n'a pas été effectuée. Veuillez réessayer !
        </div>
    <?php endif; ?>
<?php endif; ?>
<?php if (isset($_GET['updated'])) : ?>
    <?php if ($_GET['updated'] === '1') : ?>
        <div class="alert alert-success" role="alert">
            La modification a bien été effectuée !
        </div>
    <?php else : ?>
        <div class="alert alert-danger" role="alert">
            La modification n'a pas été effectuée. Veuillez réessayer !
        </div>
    <?php endif; ?>
<?php endif; ?>
<?php if (isset($_GET['deleted'])) : ?>
    <?php if ($_GET['deleted'] === '1') : ?>
        <div class="alert alert-success" role="alert">
            La supression a bien été effectuée !
        </div>
    <?php else : ?>
        <div class="alert alert-danger" role="alert">
            La supression n'a pas été effectuée. Veuillez réessayer !
        </div>
    <?php endif; ?>
<?php endif; ?>
<?php if (isset($_GET['uploaded'])) : ?>
    <?php if ($_GET['uploaded'] === '1') : ?>
        <div class="alert alert-success" role="alert">
            Le fichier a bien été téléchargé !
        </div>
    <?php else : ?>
        <div class="alert alert-danger" role="alert">
            Le fichier n'a pas pu été téléchargé. Veuillez réessayer !
        </div>
    <?php endif; ?>
<?php endif; ?>
<?php if (isset($_GET['missing_fields'])) : ?>
    <div class="alert alert-danger" role="alert">
        Les champs suivants sont manquants : <?= $_GET['missing_fields'] ?>
    </div>
<?php endif; ?>

<script>
    // Supprime les messages d'alerte après 5 secondes
    setTimeout(function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            if (alert) alert.remove();
        });
    }, 5000);
</script>