<?php

include_once APP_PATH . '/helpers/slugify.php';

function getMaterial($slug)
{
    $dbh = db_connect();
    $sql = "SELECT * FROM material WHERE slug = :slug;";
    try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":slug" => $slug));
        $material = $sth->fetch(PDO::FETCH_ASSOC);
        log_txt("Read material: slug $slug");
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL : " . $e->getMessage());
    }

    return $material;
}

function getMaterials($search = null, $order_by = 'created_at', $order = 'ASC', $offset = null, $per_page = 10)
{
    $dbh = db_connect();

    // Select all materials
    $sql = "SELECT * FROM material";

    // Use WHERE 1 = 1 to be able to add conditions with AND
    $sql .= " WHERE 1 = 1";

    $sql .= " AND is_deleted = 0";

    // Filter by search
    if ($search) $sql .= " AND libelle LIKE :search";

    $sql .= " ORDER BY $order_by $order";
    if ($per_page) $sql .= " LIMIT :per_page";
    if ($offset) $sql .= " OFFSET :offset";

    try {
        $sth = $dbh->prepare($sql);

        // Bind values
        if ($search) $sth->bindValue(":search", "%$search%");
        if ($per_page) $sth->bindValue(":per_page", $per_page, PDO::PARAM_INT);
        if ($offset) $sth->bindValue(":offset", $offset, PDO::PARAM_INT);

        $sth->execute();

        $materials = $sth->fetchAll(PDO::FETCH_ASSOC);
        log_txt("Read materials");
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL : " . $e->getMessage());
    }

    return $materials;
}

function getMaterialsFromProduct($product_slug)
{
    $dbh = db_connect();
    $sql = "SELECT material.* FROM product, product_material, material 
    WHERE product.slug = :product_slug AND material.is_deleted = 0
    AND product_material.material_slug = material.slug AND product_material.product_slug = product.slug;";
    try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":product_slug" => $product_slug));
        $materials = $sth->fetchAll(PDO::FETCH_ASSOC);
        log_txt("Read materials");
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL : " . $e->getMessage());
    }

    return $materials;
}

function insertMaterial($material)
{
    $dbh = db_connect();

    $sql = "INSERT INTO material (libelle, slug, color) VALUES (:libelle, :slug, :color)";

    if (!$material['slug']) $material['slug'] = slugify($material['libelle']);

    try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":libelle" => $material['libelle'], ":slug" => $material['slug'], ":color" => $material['color']));
        if ($sth->rowCount() > 0) {
            log_txt("Material registered in back office: slug " . $material['slug']);
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL : " . $e->getMessage());
    }
}

function updateMaterial($material)
{
    $dbh = db_connect();

    $sql = "UPDATE material SET libelle = :libelle, color = :color WHERE slug = :slug";

    try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":libelle" => $material['libelle'], ":slug" => $material['slug'], ":color" => $material['color']));
        if ($sth->rowCount() > 0) {
            log_txt("Material updated in back office: slug " . $material['slug']);
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL : " . $e->getMessage());
    }
}

function deleteMaterial($slug)
{
    $dbh = db_connect();

    $sql = "UPDATE material SET is_deleted = 1 WHERE slug = :slug";

    try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":slug" => $slug));
        if ($sth->rowCount() > 0) {
            log_txt("Material deleted in back office: slug " . $slug);
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL : " . $e->getMessage());
    }
}