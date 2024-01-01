<?php echo $this->extend('layout/main'); ?>

<?php echo $this->section('content'); ?>

<h2>User List</h2>
<a href="<?php echo base_url(); ?>user/add"><Button class="btn btn-primary btn-sm">Add User</Button></a>

<table class="striped">
    <thead>
        <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Username</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        if(!empty($user_data)){
            foreach ($user_data as $user){ 
        ?>
            <tr>
                <td><?= $user['first_name'] ?></td>
                <td><?= $user['last_name'] ?></td>
                <td><?= $user['username'] ?></td>
                <td>                    
                    <!-- <a href='<?php //echo base_url(); ?>user/add?id=<?php //echo $user['user_id']; ?> ' id="edit_btn_<?php //echo $user['user_id'] ?>" onClick="editData(<?php //echo $user['user_id']; ?>)" >Edit</a> | <a href="#">Delete</a> -->
                    <Button class="btn btn-success" onClick="editData(<?php echo $user['user_id']; ?>)" >Edit</Button> | <Button class="btn red darken-4" onClick="deleteData(<?php echo $user['user_id']; ?>)">Delete</Button>
                </td>
            </tr>
        <?php  
            }
        }
        else{
            ?>
            <span>No Records Found</span>
            <?php
        }
        ?>
    </tbody>
</table>

<script>

    // Edit Action here
            
    function editData(id){
        Swal.fire({
            title: "Do you want to Edit the changes?",
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: "Edit",
            denyButtonText: `Don't Edit`
        }).then((result) => {           
            if (result.isConfirmed) {
                window.location = 'add?id='+id;
            } else if (result.isDenied) {
                Swal.fire("Edit Cancelled", "", "info");
            }
        });

    }

    function deleteData(id){
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
            }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    beforeSend:function(){

                    },
                    url:'<?php echo base_url(); ?>user/delete?id='+id,
                    success:function(data){
                        var resp = data.split('::');

                        if(resp[0]==200){
                            Swal.fire({
                                title: "Deleted!",
                                text: resp[1],
                                icon: "success"
                            }).then(function(){
                                window.location.reload();
                            })
                            
                        }
                        else{
                            Swal.fire({
                                title: "Failed!",
                                text: resp[1],
                                icon: "error"
                            });
                        }
                    }
                });
                
            }
            });
    }
</script>

<?php echo $this->endSection(); ?>