<?php
  function grad(){
    $setiranGrad = "";
    if (isset($_GET['grad'])) {
      $setiranGrad = $_GET['grad'];
    }
    return ucfirst($setiranGrad);
  }

  if(grad()) {
      $urlSodrzina = file_get_contents("http://api.openweathermap.org/data/2.5/weather?q=".urlencode(grad())."&appid=6cb3264b5d41a2a0157d5fcaaa0c14e7");
      $opsegVreme = json_decode($urlSodrzina, true);
      if($opsegVreme['cod'] == 200) {
        $vreme = 'Се чини дека времето во ' . grad() . ' e ' . $opsegVreme['weather'][0]['description'] . ".";
        $temperaturaCelzius = intval($opsegVreme['main']['temp'] - 273);
        $vreme .= "Дневните температури се движат околу " . $temperaturaCelzius . "&deg;, додека брзината на ветерот изнесува ". $opsegVreme['wind']['speed']." метри во секунда.";
      } else {
        $greska = "Хмм, не можеме да го пронајдеме избраниот град.";
      }
  }
?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Временска прогноза</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="style.css">
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="container">
      <h1>Какво време не чека денес?</h1>
      <form>
        <fieldset class="form-group">
          <label for="grad">Внесете име на град по ваш избор (на латинично писмо)</label>
          <input type="text" class="form-control" name="grad" id="grad" placeholder="пр. Skopje, Prilep" value="<?php echo grad(); ?>">
        </fieldset>
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
      <div id="vreme"><?php 
      if(isset($vreme)) { 
        echo '<div class="alert alert-success" role="alert">'.$vreme.'</div>';
      } else if (isset($greska)) {
        echo '<div class="alert alert-danger" role="danger">'.$greska.'</div>';
      } 
        ?></div>
    </div>
  </body>
</html>
