
<?php
include_once'db/connect_db.php';
?>

<?php
	function update_utilidad(){
		
			$invoices = $pdo->prepare("select * from tbl_invoice ");
			$invoices->execute();
			while ($invoice = $invoices->fetch(PDO::FETCH_OBJ)) {
			$detail = $pdo->prepare("select (d.qty * p.utilidad) as utilidad_p from tbl_invoice_detail d, tbl_product p where invoice_id = :invoice_id and p.product_code = d.product_code");
			$detail->bindParam(':invoice_id', $invoice->invoice_id);
			$detail->execute();
			$utilidad_total = 0;
			while ($product_detail = $detail->fetch(PDO::FETCH_OBJ)) {
				$utilidad_total += $product_detail->utilidad_p;
			}
			$update = $pdo->prepare("update tbl_invoice set utilidad_total = :utilidad_total where invoice_id = :invoice_id");
			$update->bindParam(":utilidad_total", $utilidad_total);
			$update->bindParam(":invoice_id", $invoice->invoice_id);
			$update->execute();

			
			$update = $pdo->prepare("update tbl_product set utilidad = :utilidad where productid = :product_id");
			$update->bindParam(":utilidad", $utilidad);
			$update->bindParam(":product_id", $product_id);
			$update->execute();
		}
	}
	
?>
