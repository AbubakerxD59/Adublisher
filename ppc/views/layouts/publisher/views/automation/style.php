<style>
    button.on_off {
        color: #fff !important;
    }

    button.on_off:hover {
        color: #111 !important;
    }

    .image-popup-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 97%;
        height: 97%;
        background: rgba(0, 0, 0, 0.7);
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }

    .image-popup-content {
        text-align: center;
        position: relative;
    }

    .close-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 24px;
        color: #fff;
        cursor: pointer;
    }

    #popupImage {
        max-width: 90%;
        max-height: 90%;
    }

    .image-popup-fit-width:hover {
        cursor: pointer;
    }

    .automation-socials {
        border: 1px solid #d7dfe3;
        border-radius: 4px;
        padding: 6px;
        -webkit-box-shadow: 0px 5px 20px rgba(0, 0, 0, 0.05);
        box-shadow: 0px 5px 20px rgba(0, 0, 0, 0.05);
    }

    /* Border color based on active state */
    .automation-socials.active#rss {
        border-color: #f78422;
    }

    .automation-socials.active#shopify {
        border-color: #94be46;
    }

    .automation-socials.active#youtube {
        border-color: #ff0000;
    }

    /* Hover */
    .automation-socials:hover {
        cursor: pointer;
    }

    .btn-info,
    .btn-info.disabled {
        background: #1e88e5;
        border: 1px solid #1e88e5;
        -webkit-transition: 0.2s ease-in;
        -o-transition: 0.2s ease-in;
        transition: 0.2s ease-in;
        font-size: 14px;
        padding: 8px 18px;
        border-radius: 5px;
        height: auto;
    }
</style>