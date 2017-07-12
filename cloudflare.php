<?php
session_cache_limiter('none');
ini_set('memory_limit', '100M');
set_time_limit(0);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//DEFINE ACCOUNT

define('CLOUDFLARE_EMAIL', 'alie2@fakedns.pro');
define('CLOUDFLARE_KEY', '9cbb266e777c45666252ae18df02fd4e1b415');
define('CLOUDFLARE_USERID', 'b8646637cb6f09ad9c0c4ff92de50503');

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Cloudflare</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="http://getbootstrap.com/examples/theme/theme.css">
  <link rel="stylesheet" href="http://getbootstrap.com/examples/starter-template/starter-template.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script>
    function select_all(source) {
        checkboxes = document.getElementsByName('domains[]');
        for(var i in checkboxes)
            checkboxes[i].checked = source.checked;
    }
  </script>
</head>
<body>
    
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand active" href="/cloudflare.php">Cloudflare</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
        <ul class="nav navbar-nav">
            <li><a href="/cloudflare.php?act=add-zone">Add Domains</a></li>
            <li><a href="/cloudflare.php?act=get-zone">My Domains</a></li>
            <li><a href="/cloudflare.php?act=user">My Account</a></li>
        </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>

<div class="container">
<div class="starter-template">
    <h3>Cloudflare</h3>
</div>

<?php
if(isset($_GET['act'])) {
  //ADD DOMAINS
  if($_GET['act'] == 'add-zone') {
  ?>
    <form action="" method="post">
    <div class="form-group">
    <textarea name="domains" class="form-control" rows="20" cols="10" style="width:100%;" placeholder="Enter domains in newline"><?php echo (isset($_POST['domains']) ? $_POST['domains'] : ''); ?></textarea><br>
    <span width="30px"><input type="checkbox" name="add_cloudflare" id="add_cloudflare" value="yes"></span>
    <span><label for="add_cloudflare">Set CNAME</label></span>
    <span><input type="text" name="cname" value="<?php echo (isset($_POST['cname']) ? $_POST['cname'] : ''); ?>" size="40" class="form-control"></span><br>
    <button type="submit" class="btn btn-primary">Add Domains</button>
    </div>
    </form>
    
    <?php
    //debug($_POST);
    if(isset($_POST['domains'])) {
      $domains = array_map('trim', preg_split('/\r\n|[\r\n]/', $_POST['domains']));
      //debug($domains);
      echo '<table class="table">';
      foreach($domains as $domain) {
        $zone = create_zone($domain); debug($zone);
        if($zone['success'] == 1) {
          echo '<tr><th rowspan="2">'.$zone['result']['name'].'</th>'."\r\n";
          if(isset($zone['result']['id']) && isset($_POST['add_cloudflare'])) {
            $dns[] = create_dns($zone['result']['id'], 'CNAME', $zone['result']['name'], $_POST['cname']);
            $dns[] = create_dns($zone['result']['id'], 'CNAME', 'www.'.$zone['result']['name'], $_POST['cname']);
            echo '<td>'.$dns[0]['result']['type'].'</td><td>'.$dns[0]['result']['name'].'</td><td>'.$dns[0]['result']['content'].'</td></tr>'."\r\n";
            echo '<tr><td>'.$dns[1]['result']['type'].'</td><td>'.$dns[1]['result']['name'].'</td><td>'.$dns[1]['result']['content'].'</td></tr>'."\r\n";
          }
        }
      }
      echo '</table>';
    }
  }
  
  //GET ZONE
  if($_GET['act'] == 'get-zone') {
    $page = (isset($_GET['page']) ? $_GET['page'] : 1);
    $zones = list_zone($page, 50);
    ?>
    <form action="" method="post">
    <div class="form-group">
    <div class="input-group">
      <input type="text" name="q" class="form-control" <?php echo (isset($_POST['q']) ? 'value="'.$_POST['q'].'"' : 'placeholder="Search domains"'); ?>>
      <span class="input-group-btn"><button class="btn btn-primary" type="submit">Search</button></span>
    </div><br>
    <span width="30px"><input type="checkbox" name="add_cloudflare" id="add_cloudflare" value="yes"></span>
    <span><label for="add_cloudflare">Set CNAME</label></span>
    <div class="input-group">
      <input type="text" name="cname" class="form-control" <?php echo (isset($_POST['cname']) ? 'value="'.$_POST['cname'].'"' : 'placeholder="CNAME"'); ?>>
      <span class="input-group-btn"><button class="btn btn-primary" type="submit">Submit</button></span>
    </div><br>
    </div>
    <table class="table">
    <tr><td width="30px"><input type="checkbox" id="select-all" onClick="select_all(this)"></td><th><label for="select-all">Check All</label></th></tr>
    <?php
    $q = (!empty($_POST['q']) ? $_POST['q'] : '.');
    //debug($_POST);
    foreach($zones['result'] as $list) {
        if(strpos($list['name'], $q) !== false) {
            echo '<tr><td width="30px"><input class="checkbox" type="checkbox" name="domains[]" value="'.$list['name'].','.$list['id'].'" id="'.$list['name'].'"></td>
            <td><label style="font-weight:normal;" for="'.$list['name'].'">'.$list['name'].'</label></td>
            <td><a href="http://'.$list['name'].'" target="_blank">Visit Site</a></td>
            <td><a href="https://www.google.com/search?q=site:'.$list['name'].'" target="_blank">Check Index</a></td></tr>'."\r\n";
        }
    }
    echo '    </table></form>';
    
    if(isset($_POST['domains']) && isset($_POST['add_cloudflare'])) {
      echo '<table class="table">';
      foreach($_POST['domains'] as $list) {
        $list = explode(',', $list);
        $list_dns = list_dns($list[1]);
        $dns = array();
        echo '<tr><th rowspan="2">'.$list[0].'</th>'."\r\n";
        if($list_dns['result_info']['count'] > 0) foreach($list_dns['result'] as $cname) {
            if($cname['type'] == 'CNAME') {
                $dns[] = update_dns($cname['zone_id'], $cname['id'], $cname['type'], $cname['name'], $_POST['cname']);
            }
        } else {
            $dns[] = create_dns($list[1], 'CNAME', $list[0], $_POST['cname']);
            $dns[] = create_dns($list[1], 'CNAME', 'www.'.$list[0], $_POST['cname']);
        }
        echo '<td>'.$dns[0]['result']['type'].'</td><td>'.$dns[0]['result']['name'].'</td><td>'.$dns[0]['result']['content'].'</td></tr>'."\r\n";
        echo '<tr><td>'.$dns[1]['result']['type'].'</td><td>'.$dns[1]['result']['name'].'</td><td>'.$dns[1]['result']['content'].'</td></tr>'."\r\n";
      }
      echo '</table>';
    }
    ?>

    <nav aria-label="...">
      <ul class="pager">
        <li class="previous"><a href="/cloudflare.php?act=get-zone&page=<?php echo ($page-1); ?>">Prev</a></li>
        <li class="next"><a href="/cloudflare.php?act=get-zone&page=<?php echo ($page+1); ?>">Next</a></li>
      </ul>
    </nav>
    <?php
  }
  
  //GET USER
  if($_GET['act'] == 'user') {
    debug(get_user());
  }
}


function get_contents($url) {
    if(function_exists('curl_exec')) {
        $header[0] = "Accept-Language: en";
        $header[] = "User-Agent: Mozilla/5.0 (Windows; U; Windows NT 6.0; de; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3";
        $header[] = "Pragma: no-cache";
        $header[] = "Cache-Control: no-cache";
        $header[] = "Accept-Encoding: gzip,deflate";
        $header[] = "Content-Encoding: gzip";
        $header[] = "Content-Encoding: deflate";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 100);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($ch);
        curl_close($ch);
    }
    return $data;
}
//CLOUDFLARE
function get_user() {
    $url = 'https://api.cloudflare.com/client/v4/user';
    if(function_exists('curl_exec')) {
        $header[0] = "Accept-Language: en";
        $header[] = "User-Agent: Mozilla/5.0 (Windows; U; Windows NT 6.0; de; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3";
        $header[] = "Pragma: no-cache";
        $header[] = "Cache-Control: no-cache";
        $header[] = "Accept-Encoding: gzip,deflate";
        $header[] = "Content-Encoding: gzip";
        $header[] = "Content-Encoding: deflate";
        $header[] = "X-Auth-Email: ".CLOUDFLARE_EMAIL;
        $header[] = "X-Auth-Key: ".CLOUDFLARE_KEY;
        $header[] = "Content-Type: application/json";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 100);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($ch);
        curl_close($ch);
    }
    return json_decode($data, 1);
}
function list_zone($page=1, $perpage=50) {
    $url = 'https://api.cloudflare.com/client/v4/zones?status=active&page='.$page.'&per_page='.$perpage;
    if(function_exists('curl_exec')) {
        $header[0] = "Accept-Language: en";
        $header[] = "User-Agent: Mozilla/5.0 (Windows; U; Windows NT 6.0; de; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3";
        $header[] = "Pragma: no-cache";
        $header[] = "Cache-Control: no-cache";
        $header[] = "Accept-Encoding: gzip,deflate";
        $header[] = "Content-Encoding: gzip";
        $header[] = "Content-Encoding: deflate";
        $header[] = "X-Auth-Email: ".CLOUDFLARE_EMAIL;
        $header[] = "X-Auth-Key: ".CLOUDFLARE_KEY;
        $header[] = "Content-Type: application/json";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 100);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($ch);
        curl_close($ch);
    }
    return json_decode($data, 1);
}
function create_zone($domain) {
    $data = '{"name":"'.$domain.'","jump_start":true,"user":{"id":"'.CLOUDFLARE_USERID.'","name":"Nekaters, Inc.","status":"active","permissions":["#zones:read"]}}';
    $url = 'https://api.cloudflare.com/client/v4/zones';
    if(function_exists('curl_exec')) {
        $header[0] = "Accept-Language: en";
        $header[] = "User-Agent: Mozilla/5.0 (Windows; U; Windows NT 6.0; de; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3";
        $header[] = "Pragma: no-cache";
        $header[] = "Cache-Control: no-cache";
        $header[] = "Accept-Encoding: gzip,deflate";
        $header[] = "Content-Encoding: gzip";
        $header[] = "Content-Encoding: deflate";
        $header[] = "X-Auth-Email: ".CLOUDFLARE_EMAIL;
        $header[] = "X-Auth-Key: ".CLOUDFLARE_KEY;
        $header[] = "Content-Type: application/json";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 100);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $data = curl_exec($ch);
        curl_close($ch);
    }
    return json_decode($data, 1);
}
function list_dns($zoneid) {
    $url = 'https://api.cloudflare.com/client/v4/zones/'.$zoneid.'/dns_records';
    if(function_exists('curl_exec')) {
        $header[0] = "Accept-Language: en";
        $header[] = "User-Agent: Mozilla/5.0 (Windows; U; Windows NT 6.0; de; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3";
        $header[] = "Pragma: no-cache";
        $header[] = "Cache-Control: no-cache";
        $header[] = "Accept-Encoding: gzip,deflate";
        $header[] = "Content-Encoding: gzip";
        $header[] = "Content-Encoding: deflate";
        $header[] = "X-Auth-Email: ".CLOUDFLARE_EMAIL;
        $header[] = "X-Auth-Key: ".CLOUDFLARE_KEY;
        $header[] = "Content-Type: application/json";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 100);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($ch);
        curl_close($ch);
    }
    return json_decode($data, 1);
}
function create_dns($zoneid, $type, $name, $content) {
    $url = 'https://api.cloudflare.com/client/v4/zones/'.$zoneid.'/dns_records';
    $data = '{"type":"'.$type.'","name":"'.$name.'","content":"'.$content.'","proxied":true}';
    if(function_exists('curl_exec')) {
        $header[0] = "Accept-Language: en";
        $header[] = "User-Agent: Mozilla/5.0 (Windows; U; Windows NT 6.0; de; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3";
        $header[] = "Pragma: no-cache";
        $header[] = "Cache-Control: no-cache";
        $header[] = "Accept-Encoding: gzip,deflate";
        $header[] = "Content-Encoding: gzip";
        $header[] = "Content-Encoding: deflate";
        $header[] = "X-Auth-Email: ".CLOUDFLARE_EMAIL;
        $header[] = "X-Auth-Key: ".CLOUDFLARE_KEY;
        $header[] = "Content-Type: application/json";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 100);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $data = curl_exec($ch);
        curl_close($ch);
    }
    return json_decode($data, 1);
}
function update_dns($zoneid, $id, $type, $name, $content) {
    $url = 'https://api.cloudflare.com/client/v4/zones/'.$zoneid.'/dns_records/'.$id;
    $data = '{"type":"'.$type.'","name":"'.$name.'","content":"'.$content.'","proxied":true}';
    if(function_exists('curl_exec')) {
        $header[0] = "Accept-Language: en";
        $header[] = "User-Agent: Mozilla/5.0 (Windows; U; Windows NT 6.0; de; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3";
        $header[] = "Pragma: no-cache";
        $header[] = "Cache-Control: no-cache";
        $header[] = "Accept-Encoding: gzip,deflate";
        $header[] = "Content-Encoding: gzip";
        $header[] = "Content-Encoding: deflate";
        $header[] = "X-Auth-Email: ".CLOUDFLARE_EMAIL;
        $header[] = "X-Auth-Key: ".CLOUDFLARE_KEY;
        $header[] = "Content-Type: application/json";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 100);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $data = curl_exec($ch);
        curl_close($ch);
    }
    return json_decode($data, 1);
}

function debug($var) {
    echo '<pre>'; print_r($var); echo '</pre>';
}
?>

</div>

</body>
</html>