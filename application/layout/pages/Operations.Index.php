<?php
if (Browser::is_mobile()) {
	include('Operations.Index.Mobile.php');
}
else {
	include('Operations.Index.Desktop.php');
}
