<?php 
require_once("include/header.php");
require_once("include/classes/videoDetailsForm.php"); 
?>
<div class="columnContainer">

<?php
$formProvider= new videoDetailsFormProvider($conn1);
echo $formProvider->createUploadForm();
  
?>

</div>

<!-- Modal -->
<script>
$("form").submit(function(){
    $("#loadingModal").modal("show");
});
</script>

<div class="modal fade" id="loadingModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" data-backdrop="static" data-keyboard="false" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document" style="width:135px;height:100px;">
    <div class="modal-content">
      <div class="modal-body" style="backround-color:black;align-content:center;">
        <img src="assets/images/icons/loading-spinner.gif" alt="loading" style="align-content:center;width:100px;height:100px;">
      </div>
    </div>
  </div>
</div>

<?php require_once("include/footer.php"); ?>
                