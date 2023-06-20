<!DOCTYPE html>
<html>

<head>
    <style>
    body {
        font-family: Arial, sans-serif;
    }

    form {
        margin: 0 auto;
        width: 300px;
        padding: 1em;
        border: 1px solid #CCC;
        border-radius: 1em;
    }

    form div+div {
        margin-top: 1em;
    }

    input,
    select {
        font: 1em sans-serif;
        width: 300px;
        box-sizing: border-box;
        border: 1px solid #999;
    }

    input[type="submit"] {
        width: auto;
        padding: 0.5em;
    }
    </style>
</head>

<body>
    <form action="add_project.php" method="post">
        <div>
            <label for="nom_projet">Nom du projet:</label>
            <input type="text" id="nom_projet" name="nom_projet">
        </div>
        <div>
            <label for="id_client">Client:</label>
            <select id="id_client" name="id_client">
                <!-- Les options seront générées dynamiquement par PHP -->
            </select>
        </div>
        <div>
            <label for="id_user_developpeur">ID du développeur:</label>
            <input type="text" id="id_user_developpeur" name="id_user_developpeur">
        </div>
        <div>
            <label for="id_user_assistant">ID de l'assistant:</label>
            <input type="text" id="id_user_assistant" name="id_user_assistant">
        </div>
        <div>
            <label for="nom_domaine">Nom de domaine:</label>
            <input type="text" id="nom_domaine" name="nom_domaine">
        </div>
        <div>
            <input type="submit" value="Créer un projet">
        </div>
    </form>
</body>

</html>