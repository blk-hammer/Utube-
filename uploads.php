<?php 
require_once("include/header.php");
require_once("include/classes/videoDetailsForm.php"); 
?>
<div class="columnContainer">

<?php
$formProvider= new videoDetailsFormProvider();
echo $formProvider->createUploadForm();
?>

<form class="container" style="max">
  <div class="form-group">
    <input type="file" class="form-control" id="exampleFormControlSelect1" style="border:none;padding-left:0;" placeholder="Choose File" required>
  </div>
  <div class="form-group">
    <input type="text" class="form-control" id="FormControlText" placeholder="Title">
  </div>
  <div class="form-group">
    <textarea class="form-control" id="FormControlTextarea1" rows="3" placeholder="Description"></textarea>
  </div>
  <div class="form-group">
    <label for="FormControlSelect2">Type</label>
    <select class="form-control" id="FormControlSelect2">
      <option>1</option>
      <option>2</option>
      <option>3</option>
      <option>4</option>
      <option>5</option>
    </select>
  </div>
  <div class="form-group">
    <label for="FormControlSelect3">Access</label>
    <select class="form-control" id="FormControlSelect3">
      <option>1</option>
      <option>2</option>
      <option>3</option>
      <option>4</option>
      <option>5</option>
    </select>
  </div>
</form>
</div>


<?php require_once("include/footer.php"); ?>
                