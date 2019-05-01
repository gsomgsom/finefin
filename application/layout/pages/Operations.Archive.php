<?php
if (Browser::is_mobile()) {
	include('Operations.Archive.Mobile.php');
}
else {
	include('Operations.Archive.Desktop.php');
}
