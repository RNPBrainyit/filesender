<script type="text/javascript">

    var emailCache = '';

    // Validate FILE (with embedded calls to check filename and file-extension)
    function validate_file(id)
    {
        var isValid = true;
        var file = fileData[id];

        if (!validateFileName(file.name)) {
            isValid =  false;
        } else if (file.size < 1) {
            fileMsg('<?php echo lang('_INVALID_FILESIZE_ZERO') ?>');
            isValid =  false;
        } else if (file.size > maxHTML5UploadSize) {
            fileMsg('<?php echo lang('_INVALID_TOO_LARGE_1') ?> ' + readablizebytes(maxHTML5UploadSize) + '. <?php echo lang('_SELECT_ANOTHER_FILE') ?> ');
            isValid =  false;
        }

        if (isValid) {
            $('#dragfilestouploadcss').removeClass('errorglow');
            return true;
        } else {
            $('#dragfilestouploadcss').addClass('errorglow');
            return false;
        }
    }

    function validate_files() {

        if (n == -1) {
            // display message if a user enters all form details and selects upload without selecting a file
            // in theory this error should not appear as a browse button should not be visible without a file first being selected
            fileMsg('<?php echo lang('_SELECT_FILE') ?>');
            $('#dragfilestouploadcss').addClass('errorglow');
            return false;
        }

        for(var i = 0; i < n; i++) {
            if(!validate_file(i)) return false;
        }

        return true;
    }

    // HTML5 form Validation
    function validateForm() {

        processEmailSettings();
        // remove messages from any previous attempt
        hideMessages();
        var isValid = true;
        if (!validate_fileto()){
            isValid = false;
        }
        if (!validate_files()){
            isValid = false;
        }
        if (!validate_expiry()) {
            isValid = false;
        }
        if (!validate_aup()) {
            isValid = false;
        }

        if (!isValid) {
            statusMessage('There are validation errors on this page', 'red');
        } else {
            statusMessage('Your upload has started', 'green');
        }
        return isValid;
    }

    function constrainNumWebWorkers() {
        <?php
        $limit = 'undefined';
        if (isset($config['webWorkersLimit'])) {
            $limit = $config['webWorkersLimit'];
        }
        ?>

        var maxLimitWebWorkers = <?php echo $limit; ?>;
        var workerCount = $('#workerCount');
        if (maxLimitWebWorkers != 'undefined' && parseInt(workerCount.val()) > maxLimitWebWorkers) {
            workerCount.val(maxLimitWebWorkers);
        }
    }

    function checkFilesSelected() {
        return document.getElementById('fileToUpload').files[0] != null || document.getElementById('file_0') != null;
    }

    function disableToField(){
        emailCache = $('#fileto').val();
        $('#fileto').val($('#filefrom').val());
        $('#fileto').attr('disabled', 'disabled');
    }

    function reenableToField(){
        $('#fileto').val(emailCache);
        $('#fileto').removeAttr('disabled');
    }

    function processEmailSettings() {
        var emailBitString = '';
        $('#email-upload-complete').is(':checked') ? emailBitString+='1' : emailBitString+='0';
        $('#email-inform-download').is(':checked') ? emailBitString+='1' : emailBitString+='0';
        $('#email-inform-daily').is(':checked') ? emailBitString+='1' : emailBitString+='0';
        $('#email-enable-confirmation').is(':checked') ? emailBitString+='1' : emailBitString+='0';

        alert(emailBitString);
    }

</script>
