<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'CodeIgniter App' ?></title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
            var elems = document.querySelectorAll('select');
            var instances = M.FormSelect.init(elems);
        });
    </script>
    <script src="https://malsup.github.io/jquery.form.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    
    
</head>
<body>

    <div class="container">
    <?php echo $this->renderSection('content'); ?>
    </div>

    

    <script>
        $(document).ready(function(){

            var reg_btn = $("#register_btn");
            var frm = $("#register_form");

            reg_btn.on('click',function(){
                frm.ajaxForm({
                    beforeSend: function(){
                        reg_btn.prop('disabled',true);
                    },
                    success:function(data){
                        reg_btn.prop('disabled',false);
                        var resp = data.split('::');
                        if(resp[0]==200){
                            Swal.fire({
                                title: "Good job!",
                                text: resp[1],
                                icon: "success"
                            }).then(function(){
                                window.location= 'list';
                            })

                        }
                        else{
                            Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: resp[1],
                            });
                        }
                    }
                });
            })


            

        });

    </script>

</body>
</html>