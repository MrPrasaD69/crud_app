<?php echo $this->extend('layout/main'); ?>
<?php echo $this->section('content'); ?>
    <div class="container">
        <h2>User Registration</h2>

            <div class="row">

                <form class="col s12" id="register_form" action="<?php echo base_url(); ?>user/manageData" method="POST">

                
                
                    <div class="input-field col s6">
                        <input type="hidden" id="id" name="id" value="<?php echo !empty($user_data) ? $user_data['user_id'] : ''; ?>" />
                        <input type="text" name="first_name" id="first_name" value="<?php echo !empty($user_data['first_name'])  ? $user_data['first_name'] : ''; ?>" required>
                        <label for="first_name">First Name</label>
                    </div>

                    <div class="input-field col s6">                
                        <input type="text" name="last_name" id="last_name" value="<?php echo !empty($user_data['last_name'])  ? $user_data['last_name'] : ''; ?>" required>
                        <label for="last_name">Last Name</label>
                    </div>

                    <div class="input-field col s6">
                        <select name="state_name" id="state_name" onChange="getCity(this.value);">
                            <option value="" >Select State</option>
                            <?php 
                            if(!empty($state_data)){
                                foreach($state_data as $state){
                                    ?>
                                        <option <?php echo !empty($user_data) && $state['state_id']==$user_data['state_id'] ? 'selected' : ''; ?> value="<?php echo !empty($state['state_id']) ? $state['state_id'] : '';?>"><?php echo !empty($state['state_name']) ? $state['state_name'] : '';?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                        <label>State</label>
                    </div>

                    <div class="input-field col s6">
                        <input type="hidden" name="user_city_id" id="user_city_id" value="<?php echo !empty($user_data['city_id']) ? $user_data['city_id'] : ''; ?>" />
                        <select name="city_name" id="city_name">
                            <option value="" >Select City</option>
                            <?php 
                            
                            if(!empty($city_data)){
                                foreach($city_data as $city)
                                {
                                 ?>
                                 <option <?php echo (!empty($user_data)) && $user_data['city_id']==$city['city_id'] ? 'selected' : ''; ?> value="<?php echo (!empty($city['city_id'])) ? $city['city_id'] : ''; ?>"><?php echo (!empty($city['city_name'])) ? $city['city_name'] : ''; ?></option>
                                 <?php   
                                }
                            }
                            ?>                     
                        </select>
                        <label>City</label>
                    </div>

                    <div class="input-field col s6">
                        <input type="text" name="username" id="username" value="<?php echo !empty($user_data['username'])  ? $user_data['username'] : ''; ?>" required>
                        <label for="username">Username</label>
                    </div>

                    <div class="input-field col s6">
                        <input type="password" name="password" id="password" value="<?php echo !empty($user_data) ? '*****' : ''; ?>" required  <?php echo !empty($user_data) ? 'readonly' : ''; ?> >
                        <label for="password">Password</label>
                    </div>                    

                    <div class="input-field col s12">
                        <button class="btn waves-effect waves-light" type="submit" id="register_btn"><?php echo !empty($user_data) ? 'Update' : 'Register'; ?></button>
                    </div>
                </form>

            </div>
        

    </div>

    <script>
        function getCity(id){
            var state_id = id;
            $.ajax({
                url:'<?php echo base_url(); ?>user/getCityData',
                data:'state_id='+state_id,
                success:function(data){
                    var resp = data.split('::');
                    if(resp[0]==200){
                        $('#city_name').html(resp[1]);
                        M.FormSelect.init($('#city_name'));
                    }
                }
            });

        }
    </script>
    <?php echo $this->endSection(); ?>