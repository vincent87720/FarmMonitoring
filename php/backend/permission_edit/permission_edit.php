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
                <p id="permission_list_edit_status" class="text-center"></p>
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
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModalCenter">刪除權限</button>

                    <!-- Modal -->
                    <div class="modal fade" id="deleteModalCenter" tabindex="-1" role="dialog" aria-labelledby="deleteModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteModalCenterTitle">刪除權限</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                確定要刪除<?php echo $_POST['permissionInfo'][2]."的\"".$_POST['permissionInfo'][0]." ".$_POST['permissionInfo'][1]."\"權限?";?>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                                <button type="button" class="btn btn-danger" onclick=deletePermission(<?php echo "\"".$_POST['permissionInfo'][0]."\",\"".$_POST['permissionInfo'][1]."\",\"".$_POST['permissionInfo'][2]."\"";?>)>確認刪除</button>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
        <script>
            function deletePermission(manage_farm,manage_identity,manage_username)
            {
                $.ajax({
                        type : "post",
                        url : "php/backend/delete_permission.php",
                        data : 
                        {
                            'manage_farm':manage_farm,
                            'manage_identity':manage_identity,
                            'manage_username':manage_username
                        }
                    }).done(function(data){
                        $('#deleteModalCenter').modal('hide');
                        //console.log(data);
                        if(data=='deletePermissionSuccess')
                        {
                            //刪除資料成功
                            document.getElementById("permission_list_edit_status").innerHTML = '<div class="alert alert-success alert-dismissible fade show" role="alert"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>權限已刪除</div>';
                            setTimeout('window.location.href = "account.php";',3000);
                        }
                        else if(data=='deletePermissionFail')
                        {
                            //刪除資料失敗
                            document.getElementById("permission_list_edit_status").innerHTML = '<div class="alert alert-danger alert-dismissible fade show" role="alert"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>權限刪除失敗</div>';
                            setTimeout('window.location.href = "account.php";',3000);
                        }
                        else
                        {
                            //console.log(data);
                        }
                    }).fail(function(jqXHR,textStatus,errorThrown){
                        //console.log(jqXHR);console.log(textStatus);console.log(errorThrown);
                    });
            }

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