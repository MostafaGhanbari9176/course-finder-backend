<?php
header("Content-type:application/vnd.android.package-archive");

// It will be called downloaded.pdf
header("Content-Disposition:attachment;filename="."CourseFinder".".apk");

// The PDF source is in original.pdf
readfile("apk/MGApp.apk");

