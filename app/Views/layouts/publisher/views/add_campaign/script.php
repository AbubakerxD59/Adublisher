<script src="<?= PublisherAssets ?>js/campaign_add.js"></script>
<script>
    function previewFile(input) {
        var file = $("input[type=file]").get(0).files[0];
        if (file) {
            var reader = new FileReader();
            console.log(reader.result);
            reader.onload = function() {
                $("#cpimagec").attr("src", reader.result);
            }
            reader.readAsDataURL(file);
        }
    }
</script>