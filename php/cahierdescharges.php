<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="traitement_client.php" method="post">
        <h2>Créer ou Sélectionner un Client</h2>

        <input type="radio" id="nouveau_client" name="type_client" value="nouveau" checked>
        <label for="nouveau_client">Nouveau Client</label><br>

        <input type="radio" id="client_existant" name="type_client" value="existant">
        <label for="client_existant">Client Existant</label><br>

        <!-- Champs pour un nouveau client -->
        <div id="nouveau_client_champs">
            <input type="text" name="nom" placeholder="Nom" required>
            <input type="text" name="prenom" placeholder="Prénom" required>
            <input type="text" name="societe" placeholder="Société" required>
            <input type="text" name="siret" placeholder="SIRET" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="text" name="phone_number" placeholder="Numéro de téléphone">
        </div>

        <!-- Champs pour sélectionner un client existant -->
        <div id="client_existant_champs" style="display: none;">
            <select name="client_id">
                <!-- Ici, vous devez remplir les options avec les clients existants de votre base de données -->
                <option value="1">Client 1</option>
                <option value="2">Client 2</option>
                <!-- etc. -->
            </select>
        </div>

        <input type="submit" value="Continuer">
    </form>

    <script>
    // Script pour afficher/masquer les champs en fonction du choix de l'utilisateur
    document.getElementById('nouveau_client').addEventListener('change', function() {
        document.getElementById('nouveau_client_champs').style.display = 'block';
        document.getElementById('client_existant_champs').style.display = 'none';
    });

    document.getElementById('client_existant').addEventListener('change', function() {
        document.getElementById('nouveau_client_champs').style.display = 'none';
        document.getElementById('client_existant_champs').style.display = 'block';
    });
    </script>

</body>

</html>