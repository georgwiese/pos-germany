<script type="text/javascript">
    
    $(function(){
        <?php
            foreach ($buttonsets as $set) {
                echo "$('#" . $set . "').buttonset();\n";
            }
        ?>
    })
</script>
