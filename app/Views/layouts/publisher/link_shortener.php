<style>
    .dt-paging {
        display: none !important;
    }

    .newsletter-form {
        position: relative;
    }

    .newsletter-form input {
        height: 50px;
        border-radius: 30px;
        padding-left: 20px;
        border: 0;
        font-size: 14px;
        font-weight: 500;
    }

    @media screen and (prefers-reduced-motion: reduce) {
        .form-control {
            transition: none;
        }
    }

    .newsletter-form button {
        padding: 0 20px;
        height: 50px;
        position: absolute;
        right: 0;
        top: 9px;
        border-radius: 30px;
        border: 0;
        background-color: #130f40;
        color: #fff;
    }

    .features-single {
        background-color: #fff;
        padding: 30px 20px 15px;
        -webkit-box-shadow: 0 0 30px rgba(0, 0, 0, 0.06);
        box-shadow: 0 0 30px rgba(0, 0, 0, 0.06);
        overflow: hidden;
        border-radius: 4px;
        border-bottom: 2px solid #1d46f5;
        margin: 0 0 30px;
    }

    #home-area .content {
        /* padding: 0 10%; */
        margin: 0 0 40px;
    }

    @media only screen and (min-width: 768px) and (max-width: 991px) {
        .features-single .content {
            width: 73%;
        }
    }

    .features-single .content {
        width: 75%;
        float: left;
    }

    @media only screen and (min-width: 768px) and (max-width: 991px) {
        .features-single .icon {
            width: 27%;
        }
    }

    .features-single .icon {
        width: 20%;
        float: left;
        margin: 8px 0 0;
        text-align: center;
        padding-right: 15px;
    }

    .pointer {
        cursor: pointer;
    }

    .features-single i {
        color: #1d46f5;
        font-size: 30px;
        display: inline-block;
        width: 65px;
        height: 65px;
        background-color: #f5f5ff;
        border-radius: 50%;
        line-height: 60px;
        -webkit-box-shadow: 0 0 10px rgba(29, 70, 245, 0.8);
        box-shadow: 0 0 10px rgba(29, 70, 245, 0.8);
        border: 3px solid #fff;
    }
</style>
<!--icofont css-->
<link rel="stylesheet" type="text/css" href="<?= LANDINGASSETS ?>/css/icofont.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.1.4/css/dataTables.dataTables.min.css">
<div class="page-wrapper">
    <div class="container-fluid">
        <div>
            <div>
                <div class="card simple-card">
                    <div class="card-body py-0">
                        <div class="row">
                            <?php echo loader(); ?>
                            <div class="col-lg-12 col-md-12">
                                <div class="newsletter-form mt-3">
                                    <div>
                                        <div class="row">
                                            <div class="col-lg-11">
                                                <div class="newsletter-form">
                                                    <form action="#" method="post" id="shorten_link">
                                                        <input type="url" id="url" class="form-control border" required
                                                            placeholder="Shorten your link">
                                                        <button type="submit" class="pr-5 pl-5">Shorten</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-2" id="shorted_link_container">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-xlg-12">
                                <div class="form-group">
                                    <table class="table table-stripped" id="short_urls">
                                        <thead>
                                            <tr>
                                                <th>Sr</th>
                                                <th>Link</th>
                                                <th>Short Url</th>
                                                <th>Published</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$this->load->view('templates/publisher/footer');
?>
<script type="text/javascript" src="https://cdn.datatables.net/2.1.4/js/dataTables.min.js"></script>
<script>
    $(document).ready(function () {
        // fetch recent post function
        var short_urls = $('#short_urls').DataTable({
            searching: false,
            ordering: false,
            serverSide: true,
            iDisplayLength: '25',
            ajax: {
                type: 'GET',
                url: '<?php echo SITEURL; ?>short_urls',
                complete: function () {
                    $("#preloader_ajax").hide();
                }
            },
            columnDefs: [{ width: 500, targets: 1 }],
            columns: [
                { data: 'sr' },
                { data: 'url' },
                { data: 'short_url' },
                { data: 'published' },
            ]
        });
        // ajax call for shortening the link
        $('#shorten_link').submit(function (e) {
            e.preventDefault();
            var url = $("#url").val();
            $('#preloader_ajax').show();
            $.ajax({
                type: "POST",
                url: "<?php echo SITEURL; ?>short_my_link",
                data: { 'url': url },
                dataType: "json",
                success: function (response) {
                    $("#shorted_link_container").html("");
                    if (response.status) {
                        console.log(response);
                        $("#shorted_link_container").html(
                            '<div class="col-md-11">' +
                            '<div class="features-single p-3 mb-2" >' +
                            '<div class="content mb-0 pl-4 pr-3 pt-1">' +
                            '<h4 class="click_to_copy pointer" title="copy shorten url" data-clipboard-text="' + response.link + '" >' + response.link + '</h4>' +
                            '<p style="color: #555;">' + url + '</p>' +
                            '</div>' +
                            '<div class="icon pr-0 click_to_copy pointer" title="copy shorten url" data-clipboard-text="' + response.link + '">' +
                            '<i class="icofont-copy"></i>' +
                            '</div>' +
                            '</div>' +
                            '</div>');
                        var clipboard = new ClipboardJS('.click_to_copy');
                        short_urls.ajax.reload();

                    } else {
                        $("#shorted_link_container").html(
                            '<div class="col-md-11">' +
                            '<div class="features-single p-3 mb-2" style="border-bottom: 2px solid #f44336;">' +
                            '<div class="content mb-0 pl-4 pr-3 pt-1">' +
                            '<h4 class="text-danger" >Something Went Wrong</h4>' +
                            '<p class="text-danger">' + response.message + '</p>' +
                            '</div>' +
                            '<div class="icon pr-0">' +
                            '<i class="icofont-error text-danger"></i>' +
                            '</div>' +
                            '</div>' +
                            '</div>');
                        $("#preloader_ajax").hide();
                    }
                },
                error: function () {
                    $("#preloader_ajax").hide();
                    alertbox("Error", "Nothing Has been changed, try again", "error");
                }
            });
        });
        $('.dt-length select').on('change', function () {
            $("#preloader_ajax").show();
        });
    });
</script>