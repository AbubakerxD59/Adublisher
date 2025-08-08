<style>
    webhighlights-link-preview {
        display: flex;
        width: 530px;
        margin-top: 10px;
    }

    @media (min-width: 600px) {
        webhighlights-link-preview {
            margin: 10px 0px;
            border-radius: 10px;
        }
    }

    webhighlights-link-preview:hover {
        background: rgb(245, 248, 250);
        border-color: #8899a680;
    }

    div.overall {
        border: 1px solid #bcbcbc;
    }

    div.connected {
        margin-left: 5px;
        border-right: 1px solid #bcbcbc;
        text-align: center;
        padding: 5px;
    }

    div.connected img {
        margin-bottom: 8px !important;
    }

    div.disconnect {
        border-top: 1px solid #bcbcbc;
    }

    @media all and (max-width: 600px) {
        div.connected span {
            font-size: 23px
        }

        div.overall small {
            font-size: 15px
        }

        div.disconnect h6 {
            font-size: 18px
        }

    }

    @media all and (max-width: 540px) {
        div.overall small {
            font-size: 18px
        }

        div.disconnect h6 {
            font-size: 20px
        }

        div.disconnect button {
            font-size: 20px
        }
    }

    @media all and (max-width: 400px) {
        div.overall small {
            font-size: 24px
        }

        div.connected img {
            width: 50px !important;
            height: 50px !important;
        }

        div.disconnect h6 {
            font-size: 28px
        }

        div.disconnect button {
            font-size: 25px
        }
    }

    .dropzone {
        border: 2px dashed #d9d9d9 !important;
    }

    .dropzone .dz-preview .dz-error-message {
        color: white !important;
    }

    .dz-remove {
        display: inline-block !important;
        width: 1.2em;
        height: 1.2em;

        position: absolute;
        top: 5px;
        right: 5px;
        z-index: 1000;

        font-size: 1.2em !important;
        line-height: 1em;

        text-align: center;
        font-weight: bold;
        border: 1px solid gray !important;
        border-radius: 1.2em;
        color: gray;
        background-color: white;
        opacity: .5;

    }

    .dz-remove:hover {
        text-decoration: none !important;
        opacity: 1;
    }

    .mt-100 {
        margin-top: 100px
    }

    body {
        color: #514B64;
    }

    /* modals */
    .modal:nth-of-type(even) {
        z-index: 1052 !important;
    }

    .mfp-wrap {
        z-index: 99999;
    }

    .channel-button {
        position: relative;
        color: #111 !important;
    }

    .delete-button {
        position: relative;
        right: -7px;
        cursor: pointer;
        /* padding: 0; */
    }

    span.hover:hover {
        cursor: pointer;
    }
</style>