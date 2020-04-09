<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="styles/style.css">
  <title>Webbshop</title>
</head>
<body>
  <h1>Hello, World!</h1>
    <nav class="">
      <a href="index.php?id=alla">Alla produkter</a>
      <a href="index.php?id=mat">Mat</a>
      <a href="index.php?id=hygien">Hygien</a>
      <a href="index.php?id=blommor">Blommor</a>
    </nav>
  <?php require_once 'read.php' ?>
  <p>Kopplas ihop med rätt databas, se db.php, read.php</p>
</body>
</html>