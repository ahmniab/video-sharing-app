<?php
function isVid($file) {
    $videoExtensions = array('mp4', 'avi', 'mkv', 'mov', 'wmv');
    $file_info = pathinfo($file);
    return in_array($file_info['extension'] , $videoExtensions);

}

function only_vid_files($arr , $dir) {
    $files = array();
    foreach($arr as $path)
    {
        if (is_file($dir.$path) && isVid($dir.$path)) {
            array_push($files , $path);
        }
    }
    return $files;
}


function getFilesInDirectory($path) {
    // Get the list of files in the directory
    $files = scandir($path);
    $files = only_vid_files($files , $path);
    return array_values($files);
    
}

function get_dirs($path) {
    $path_contents = scandir($path);
    $dirs = array();
    foreach($path_contents as $folder_name)
    {
        
        if (is_dir($path.$folder_name)) {
            // echo 'yes<br>';
            array_push($dirs , $folder_name);
        }
    }
    return array_diff($dirs, array('.', '..','resources'));

}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="resources/css/bootstrap.css">
    <link rel="stylesheet" href="resources/css/all.css">
    <link rel="stylesheet" href="resources/css/home.css">
    <link rel="stylesheet" href="resources/css/vidoe.css">
    <link rel="shortcut icon" href="resources/image-removebg-preview.ico" type="image/x-icon">
    <title>Files</title>
</head>
<body>
    <?php 
        $dir ;
        if($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $dir = $_POST['folder'].'/';
        }else{
            $dir = './';
        }
    ?>
    <h1>Files in <?php echo substr($dir , 1) ?></h1>
    <div class="container">
        <?php 
        
        $fileNames = array();
        if (is_dir($dir)) {
            $fileNames = getFilesInDirectory($dir);
        }
        foreach($fileNames as $file){
                ?>
                <div class="card bg-info-subtle" style="width: 18rem;">
                <video controls  class="card-img-top video-js" alt="<?php echo $dir.$file ?>"  controls preload="auto" data-setup='{"playbackRates": [1, 1.5, 2 , 4] }'>
                    <source src="<?php echo $dir.$file ?>">
                </video>
                <div class="card-body">
                    <h5 class="card-title"><?php echo $file ?></h5>
                    <a href="<?php echo $dir.$file ?>" download="<?php echo $file ?>" class="btn btn-warning" >Download</a>
                </div>
                </div>
                
                <?php
        } ?>

    </div>
    <?php 
            $dirs = get_dirs($dir);
            if(!empty($dirs)){
                ?>
            <h1>Other Locations</h1>
            <div class="others"> 

            <?php
            foreach($dirs as $folder_name)
            {

        ?>
        <form action="" method="POST">
            <input type="hidden" name="folder" value="<?php echo $dir.$folder_name; ?>">
            <button type="submit" class="folder">
                <i class="fa-solid fa-folder"></i>
                <h5 class="title"><?php echo $folder_name; ?></h5>
            </button>
        </form>
        <?php } }?>

    </div>
    <script src="resources/js/video.js"></script>
    
</body>
</html>
<?php
    // echo '<pre>';
    // print_r($fileNames);
    // print_r($_POST);

    // // echo '<br>';
    // print_r($_SERVER);
    // print_r(scandir($dir));


    // echo '</pre>';


