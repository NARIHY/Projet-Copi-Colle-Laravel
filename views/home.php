<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $params['titre'] ?></title>
    <!-- Incluaisant de bootstrap -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="text-center">
            <?= $params['body'] ?>
        </h1>
        <?php 
            use App\Form\NousContactezForm;
            $formulaire = new NousContactezForm();
            $formulaire->generate_form();
        ?>
        <h3>Environement Test</h3>
        <?php 
            $envVars = [
                'APP_NAME'=> getenv('APP_NAME'),
                'APP_ENV' => getenv('APP_ENV'),
                'DB_HOST'=> getenv('DB_HOST'),
                'DB_USER'=>getenv('DB_USER')
            ];
            foreach($params['env'] as $k => $v) {
            ?>
                <h4>
                    <?= $k ?> = <?= $v ?>
                </h4>    
            <?php
            }
        ?>
    </div>

</body>
</html> 