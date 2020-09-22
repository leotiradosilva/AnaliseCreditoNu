</section><!--content-->
</section><!--main-->



<!--        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.3/jquery.min.js" type="text/javascript"></script>-->
<!--        <script src="--><?php //echo CLOUDFRONT; ?><!--js/bootstrap/bootstrap.min.js"></script>-->
<!--        <script src="--><?php //echo CLOUDFRONT; ?><!--js/scroll/jquery.mCustomScrollbar.min.js"></script>-->

<!-- jQuery -->
<script src="<?php echo CLOUDFRONT; ?>superadmin/js/jquery.min.js"></script> <!-- jQuery Library -->
<script src="<?php echo CLOUDFRONT; ?>superadmin/js/jquery-ui.min.js"></script> <!-- jQuery UI -->
<script src="<?php echo CLOUDFRONT; ?>superadmin/js/jquery.easing.1.3.js"></script> <!-- jQuery Easing - Requirred for Lightbox + Pie Charts-->

<!-- Bootstrap -->
<script src="<?php echo CLOUDFRONT; ?>superadmin/js/bootstrap.min.js"></script>

<!--  Form Related -->
<script src="<?php echo CLOUDFRONT; ?>superadmin/js/icheck.js"></script> <!-- Custom Checkbox + Radio -->

<!-- UX -->
<script src="<?php echo CLOUDFRONT; ?>superadmin/js/scroll.min.js"></script> <!-- Custom Scrollbar -->

<!-- All JS functions -->
<script src="<?php echo CLOUDFRONT; ?>superadmin/js/functions.js"></script>

        <script src="<?php echo CLOUDFRONT; ?>js/site/script.js"></script>
        

        <?php
            if(!empty($js_link))
            {
                foreach($js_link as $cada){
                    echo '<script src="'.$cada.'" type="text/javascript"></script>';
                }
            }   
        
            if(!empty($js))
            {
                foreach($js as $cada){
                    echo '<script src="'.$cada.'" type="text/javascript"></script>';
                }
            }   
        ?>
       
            
        <script type="text/javascript">
            $(document).ready(function (e) {
                <?php if(isset($script_pagina)) echo $script_pagina; ?>


            });

                <?php if(isset($function_pagina)) echo $function_pagina; ?>
                


            jQuery.fn.preventDoubleSubmit = function() {
              jQuery(this).submit(function() {
                if (this.beenSubmitted)
                  return false;
                else
                  this.beenSubmitted = true;
              });
            };
        </script>


        <!-- MODAL ANEXOS -->
        <div class="modal fade bs-example-modal-lg" id="modal-anexo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel">Anexo</h4>
                    </div>
                    <div class="modal-body">
                        <div id="pdf"></div>
                        <div id="images"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-raised" data-dismiss="modal">Fechar</button>
                        <!--<button type="button" class="btn btn-info btn-raised" id="down_anexo"><i class="material-icons">file_download</i> Download Anexo</button>-->
                    </div>
                </div>
            </div>
        </div>
</body>
</html>