<?php
function ImageToDataUrl(String $filename) : String {
    if(!file_exists($filename)) // nanti disini ilangin public stringnya, public/uploads/charts/chart.png
        throw new Exception('File not found.');
    
    $mime = mime_content_type($filename);
    if($mime === false) 
        throw new Exception('Illegal MIME type.');

    $raw_data = file_get_contents($filename);
    if(empty($raw_data))
        throw new Exception('File not readable or empty.');
    
    return "data:{$mime};base64," . base64_encode($raw_data);
}
?>


<?php foreach ($image_urls as $image_url) : ?>
    <div class=page_break>
        <img src="<?= ImageToDataUrl($image_url); ?>">
    </div>
<?php endforeach ?>