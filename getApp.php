<?php
header("Content-type:application/apk");

// It will be called downloaded.pdf
header("Content-Disposition:attachment;filename='دوره یاب.apk'");

// The PDF source is in original.pdf
readfile("apk/CourseFinder.apk");
?>