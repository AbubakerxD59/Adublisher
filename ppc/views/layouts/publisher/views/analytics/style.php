<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.1.4/css/dataTables.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://adminlte.io/themes/v3/dist/css/adminlte.min.css?v=3.2.0">
<link rel="stylesheet" href="<?php echo ASSETURL . 'css/dashboard.css'; ?>">
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<style>
    body {
        font-family: 'Roboto' !important;
    }

    #recent_posts_table_info,
    .dt-info {
        display: none !important;
    }

    #recent_posts_table_processing {
        top: 10% !important;
    }

    .active_chart__bar::before {
        height: 100% !important;
    }

    #recent_posts_table>tbody>tr {
        cursor: pointer !important;
    }

    #get_recent_posts>tbody>tr {
        cursor: pointer !important;
    }

    .sm__lg__content {
        font-size: 14px !important;
        font-weight: 400 !important;
    }
</style>