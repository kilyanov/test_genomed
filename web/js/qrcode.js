const $form = $('#js-qr-code-form');
const $qrContainerLink = $('#js-qr-code-link');
const $qrContainerImage = $('#js-qr-code-image');
$form.on('beforeSubmit', function() {
    const data = $form.serialize();
    $qrContainerLink.html();
    $qrContainerImage.html();
    $.ajax({
        url: $form.attr('url'),
        format: 'json',
        type: 'POST',
        data: data,
        success: function (data) {
            if (data.error === true) {
                $qrContainerLink.html(data.massage);
            }
            else {
                let image = document.createElement('img');
                image.src = data.qrCode;
                $qrContainerLink.html(data.url)
                $qrContainerImage.html(image);
            }

        },
        error: function(jqXHR, errMsg) {
            console.log(errMsg)
        }
    });
    return false; // предотвращение отправки по умолчанию
});