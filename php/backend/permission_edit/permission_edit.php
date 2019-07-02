<?php 
@require_once '../../connect.php';
@require_once '../function.php';

if(!isset($_SESSION['is_login'])||$_SESSION['is_login']==FALSE):
{
    @header("Location: /index.php");
}
else:
?>
<!DOCTYPE HTML>
<html>
    <head>
    </head>
    <body>
        <div class="row">
            <div class="col-sm-10 ml-auto mr-auto">
                <p id="edit_status" class="text-center"></p>
                <form id="permission_change_form">
                <div class="form-group">
                    <label for="manage_username">Username</label>
                    <input type="text" class="form-control" id="manage_username" value="" readonly>
                </div>
                <div class="form-group">
                    <label for="manage_farm">Farm</label>
                    <input type="text" class="form-control" id="manage_farm" value="" readonly>
                </div>
                <div class="form-group">
                    <label for="manage_identity">Identity</label>
                    <input type="text" class="form-control" id="manage_identity" value="" readonly>
                </div>
                <div class="form-group">
                    <label for="manage_applicationDateTime">ApplicationDateTime</label>
                    <input type="text" class="form-control" id="manage_applicationDateTime" value="" readonly>
                </div>
                <div class="form-group">
                    <label for="manage_auditDateTime">AuditDateTime</label>
                    <input type="text" class="form-control" id="manage_auditDateTime" value="" readonly>
                </div>
                <div class="form-group">
                    <label for="manage_auditor">Auditor</label>
                    <input type="text" class="form-control" id="manage_auditor" value="" readonly>
                </div>
                <div class="col-sm-12 text-center">
                    <a href="../../../account.php" class="btn btn-info" role="button" aria-pressed="true" id="backbutton">返回</a>
                    <!-- <button type="submit" class="btn btn-info">刪除權限</button> -->
                </div>
                </form>
            </div>
        </div>
        <script>

            $(document).ready(function(){
                $('#manage_username').val("<?php echo $_POST['permissionInfo'][2];?>");
                $('#manage_farm').val("<?php echo $_POST['permissionInfo'][0];?>");
                $('#manage_identity').val("<?php echo $_POST['permissionInfo'][1];?>");
                $('#manage_applicationDateTime').val("<?php echo $_POST['permissionInfo'][3];?>");
                $('#manage_auditDateTime').val("<?php echo $_POST['permissionInfo'][4];?>");
                $('#manage_auditor').val("<?php echo $_POST['permissionInfo'][5];?>");
                
            });
        </script>
    </body>
</html>

<?php
endif;
?>