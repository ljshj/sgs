<?php


	
	$onload= "onsubmit=\"enviarDatosComentario(); return false\"";
	
$estilo ="

<script type=\"text/javascript\" src=\"js/highslide/highslide.js\"></script>

<script type=\"text/javascript\">

	// remove the registerOverlay call to disable the controlbar
	hs.registerOverlay(
    	{
    		thumbnailId: null,
    		overlayId: 'controlbar',
    		position: 'top right',
    		hideOnMouseOut: true
		}
	);
	
    hs.graphicsDir = 'js/highslide/graphics/';
    hs.outlineType = 'rounded-white';
    // Tell Highslide to use the thumbnail's title for captions
    hs.captionEval = 'this.thumb.title';
</script>




<style type=\"text/css\">
{
    font-family: Verdana, Helvetica;
    font-size: 10pt;
}
.highslide {
	cursor: url(js/highslide/graphics/zoomin.cur), pointer;
    outline: none;
}
.highslide-active-anchor img {
	visibility: hidden;
}
.highslide img {
	border: 2px solid gray;
}
.highslide:hover img {
	border: 2px solid white;
}

.highslide-wrapper {
	background: white;
}
.highslide-image {
    border: 2px solid white;
}
.highslide-image-blur {
}
.highslide-caption {
    display: none;
    
    border: 2px solid white;
    border-top: none;
    font-family: Verdana, Helvetica;
    font-size: 10pt;
    padding: 5px;
    background-color: white;
}
.highslide-loading {
    display: block;
	color: black;
	font-size: 8pt;
	font-family: sans-serif;
	font-weight: bold;
    text-decoration: none;
	padding: 2px;
	border: 1px solid black;
    background-color: white;
    
    padding-left: 22px;
    background-image: url(js/highslide/graphics/loader.white.gif);
    background-repeat: no-repeat;
    background-position: 3px 1px;
}
a.highslide-credits,
a.highslide-credits i {
    padding: 2px;
    color: silver;
    text-decoration: none;
	font-size: 10px;
}
a.highslide-credits:hover,
a.highslide-credits:hover i {
    color: white;
    background-color: gray;
}

.highslide-move {
    cursor: move;
}

.highslide-overlay {
	display: none;
}

a.highslide-full-expand {
	background: url(js/highslide/graphics/fullexpand.gif) no-repeat;
	display: block;
	margin: 0 10px 10px 0;
	width: 34px;
	height: 34px;
}


/* Controlbar example */
.controlbar {	
	background: url(js/highslide/graphics/controlbar4.gif);
	width: 167px;
	height: 34px;
}
.controlbar a {	
	display: block;
	float: left;
	/*margin: 0px 0 0 4px;*/	
	height: 27px;
}
.controlbar a:hover {
	background-image: url(js/highslide/graphics/controlbar4-hover.gif);
}
.controlbar .previous {
	width: 50px;
}
.controlbar .next {
	width: 40px;
	background-position: -50px 0;
}
.controlbar .highslide-move {
	width: 40px;
	background-position: -90px 0;
}
.controlbar .close {
	width: 36px;
	background-position: -130px 0;
}


/* Necessary for functionality */
.highslide-display-block {
    display: block;
}
.highslide-display-none {
    display: none;
}
</style>";





/*


* {
    font-family: Verdana, Helvetica;
    font-size: 10pt;
}

a.highslide-credits,
a.highslide-credits i {
    padding: 2px;
    color: silver;
    text-decoration: none;
	font-size: 10px;
}
a.highslide-credits:hover,
a.highslide-credits:hover i {
    color: white;
    background-color: gray;
}

*/	

?>