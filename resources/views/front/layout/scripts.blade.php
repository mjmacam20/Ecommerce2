<?php 
use App\Models\ProductsFilter;
$productFilters = ProductsFilter::productFilters();?>
<script>
$(document).ready(function(){
    $("#sort").on("change", function(){
        this.form.submit();
    });

    
});
</script>