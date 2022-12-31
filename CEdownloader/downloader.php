<style>
    .db-list {
        list-style-type: none;
        margin: 0 !important;
        box-sizing:border-box;
        width: 100%;
        display:grid;
        grid-template-columns:repeat(2,minmax(250px,1fr));
        grid-auto-rows:170px;
        gap:15px;
        overflow-x:hidden;
        overflow-y:auto;
        height:600px;
        margin-top:20px !important;
    }

    .db-list li {
  background: #eee;
  border: solid 1px #ddd;
  padding: 10px;
height:150px;
}

    .db-list p.info{
        margin: 0 !important;
        padding: 0 !important;
        font-size: 0.9rem;
        min-height:60px;
    }

    .db-list .author {
        font-size: 0.7rem;
        opacity: 0.8;

    }

    .db-list .download {
        background: #000;
        border: none;
        color: #fff;
        padding: 0.3rem 0.5rem;
        cursor: pointer;
    }

    .db-list hr {
        border: none;
        border: solid 1px #ddd;
    }

    .searchce {
        width: 100%;
        padding: 10px;
        box-sizing: border-box;
        border: solid 1px #ddd;
    }
    .success{
        width:100%;
        background:green;
        padding:10px;
        box-sizing:border-box;
        color:#fff;
        margin-bottom:20px;
    }
</style>

<h3>GetSimple CE Downloader</h3>


<?php 

if(isset($_GET['ok'])){
    echo '<div class="success">Installed!</div>';
};

?>


<input type="text" class="searchce" placeholder="search plugin...">

<?php

global $GSADMIN;


$db = file_get_contents('https://getsimplecms-ce-plugins.github.io/db.json');
$jsondb = json_decode($db);


global $SITEURL;





echo '<ul class="db-list">';

foreach ($jsondb as $key => $value) {

    echo '
    <li><b class="title">' . $value->name . '</b>
    <p class="info">' . $value->info . '</p>
    <hr>
    <p class="author">' . $value->author . '</p>
    <form action="'.$SITEURL.'admin/load.php?id=CEdownloader&&ok=ok" method="POST">
    <input type="hidden" name="url" value="' . $value->url . '">
<input type="submit" name="download" class="download" value="download">
    </form>
    </li>
    ';
}

echo '<ul>'; ?>




<?php

 
if (isset($_POST['download'])) {

    $url = $_POST['url'];

    file_put_contents(GSPLUGINPATH . "Tmpfile.zip", fopen("$url", 'r'));

    $path = GSPLUGINPATH . "Tmpfile.zip";


    $zip = new ZipArchive;
    if ($zip->open($path) === TRUE) {

        if(file_exists(GSPLUGINPATH . "tmp_plugin/")==false){  
        mkdir(GSPLUGINPATH . "tmp_plugin/", 0755);
        };

        $zip->extractTo(GSPLUGINPATH  . "tmp_plugin/");
        $zip->close();


        foreach (glob(GSPLUGINPATH  . "tmp_plugin/*/*") as $filename) {
            if(file_exists(str_replace(pathinfo($filename)['dirname'], GSPLUGINPATH,$filename))!==true){
            rename($filename, str_replace(pathinfo($filename)['dirname'], GSPLUGINPATH, $filename));
        };
        };



        function delete_directory($dirname) {
            if (is_dir($dirname))
               $dir_handle = opendir($dirname);
            if (!$dir_handle)
               return false;
            while($file = readdir($dir_handle)) {
               if ($file != "." && $file != "..") {
                  if (!is_dir($dirname."/".$file))
                     unlink($dirname."/".$file);
                  else
                     delete_directory($dirname.'/'.$file);    
               }
            }
            closedir($dir_handle);
            rmdir($dirname);
            return true;
         };

         delete_directory(GSPLUGINPATH . "tmp_plugin");



        unlink($path);

    };
}
; ?>


<script>


document.querySelector('.searchce').addEventListener('keyup', (e) => {

document.querySelectorAll('.db-list li').forEach(
    x => {
        x.style.display = "none";
    }
);

document.querySelectorAll('.db-list li').forEach(c=>{

    if(c.querySelector('.title').innerHTML.toLowerCase().indexOf(document.querySelector('.searchce').value.toLowerCase()) > -1){
        c.style.display="block";
    }

})

});

</script>
