<?php
include 'mylib.php';

$error = db_connect();
if ($error !== null) {
    die("Connection failed: " . $error);
}

$storeName = $_POST['storeName'];
$editOption = $_POST['editOption'];

if ($editOption === 'edit') {
    $newStoreName = $_POST['newStoreName']; 

    $query = "UPDATE Store SET sname='$newStoreName' WHERE sname='$storeName'";
    $result = $db->query($query);

    if ($result === TRUE) {
		echo "Store name updated successfully";
		echo "<p><a href='editStore.php'>Go back to Edit Store page</a></p>";
	} else {
		echo "Error updating store name: " . $db->error;
		echo "<p><a href='editStore.php'>Go back to Edit Store page</a></p>";
	}
} elseif ($editOption === 'delete') {
    $checkPurchaseQuery = "SELECT * FROM Purchase WHERE sname='$storeName'";
    $purchaseResult = $db->query($checkPurchaseQuery);

    if ($purchaseResult->num_rows > 0) {
        echo "Error: Cannot delete store. There are purchases associated with it.";
		echo "<p><a href='editStore.php'>Go back to Edit Store page</a></p>";
    } else {
        $deleteQuery = "DELETE FROM Store WHERE sname='$storeName'";
        $deleteResult = $db->query($deleteQuery);

        if ($deleteResult === TRUE) {
            echo "Store deleted successfully";
			echo "<p><a href='editStore.php'>Go back to Edit Store page</a></p>";
        } else {
            echo "Error deleting store: " . $db->error;
			echo "<p><a href='editStore.php'>Go back to Edit Store page</a></p>";
        }
    }
}

$db->close();
?>