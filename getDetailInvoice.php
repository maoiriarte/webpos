<?php
include_once'db/connect_db.php';
session_start();
if( isset($_GET['id']) ) {

    $invoiceId = $_GET['id'];
  
    $select = $pdo->prepare("SELECT * FROM tbl_invoice_detail WHERE invoice_id=$invoiceId");
    $select->execute();
  
    $count = 1;
    $detail = [];

    
    $count=1;
    while($item = $select->fetch(PDO::FETCH_OBJ)){
        array_push($detail, "
          <tr>
            <td>{$count}</td>
            <td>{$item->product_name}</td>
            <td>{$item->qty}</td>
            <td>$ ".number_format($item->price)."</td>
            <td>$".number_format($item->total)."</td>
          </tr>
        ");
        $count++;
      }
    
      $invoice = $pdo->prepare("SELECT * FROM tbl_invoice WHERE invoice_id=$invoiceId");
      $invoice->execute();
    
      echo json_encode([
        "detail" => $detail,
        "invoice" => $invoice->fetch(PDO::FETCH_OBJ)
      ]);

    






  }
else {
  
    echo "La trasacción no existe.";
  
}