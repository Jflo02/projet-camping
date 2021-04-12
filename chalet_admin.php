SELECT libelle, id_chalet, prix_base
FROM type_chalet INNER JOIN chalet on type_chalet.id_type_chalet=chalet.id_type_chalet